# EntenbachTigeR - Kindertagespflege Website

Website für die Kindertagespflege **"EntenbachTigeR"** in Walddorfhäslach.
Die Einrichtung befindet sich im historischen Alten Notariat (Fachwerkhaus) und bietet 9 Betreuungsplätze für Kinder unter 3 Jahren.

## Technologie

- **PHP 8+** (kein Framework, kein Composer nötig)
- **SQLite3** (Datenbank, eine einzelne Datei)
- **GD-Library** (Bildoptimierung, in PHP enthalten)
- **Apache** mit mod_rewrite (.htaccess)

## Projektstruktur

```
├── index.php                 # Router für öffentliche Seiten
├── admin.php                 # Admin-Bereich (alle Routen)
├── init_db.php               # Datenbank-Initialisierung
├── .htaccess                 # URL-Rewriting + DB-Schutz
├── tiger.db                  # SQLite-Datenbank (wird generiert)
│
├── includes/
│   ├── db.php                # PDO-Verbindung + Hilfsfunktionen
│   ├── auth.php              # Session, Login-Check, Flash-Messages
│   └── images.php            # Bildoptimierung (Resize, Thumbnails)
│
├── templates/
│   ├── base.php              # Basis-Layout (Navigation, Footer)
│   ├── startseite.php        # Startseite mit Hero, Intro, Highlights
│   ├── ueber_uns.php         # Über uns + Öffnungszeiten + Team
│   ├── raeumlichkeiten.php   # Raumgalerie mit Lightbox
│   ├── konzept.php           # Pädagogisches Konzept + Tagesablauf
│   ├── kontakt.php           # Kontaktdaten + Google Maps
│   └── admin/
│       ├── login.php         # Admin-Login
│       ├── dashboard.php     # Übersicht
│       ├── inhalte.php       # Texte bearbeiten
│       ├── bilder.php        # Bilder hochladen/löschen
│       ├── team.php          # Team-Infos + Fotos
│       └── passwort.php      # Passwort ändern
│
└── static/
    ├── css/style.css         # Gesamtes Styling (responsive)
    ├── js/main.js            # Navigation, Scroll-Animationen, Lightbox
    ├── images/               # Originalbilder + Thumbnails
    └── uploads/              # Hochgeladene Bilder (Admin)
```

## Installation

### Voraussetzungen

- PHP 8.0 oder höher
- PHP-Extensions: `pdo_sqlite`, `gd`, `exif` (meist standardmäßig aktiv)
- Apache mit `mod_rewrite` (für saubere URLs)

### Lokal starten

```bash
# 1. Repository klonen
git clone https://github.com/merlin2533/TigerWebWald.git
cd TigerWebWald

# 2. Datenbank initialisieren
php init_db.php

# 3. PHP-Entwicklungsserver starten
php -S localhost:8000

# 4. Browser öffnen: http://localhost:8000
```

### Auf Plesk / Webhosting deployen

1. **Dateien hochladen** (FTP/SFTP oder Git-Deploy):
   - Alle PHP-Dateien, `includes/`, `templates/`, `static/`
   - `.htaccess` nicht vergessen

2. **Datenbank erstellen**:
   ```bash
   php init_db.php
   ```
   Alternativ: bestehende `tiger.db` hochladen.

3. **Berechtigungen setzen**:
   ```bash
   chmod 664 tiger.db
   chmod 775 static/uploads/
   ```

4. **mod_rewrite** muss aktiv sein (bei Apache Standard).

5. Fertig! Die Website ist erreichbar.

## Öffentliche Seiten

| URL | Beschreibung |
|-----|-------------|
| `/` | Startseite mit Hero-Bereich, Intro und Highlights |
| `/ueber-uns` | Über die Einrichtung, Öffnungszeiten, Team |
| `/raeumlichkeiten` | Bildergalerie aller Räume mit Lightbox |
| `/konzept` | Pädagogisches Konzept, Eingewöhnung, Tagesablauf |
| `/kontakt` | Telefon, E-Mail, Adresse, Google Maps |

## Admin-Bereich

| URL | Funktion |
|-----|----------|
| `/admin` | Dashboard (Übersicht) |
| `/admin/login` | Anmeldung |
| `/admin/inhalte/{seite}` | Texte einer Seite bearbeiten |
| `/admin/bilder/{seite}` | Bilder hochladen / löschen |
| `/admin/team` | Team-Infos und Fotos verwalten |
| `/admin/passwort` | Admin-Passwort ändern |

### Standard-Login

- **Benutzer:** `admin`
- **Passwort:** `tiger2024`

> Bitte nach dem ersten Login das Passwort ändern!

## Datenbank

SQLite-Datenbank (`tiger.db`) mit 4 Tabellen:

| Tabelle | Inhalt |
|---------|--------|
| `inhalte` | Texte aller Seiten (Seite + Schlüssel → Wert) |
| `bilder` | Bildzuordnungen (Seite, Kategorie, Dateiname, Alt-Text) |
| `team` | Team-Mitglieder (Name, Rolle, Beschreibung, Foto) |
| `admin` | Admin-Zugangsdaten (Benutzername, SHA256-Passwort-Hash) |

## Bildverarbeitung

Hochgeladene Bilder werden automatisch optimiert:

- **EXIF-Rotation** wird korrigiert
- **Maximale Breite:** 1200px (Hauptbild), 400px (Thumbnail)
- **JPEG-Qualität:** 82% (Hauptbild), 75% (Thumbnail)
- **Format:** Alle Bilder werden als JPEG gespeichert
- **Thumbnails:** Automatisch mit `_thumb.jpg` Suffix erstellt

## Features

- Responsives Design (Mobile-First)
- Scroll-Animationen (IntersectionObserver)
- Bild-Lightbox für Raumgalerie
- Mobile Hamburger-Navigation
- Flash-Messages für Admin-Aktionen
- Automatische Thumbnail-Generierung
- SEO-Grundlagen (Meta-Tags, Alt-Texte)

## Schriftarten

- **Baloo 2** (Display/Überschriften)
- **Nunito** (Fließtext)

Geladen via Google Fonts.

## Farbpalette

| Farbe | Hex | Verwendung |
|-------|-----|------------|
| Honig-Gold | `#EDAB3A` | Primärfarbe, Buttons, Akzente |
| Petrol-Blau | `#1A3C4D` | Header, Footer, Überschriften |
| Korall | `#E87461` | Akzentfarbe, Highlights |
| Creme | `#FDFAF4` | Hintergründe |
