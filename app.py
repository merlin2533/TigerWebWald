"""Entenbach Tiger - Flask Webapplikation."""
import hashlib
import os
import sqlite3
from functools import wraps
from io import BytesIO

from flask import (
    Flask,
    flash,
    redirect,
    render_template,
    request,
    send_from_directory,
    session,
    url_for,
)
from PIL import Image

app = Flask(__name__)
app.secret_key = "entenbachtiger-geheim-2024"

BASE_DIR = os.path.dirname(__file__)
DB_PATH = os.path.join(BASE_DIR, "tiger.db")
UPLOAD_DIR = os.path.join(BASE_DIR, "static", "uploads")
IMAGE_DIR = os.path.join(BASE_DIR, "static", "images")

# Bild-Optimierungseinstellungen
MAX_WIDTH = 1200
THUMB_WIDTH = 400
JPEG_QUALITY = 82


def get_db():
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn


def get_inhalt(seite, schluessel, standard=""):
    """Holt einen Textinhalt aus der Datenbank."""
    conn = get_db()
    row = conn.execute(
        "SELECT wert FROM inhalte WHERE seite = ? AND schluessel = ?",
        (seite, schluessel),
    ).fetchone()
    conn.close()
    return row["wert"] if row else standard


def get_alle_inhalte(seite):
    """Holt alle Inhalte einer Seite als Dict."""
    conn = get_db()
    rows = conn.execute(
        "SELECT schluessel, wert FROM inhalte WHERE seite = ?", (seite,)
    ).fetchall()
    conn.close()
    return {row["schluessel"]: row["wert"] for row in rows}


def get_bilder(seite, schluessel=None):
    """Holt Bilder fuer eine Seite/Kategorie."""
    conn = get_db()
    if schluessel:
        rows = conn.execute(
            "SELECT * FROM bilder WHERE seite = ? AND schluessel = ? ORDER BY reihenfolge",
            (seite, schluessel),
        ).fetchall()
    else:
        rows = conn.execute(
            "SELECT * FROM bilder WHERE seite = ? ORDER BY schluessel, reihenfolge",
            (seite,),
        ).fetchall()
    conn.close()
    return rows


def get_team():
    """Holt alle Team-Mitglieder."""
    conn = get_db()
    rows = conn.execute(
        "SELECT * FROM team ORDER BY reihenfolge"
    ).fetchall()
    conn.close()
    return rows


def bild_pfad(dateiname):
    """Gibt den Bildpfad zurueck - prueeft uploads/ und images/."""
    if os.path.exists(os.path.join(UPLOAD_DIR, dateiname)):
        return f"uploads/{dateiname}"
    return f"images/{dateiname}"


def optimiere_bild(bild_datei, dateiname):
    """Optimiert ein hochgeladenes Bild: Resize + Kompression + Thumbnail."""
    os.makedirs(UPLOAD_DIR, exist_ok=True)

    img = Image.open(bild_datei)

    # EXIF-Rotation korrigieren
    try:
        from PIL import ImageOps
        img = ImageOps.exif_transpose(img)
    except Exception:
        pass

    # In RGB konvertieren falls noetig
    if img.mode in ("RGBA", "P"):
        img = img.convert("RGB")

    # Hauptbild: max MAX_WIDTH breit
    if img.width > MAX_WIDTH:
        ratio = MAX_WIDTH / img.width
        neue_hoehe = int(img.height * ratio)
        img = img.resize((MAX_WIDTH, neue_hoehe), Image.LANCZOS)

    # Speichern als optimiertes JPEG
    name, _ = os.path.splitext(dateiname)
    optimierter_name = f"{name}.jpg"
    pfad = os.path.join(UPLOAD_DIR, optimierter_name)
    img.save(pfad, "JPEG", quality=JPEG_QUALITY, optimize=True)

    # Thumbnail erstellen
    thumb = img.copy()
    if thumb.width > THUMB_WIDTH:
        ratio = THUMB_WIDTH / thumb.width
        neue_hoehe = int(thumb.height * ratio)
        thumb = thumb.resize((THUMB_WIDTH, neue_hoehe), Image.LANCZOS)

    thumb_name = f"{name}_thumb.jpg"
    thumb_pfad = os.path.join(UPLOAD_DIR, thumb_name)
    thumb.save(thumb_pfad, "JPEG", quality=75, optimize=True)

    return optimierter_name


# --- Bestehende Bilder beim Start optimieren ---
def optimiere_bestehende_bilder():
    """Erstellt Thumbnails fuer alle bestehenden Bilder."""
    if not os.path.exists(IMAGE_DIR):
        return
    for datei in os.listdir(IMAGE_DIR):
        if not datei.lower().endswith((".jpg", ".jpeg", ".png")):
            continue
        name, _ = os.path.splitext(datei)
        thumb_pfad = os.path.join(IMAGE_DIR, f"{name}_thumb.jpg")
        if os.path.exists(thumb_pfad):
            continue
        try:
            img = Image.open(os.path.join(IMAGE_DIR, datei))
            if img.mode in ("RGBA", "P"):
                img = img.convert("RGB")
            try:
                from PIL import ImageOps
                img = ImageOps.exif_transpose(img)
            except Exception:
                pass
            if img.width > THUMB_WIDTH:
                ratio = THUMB_WIDTH / img.width
                neue_hoehe = int(img.height * ratio)
                img = img.resize((THUMB_WIDTH, neue_hoehe), Image.LANCZOS)
            img.save(thumb_pfad, "JPEG", quality=75, optimize=True)
        except Exception as e:
            print(f"Fehler bei Thumbnail fuer {datei}: {e}")


# --- Auth-Decorator ---
def admin_erforderlich(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        if not session.get("admin_eingeloggt"):
            return redirect(url_for("admin_login"))
        return f(*args, **kwargs)
    return decorated


# --- Template-Kontext ---
@app.context_processor
def inject_helpers():
    return {
        "get_inhalt": get_inhalt,
        "get_bilder": get_bilder,
        "bild_pfad": bild_pfad,
    }


# ===================== OEFFENTLICHE SEITEN =====================

@app.route("/")
def startseite():
    inhalte = get_alle_inhalte("startseite")
    return render_template("startseite.html", inhalte=inhalte)


@app.route("/ueber-uns")
def ueber_uns():
    inhalte = get_alle_inhalte("ueber_uns")
    team = get_team()
    return render_template("ueber_uns.html", inhalte=inhalte, team=team)


@app.route("/raeumlichkeiten")
def raeumlichkeiten():
    bilder = get_bilder("raeumlichkeiten")
    # Gruppiere nach Schluessel
    kategorien = {}
    for b in bilder:
        key = b["schluessel"]
        if key not in kategorien:
            kategorien[key] = []
        kategorien[key].append(b)

    kategorie_namen = {
        "spielzimmer": "Spielzimmer",
        "bewegungsraum": "Bewegungsraum",
        "schlafraum": "Schlafraum",
        "garderobe": "Garderobe",
        "essbereich": "Essbereich",
        "kueche": "Kueche",
        "wickelbereich": "Wickelbereich",
    }
    return render_template(
        "raeumlichkeiten.html",
        kategorien=kategorien,
        kategorie_namen=kategorie_namen,
    )


@app.route("/konzept")
def konzept():
    inhalte = get_alle_inhalte("konzept")
    return render_template("konzept.html", inhalte=inhalte)


@app.route("/kontakt")
def kontakt():
    inhalte = get_alle_inhalte("kontakt")
    return render_template("kontakt.html", inhalte=inhalte)


# ===================== ADMIN-BEREICH =====================

@app.route("/admin/login", methods=["GET", "POST"])
def admin_login():
    if request.method == "POST":
        benutzer = request.form.get("benutzername", "")
        passwort = request.form.get("passwort", "")
        pw_hash = hashlib.sha256(passwort.encode()).hexdigest()

        conn = get_db()
        admin = conn.execute(
            "SELECT * FROM admin WHERE benutzername = ? AND passwort_hash = ?",
            (benutzer, pw_hash),
        ).fetchone()
        conn.close()

        if admin:
            session["admin_eingeloggt"] = True
            flash("Erfolgreich eingeloggt!", "erfolg")
            return redirect(url_for("admin_dashboard"))
        else:
            flash("Falscher Benutzername oder Passwort.", "fehler")

    return render_template("admin/login.html")


@app.route("/admin/logout")
def admin_logout():
    session.pop("admin_eingeloggt", None)
    flash("Abgemeldet.", "info")
    return redirect(url_for("startseite"))


@app.route("/admin")
@admin_erforderlich
def admin_dashboard():
    conn = get_db()
    seiten = conn.execute(
        "SELECT DISTINCT seite FROM inhalte ORDER BY seite"
    ).fetchall()
    team = get_team()
    conn.close()
    return render_template("admin/dashboard.html", seiten=seiten, team=team)


@app.route("/admin/inhalte/<seite>", methods=["GET", "POST"])
@admin_erforderlich
def admin_inhalte(seite):
    conn = get_db()

    if request.method == "POST":
        for schluessel in request.form:
            wert = request.form[schluessel]
            conn.execute(
                "UPDATE inhalte SET wert = ? WHERE seite = ? AND schluessel = ?",
                (wert, seite, schluessel),
            )
        conn.commit()
        flash(f"Inhalte fuer '{seite}' gespeichert!", "erfolg")

    inhalte = conn.execute(
        "SELECT * FROM inhalte WHERE seite = ? ORDER BY id", (seite,)
    ).fetchall()
    conn.close()
    return render_template("admin/inhalte.html", seite=seite, inhalte=inhalte)


@app.route("/admin/bilder/<seite>", methods=["GET", "POST"])
@admin_erforderlich
def admin_bilder(seite):
    conn = get_db()

    if request.method == "POST":
        schluessel = request.form.get("schluessel", "")
        alt_text = request.form.get("alt_text", "")
        datei = request.files.get("bild")

        if datei and datei.filename:
            # Bild optimieren und speichern
            dateiname = optimiere_bild(datei, datei.filename)
            conn.execute(
                "INSERT INTO bilder (seite, schluessel, dateiname, alt_text, reihenfolge) VALUES (?, ?, ?, ?, ?)",
                (seite, schluessel, dateiname, alt_text, 99),
            )
            conn.commit()
            flash(f"Bild '{dateiname}' hochgeladen und optimiert!", "erfolg")

    bilder = conn.execute(
        "SELECT * FROM bilder WHERE seite = ? ORDER BY schluessel, reihenfolge",
        (seite,),
    ).fetchall()
    conn.close()
    return render_template("admin/bilder.html", seite=seite, bilder=bilder)


@app.route("/admin/bild/loeschen/<int:bild_id>", methods=["POST"])
@admin_erforderlich
def admin_bild_loeschen(bild_id):
    conn = get_db()
    bild = conn.execute("SELECT * FROM bilder WHERE id = ?", (bild_id,)).fetchone()
    if bild:
        seite = bild["seite"]
        conn.execute("DELETE FROM bilder WHERE id = ?", (bild_id,))
        conn.commit()
        flash("Bild geloescht.", "info")
    else:
        seite = "raeumlichkeiten"
    conn.close()
    return redirect(url_for("admin_bilder", seite=seite))


@app.route("/admin/team", methods=["GET", "POST"])
@admin_erforderlich
def admin_team():
    conn = get_db()

    if request.method == "POST":
        aktion = request.form.get("aktion")

        if aktion == "aktualisieren":
            for key in request.form:
                if key.startswith("name_"):
                    mid = key.split("_")[1]
                    conn.execute(
                        "UPDATE team SET name=?, rolle=?, beschreibung=? WHERE id=?",
                        (
                            request.form.get(f"name_{mid}"),
                            request.form.get(f"rolle_{mid}"),
                            request.form.get(f"beschreibung_{mid}"),
                            mid,
                        ),
                    )
            conn.commit()
            flash("Team aktualisiert!", "erfolg")

        elif aktion == "bild_hochladen":
            mid = request.form.get("mitglied_id")
            datei = request.files.get("bild")
            if datei and datei.filename:
                dateiname = optimiere_bild(datei, f"team_{mid}_{datei.filename}")
                conn.execute(
                    "UPDATE team SET bild = ? WHERE id = ?", (dateiname, mid)
                )
                conn.commit()
                flash("Teambild aktualisiert!", "erfolg")

    team = conn.execute("SELECT * FROM team ORDER BY reihenfolge").fetchall()
    conn.close()
    return render_template("admin/team.html", team=team)


@app.route("/admin/passwort", methods=["GET", "POST"])
@admin_erforderlich
def admin_passwort():
    if request.method == "POST":
        altes_pw = request.form.get("altes_passwort", "")
        neues_pw = request.form.get("neues_passwort", "")
        altes_hash = hashlib.sha256(altes_pw.encode()).hexdigest()
        neues_hash = hashlib.sha256(neues_pw.encode()).hexdigest()

        conn = get_db()
        admin = conn.execute(
            "SELECT * FROM admin WHERE passwort_hash = ?", (altes_hash,)
        ).fetchone()

        if admin and neues_pw:
            conn.execute(
                "UPDATE admin SET passwort_hash = ? WHERE id = ?",
                (neues_hash, admin["id"]),
            )
            conn.commit()
            flash("Passwort geaendert!", "erfolg")
        else:
            flash("Altes Passwort falsch.", "fehler")
        conn.close()

    return render_template("admin/passwort.html")


# ===================== START =====================

if __name__ == "__main__":
    # Datenbank initialisieren falls noetig
    if not os.path.exists(DB_PATH):
        import init_db
        init_db.init()

    # Thumbnails fuer bestehende Bilder erstellen
    optimiere_bestehende_bilder()

    print("\n  Entenbach Tiger Website")
    print("  =======================")
    print("  Website:  http://localhost:5000")
    print("  Admin:    http://localhost:5000/admin")
    print("  Login:    admin / tiger2024\n")

    app.run(debug=True, port=5000)
