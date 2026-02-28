"""Initialisiert die SQLite-Datenbank mit Standardinhalten."""
import sqlite3
import os
import hashlib

DB_PATH = os.path.join(os.path.dirname(__file__), "tiger.db")


def get_db():
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn


def init():
    conn = get_db()
    c = conn.cursor()

    # Tabelle fuer Textinhalte
    c.execute("""
        CREATE TABLE IF NOT EXISTS inhalte (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            seite TEXT NOT NULL,
            schluessel TEXT NOT NULL,
            wert TEXT NOT NULL,
            typ TEXT DEFAULT 'text',
            UNIQUE(seite, schluessel)
        )
    """)

    # Tabelle fuer Bilder
    c.execute("""
        CREATE TABLE IF NOT EXISTS bilder (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            seite TEXT NOT NULL,
            schluessel TEXT NOT NULL,
            dateiname TEXT NOT NULL,
            alt_text TEXT DEFAULT '',
            reihenfolge INTEGER DEFAULT 0,
            UNIQUE(seite, schluessel, dateiname)
        )
    """)

    # Tabelle fuer Team-Mitglieder
    c.execute("""
        CREATE TABLE IF NOT EXISTS team (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            rolle TEXT DEFAULT '',
            beschreibung TEXT DEFAULT '',
            bild TEXT DEFAULT '',
            reihenfolge INTEGER DEFAULT 0
        )
    """)

    # Admin-Benutzer
    c.execute("""
        CREATE TABLE IF NOT EXISTS admin (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            benutzername TEXT UNIQUE NOT NULL,
            passwort_hash TEXT NOT NULL
        )
    """)

    # --- Standarddaten einfuegen ---

    # Admin-Benutzer (Standard: admin / tiger2024)
    pw_hash = hashlib.sha256("tiger2024".encode()).hexdigest()
    c.execute(
        "INSERT OR IGNORE INTO admin (benutzername, passwort_hash) VALUES (?, ?)",
        ("admin", pw_hash),
    )

    # Team-Mitglieder
    team = [
        (
            "Verena Schall",
            "Paedagogische Fachkraft",
            "Verena begleitet die Kinder mit viel Herz und Erfahrung. Als ausgebildete Erzieherin liegt ihr besonders die individuelle Foerderung jedes Kindes am Herzen. Mit ihrer warmherzigen Art schafft sie eine Atmosphaere, in der sich die Kleinen sicher und geborgen fuehlen.",
            "",
            1,
        ),
        (
            "Melanie Cerny",
            "Paedagogische Fachkraft",
            "Melanie bringt Kreativitaet und Lebensfreude in den Alltag der Kinder. Ob beim gemeinsamen Basteln, Singen oder Entdecken der Natur \u2013 sie versteht es, die Neugier der Kinder zu wecken und sie in ihrer Entwicklung liebevoll zu unterstuetzen.",
            "",
            2,
        ),
        (
            "Sandra Rein",
            "Paedagogische Fachkraft",
            "Sandra ist die ruhige Kraft im Team. Mit Geduld und Einfuehlungsvermoegen begleitet sie besonders die Eingewoehnung neuer Kinder. Ihr liegt ein strukturierter Tagesablauf am Herzen, der den Kindern Sicherheit und Orientierung gibt.",
            "",
            3,
        ),
    ]
    for name, rolle, beschreibung, bild, reihenfolge in team:
        c.execute(
            "INSERT OR IGNORE INTO team (name, rolle, beschreibung, bild, reihenfolge) VALUES (?, ?, ?, ?, ?)",
            (name, rolle, beschreibung, bild, reihenfolge),
        )

    # Seiteninhalte
    inhalte = [
        # Startseite
        ("startseite", "hero_titel", "Willkommen bei den Entenbach Tigern", "text"),
        (
            "startseite",
            "hero_untertitel",
            "Kindertagespflege im historischen Fachwerkhaus in Walddorfh\u00e4slach",
            "text",
        ),
        (
            "startseite",
            "intro_text",
            "Im Herzen von Walddorf, im wundersch\u00f6nen Alten Notariat, bieten wir 9 Betreuungspl\u00e4tze f\u00fcr Kinder unter 3 Jahren. Unser erfahrenes Team aus drei p\u00e4dagogischen Fachkr\u00e4ften begleitet Ihr Kind mit Herz, Kompetenz und viel Freude durch den Tag.",
            "text",
        ),
        (
            "startseite",
            "cta_text",
            "Lernen Sie uns und unsere R\u00e4umlichkeiten kennen!",
            "text",
        ),
        # Ueber uns
        (
            "ueber_uns",
            "titel",
            "\u00dcber die Entenbach Tiger",
            "text",
        ),
        (
            "ueber_uns",
            "text_1",
            "Die Entenbach Tiger sind eine Kindertagespflege im U3-Bereich, angeschlossen an den Tagesmutterverein Reutlingen \u2013 dabei jedoch komplett eigenst\u00e4ndig in unserer p\u00e4dagogischen Arbeit. Wir betreuen bis zu 9 Kinder in den liebevoll gestalteten R\u00e4umlichkeiten im Dachgeschoss des historischen Alten Notariats.",
            "text",
        ),
        (
            "ueber_uns",
            "text_2",
            "Unser Ziel ist es, jedem Kind eine sichere, geborgene und anregende Umgebung zu bieten, in der es sich in seinem eigenen Tempo entwickeln kann. Mit viel Herz und p\u00e4dagogischer Kompetenz begleiten wir die Kinder durch ihren Tag.",
            "text",
        ),
        (
            "ueber_uns",
            "oeffnungszeiten_1",
            "Modell 1: Montag\u2013Donnerstag 07:30\u201315:00 Uhr, Freitag 07:30\u201312:30 Uhr (5 Pl\u00e4tze)",
            "text",
        ),
        (
            "ueber_uns",
            "oeffnungszeiten_2",
            "Modell 2: Montag\u2013Freitag 07:30\u201312:30 Uhr (4 Pl\u00e4tze)",
            "text",
        ),
        # Konzept
        (
            "konzept",
            "titel",
            "Unser P\u00e4dagogisches Konzept",
            "text",
        ),
        (
            "konzept",
            "intro",
            "Unsere p\u00e4dagogische Arbeit orientiert sich an drei zentralen Zielen, die die Grundlage f\u00fcr die ganzheitliche Entwicklung Ihres Kindes bilden.",
            "text",
        ),
        (
            "konzept",
            "bindung_titel",
            "Sichere Bindung",
            "text",
        ),
        (
            "konzept",
            "bindung_text",
            "Eine zuverl\u00e4ssige und einf\u00fchlsame Beziehung ist die Basis f\u00fcr emotionale Sicherheit und Lernbereitschaft. Durch eine respektvolle Haltung, Kommunikation auf Augenh\u00f6he und feste Bezugspersonen entsteht Vertrauen. Kinder, die sich sicher f\u00fchlen, trauen sich, ihre Umgebung zu erkunden und Neues auszuprobieren.",
            "text",
        ),
        (
            "konzept",
            "struktur_titel",
            "Rituale & Strukturen",
            "text",
        ),
        (
            "konzept",
            "struktur_text",
            "Ein strukturierter Tagesablauf mit wiederkehrenden Ritualen gibt Orientierung und Sicherheit. Feste Bestandteile des Tages sind gemeinsame Mahlzeiten, der Kinderkreis, Freispielphasen sowie Ruhe- und Schlafzeiten. Zuverl\u00e4ssige Strukturen unterst\u00fctzen die emotionale Stabilit\u00e4t.",
            "text",
        ),
        (
            "konzept",
            "selbststaendigkeit_titel",
            "Selbstst\u00e4ndigkeit",
            "text",
        ),
        (
            "konzept",
            "selbststaendigkeit_text",
            'Wir ermutigen die Kinder, Dinge eigenst\u00e4ndig auszuprobieren und kleine Aufgaben selbst zu bew\u00e4ltigen. Im Sinne von Maria Montessori \u2013 "Hilf mir, es selbst zu tun" \u2013 begleiten wir die Kinder unterst\u00fctzend, ohne ihnen Aufgaben abzunehmen.',
            "text",
        ),
        (
            "konzept",
            "eingewoehnung_titel",
            "Sanfte Eingew\u00f6hnung",
            "text",
        ),
        (
            "konzept",
            "eingewoehnung_text",
            "Wir orientieren uns am Berliner Eingew\u00f6hnungsmodell. In der Regel dauert die Eingew\u00f6hnung zwei bis vier Wochen. Da jedes Kind individuell reagiert, kann dieser Zeitraum k\u00fcrzer oder l\u00e4nger sein. Der Betreuungsvertrag wird erst nach erfolgreicher Eingew\u00f6hnung geschlossen.",
            "text",
        ),
        # Kontakt
        (
            "kontakt",
            "titel",
            "Kontakt & Besichtigung",
            "text",
        ),
        (
            "kontakt",
            "text",
            "Haben wir Ihr Interesse geweckt? Wir freuen uns darauf, Sie und Ihr Kind kennenzulernen! Vereinbaren Sie gerne einen Besichtigungstermin \u2013 telefonisch oder per E-Mail.",
            "text",
        ),
        ("kontakt", "telefon", "07127/9266-850", "text"),
        ("kontakt", "email", "info@entenbachtiger.de", "text"),
        (
            "kontakt",
            "adresse",
            "Br\u00fchlstr. 272, 72141 Walddorfh\u00e4slach",
            "text",
        ),
    ]
    for seite, schluessel, wert, typ in inhalte:
        c.execute(
            "INSERT OR IGNORE INTO inhalte (seite, schluessel, wert, typ) VALUES (?, ?, ?, ?)",
            (seite, schluessel, wert, typ),
        )

    # Bilder-Zuordnungen
    bilder = [
        ("startseite", "hero", "Haus.jpg", "Fachwerkhaus der Entenbach Tiger", 1),
        ("startseite", "logo", "Logo.jpg", "Logo Entenbach Tiger", 1),
        (
            "raeumlichkeiten",
            "spielzimmer",
            "Raum1.jpg",
            "Spielzimmer mit Weltkarte-Teppich",
            1,
        ),
        (
            "raeumlichkeiten",
            "spielzimmer",
            "Raum2.jpg",
            "Bewegungs- und Sinnesraum",
            2,
        ),
        (
            "raeumlichkeiten",
            "bewegungsraum",
            "Raum3.jpg",
            "Bewegungsraum mit Schaumstoffelementen",
            1,
        ),
        (
            "raeumlichkeiten",
            "bewegungsraum",
            "Raum4.jpg",
            "Bewegungslandschaft",
            2,
        ),
        ("raeumlichkeiten", "schlafraum", "Raum5.jpg", "Schlafraum", 1),
        ("raeumlichkeiten", "garderobe", "Raum6.jpg", "Garderobe", 1),
        (
            "raeumlichkeiten",
            "essbereich",
            "Essbereich.jpg",
            "Essbereich mit Kinderstuehlen",
            1,
        ),
        ("raeumlichkeiten", "essbereich", "Essbereich2.jpg", "Essbereich", 2),
        (
            "raeumlichkeiten",
            "kueche",
            "K\u00fcche.jpg",
            "Moderne Kueche mit Holzbalken",
            1,
        ),
        (
            "raeumlichkeiten",
            "wickelbereich",
            "Wickelbereich.jpg",
            "Wickelbereich mit Treppe",
            1,
        ),
        (
            "raeumlichkeiten",
            "wickelbereich",
            "Wickelbereich2.jpg",
            "Kinderbad mit Waschbecken",
            2,
        ),
        (
            "aussenbereich",
            "garten",
            "Aue\u00dfen1.jpg",
            "Aussenbereich mit Spielplatz",
            1,
        ),
        (
            "aussenbereich",
            "garten",
            "Aue\u00dfen2.jpg",
            "Garten mit Sonnensegel",
            2,
        ),
        (
            "aussenbereich",
            "bollerwagen",
            "Ger\u00e4t.jpg",
            "Bollerwagen fuer Ausfluege",
            1,
        ),
    ]
    for seite, schluessel, dateiname, alt_text, reihenfolge in bilder:
        c.execute(
            "INSERT OR IGNORE INTO bilder (seite, schluessel, dateiname, alt_text, reihenfolge) VALUES (?, ?, ?, ?, ?)",
            (seite, schluessel, dateiname, alt_text, reihenfolge),
        )

    conn.commit()
    conn.close()
    print("Datenbank erfolgreich initialisiert!")


if __name__ == "__main__":
    init()
