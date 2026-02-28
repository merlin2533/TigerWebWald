<?php
/**
 * Initialisiert die SQLite-Datenbank mit Standardinhalten.
 * Aufruf: php init_db.php
 */

$db_path = __DIR__ . '/tiger.db';
$pdo = new PDO('sqlite:' . $db_path);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tabelle fuer Textinhalte
$pdo->exec("
    CREATE TABLE IF NOT EXISTS inhalte (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        seite TEXT NOT NULL,
        schluessel TEXT NOT NULL,
        wert TEXT NOT NULL,
        typ TEXT DEFAULT 'text',
        UNIQUE(seite, schluessel)
    )
");

// Tabelle fuer Bilder
$pdo->exec("
    CREATE TABLE IF NOT EXISTS bilder (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        seite TEXT NOT NULL,
        schluessel TEXT NOT NULL,
        dateiname TEXT NOT NULL,
        alt_text TEXT DEFAULT '',
        reihenfolge INTEGER DEFAULT 0,
        UNIQUE(seite, schluessel, dateiname)
    )
");

// Tabelle fuer Team-Mitglieder
$pdo->exec("
    CREATE TABLE IF NOT EXISTS team (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        rolle TEXT DEFAULT '',
        beschreibung TEXT DEFAULT '',
        bild TEXT DEFAULT '',
        reihenfolge INTEGER DEFAULT 0
    )
");

// Tabelle fuer Alben/Kategorien
$pdo->exec("
    CREATE TABLE IF NOT EXISTS alben (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        seite TEXT NOT NULL,
        schluessel TEXT NOT NULL,
        name TEXT NOT NULL,
        beschreibung TEXT DEFAULT '',
        reihenfolge INTEGER DEFAULT 0,
        UNIQUE(seite, schluessel)
    )
");

// Admin-Benutzer
$pdo->exec("
    CREATE TABLE IF NOT EXISTS admin (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        benutzername TEXT UNIQUE NOT NULL,
        passwort_hash TEXT NOT NULL
    )
");

// --- Standarddaten einfuegen ---

// Admin-Benutzer (Standard: admin / tiger2024)
$pw_hash = password_hash('tiger2024', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT OR IGNORE INTO admin (benutzername, passwort_hash) VALUES (?, ?)");
$stmt->execute(['admin', $pw_hash]);

// Team-Mitglieder
$team = [
    ['Verena Schall', 'Tagespflegeperson', 'Verena begleitet die Kinder mit viel Herz und Erfahrung. Als ausgebildete Erzieherin liegt ihr besonders die individuelle Förderung jedes Kindes am Herzen. Mit ihrer warmherzigen Art schafft sie eine Atmosphäre, in der sich die Kleinen sicher und geborgen fühlen.', '', 1],
    ['Melanie Cerny', 'Tagespflegeperson', 'Melanie bringt Kreativität und Lebensfreude in den Alltag der Kinder. Ob beim gemeinsamen Basteln, Singen oder Entdecken der Natur – sie versteht es, die Neugier der Kinder zu wecken und sie in ihrer Entwicklung liebevoll zu unterstützen.', '', 2],
    ['Sandra Rein', 'Tagespflegeperson', 'Sandra ist die ruhige Kraft im Team. Mit Geduld und Einfühlungsvermögen begleitet sie besonders die Eingewöhnung neuer Kinder. Ihr liegt ein strukturierter Tagesablauf am Herzen, der den Kindern Sicherheit und Orientierung gibt.', '', 3],
];
$stmt = $pdo->prepare("INSERT OR IGNORE INTO team (name, rolle, beschreibung, bild, reihenfolge) VALUES (?, ?, ?, ?, ?)");
foreach ($team as $t) {
    $stmt->execute($t);
}

// Seiteninhalte
$inhalte = [
    // Startseite
    ['startseite', 'hero_titel', 'Willkommen beim EntenbachTigeR', 'text'],
    ['startseite', 'hero_untertitel', 'Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach', 'text'],
    ['startseite', 'intro_text', 'Im Herzen von Walddorf, im wunderschönen Alten Notariat, bieten wir 9 Betreuungsplätze für Kinder unter 3 Jahren. Unser erfahrenes Team aus drei Tagespflegepersonen begleitet Ihr Kind mit Herz, Kompetenz und viel Freude durch den Tag.', 'text'],
    ['startseite', 'cta_text', 'Lernen Sie uns und unsere Räumlichkeiten kennen!', 'text'],
    // Ueber uns
    ['ueber_uns', 'titel', 'Über die EntenbachTigeR', 'text'],
    ['ueber_uns', 'text_1', 'Die EntenbachTigeR sind eine Kindertagespflege im U3-Bereich, angeschlossen an den Tagesmutterverein Reutlingen – dabei jedoch komplett eigenständig in unserer pädagogischen Arbeit. Wir betreuen bis zu 9 Kinder in den liebevoll gestalteten Räumlichkeiten im Dachgeschoss des historischen Alten Notariats.', 'text'],
    ['ueber_uns', 'text_2', 'Unser Ziel ist es, jedem Kind eine sichere, geborgene und anregende Umgebung zu bieten, in der es sich in seinem eigenen Tempo entwickeln kann. Mit viel Herz und pädagogischer Kompetenz begleiten wir die Kinder durch ihren Tag.', 'text'],
    ['ueber_uns', 'oeffnungszeiten_1', 'Modell 1: Montag–Donnerstag 07:30–15:00 Uhr, Freitag 08:00–12:30 Uhr (5 Plätze)', 'text'],
    ['ueber_uns', 'oeffnungszeiten_2', 'Modell 2: Montag–Donnerstag 07:30–12:30 Uhr, Freitag 08:00–12:30 Uhr (4 Plätze)', 'text'],
    // Konzept
    ['konzept', 'titel', 'Unser Pädagogisches Konzept', 'text'],
    ['konzept', 'intro', 'Unsere pädagogische Arbeit orientiert sich an drei zentralen Zielen, die die Grundlage für die ganzheitliche Entwicklung Ihres Kindes bilden.', 'text'],
    ['konzept', 'bindung_titel', 'Sichere Bindung', 'text'],
    ['konzept', 'bindung_text', 'Eine zuverlässige und einfühlsame Beziehung ist die Basis für emotionale Sicherheit und Lernbereitschaft. Durch eine respektvolle Haltung, Kommunikation auf Augenhöhe und feste Bezugspersonen entsteht Vertrauen. Kinder, die sich sicher fühlen, trauen sich, ihre Umgebung zu erkunden und Neues auszuprobieren.', 'text'],
    ['konzept', 'struktur_titel', 'Rituale & Strukturen', 'text'],
    ['konzept', 'struktur_text', 'Ein strukturierter Tagesablauf mit wiederkehrenden Ritualen gibt Orientierung und Sicherheit. Feste Bestandteile des Tages sind gemeinsame Mahlzeiten, der Kinderkreis, Freispielphasen sowie Ruhe- und Schlafzeiten. Zuverlässige Strukturen unterstützen die emotionale Stabilität.', 'text'],
    ['konzept', 'selbststaendigkeit_titel', 'Selbstständigkeit', 'text'],
    ['konzept', 'selbststaendigkeit_text', 'Wir ermutigen die Kinder, Dinge eigenständig auszuprobieren und kleine Aufgaben selbst zu bewältigen. Im Sinne von Maria Montessori – "Hilf mir, es selbst zu tun" – begleiten wir die Kinder unterstützend, ohne ihnen Aufgaben abzunehmen.', 'text'],
    ['konzept', 'eingewoehnung_titel', 'Sanfte Eingewöhnung', 'text'],
    ['konzept', 'eingewoehnung_text', 'Wir orientieren uns am Berliner Eingewöhnungsmodell. In der Regel dauert die Eingewöhnung zwei bis vier Wochen. Da jedes Kind individuell reagiert, kann dieser Zeitraum kürzer oder länger sein. Der Betreuungsvertrag wird erst nach erfolgreicher Eingewöhnung geschlossen.', 'text'],
    // Kontakt
    ['kontakt', 'titel', 'Kontakt & Besichtigung', 'text'],
    ['kontakt', 'text', 'Haben wir Ihr Interesse geweckt? Wir freuen uns darauf, Sie und Ihr Kind kennenzulernen! Vereinbaren Sie gerne einen Besichtigungstermin – telefonisch oder per E-Mail.', 'text'],
    ['kontakt', 'telefon', '07127/9266-850', 'text'],
    ['kontakt', 'email', 'info@entenbachtiger.de', 'text'],
    ['kontakt', 'adresse', 'Brühlstraße 2, 72141 Walddorfhäslach', 'text'],
];
$stmt = $pdo->prepare("INSERT OR IGNORE INTO inhalte (seite, schluessel, wert, typ) VALUES (?, ?, ?, ?)");
foreach ($inhalte as $i) {
    $stmt->execute($i);
}

// Alben/Kategorien
$alben = [
    ['raeumlichkeiten', 'spielzimmer', 'Spielzimmer', 'Hier wird gespielt, gebaut und geträumt: Unser großzügiges Spielzimmer mit Kinderküche, Bauecke und kuscheliger Leseecke bietet vielfältige Möglichkeiten — für Rollenspiele, kreatives Bauen und ruhige Momente mit Büchern.', 1],
    ['raeumlichkeiten', 'bewegungsraum', 'Bewegungsraum', 'Klettern, schaukeln, rollen — unser Bewegungsraum mit Nestschaukel, Bällebad und modularer Bewegungslandschaft lädt zum Toben ein. Zur Mittagszeit verwandelt er sich in einen ruhigen Schlafraum.', 2],
    ['raeumlichkeiten', 'schlafraum', 'Schlafraum', 'Jedes Kind hat seinen eigenen festen Schlafplatz mit individueller Bettwäsche. Sanftes Licht, Ruhe und Geborgenheit sorgen dafür, dass die Kinder entspannt in die Mittagsruhe finden.', 3],
    ['raeumlichkeiten', 'garderobe', 'Garderobe', 'Eigener Haken, eigenes Fach — in unserer Garderobe hat jedes Kind seinen persönlichen Platz. Das fördert die Selbstständigkeit und gibt Orientierung beim täglichen Ankommen und Verabschieden.', 4],
    ['raeumlichkeiten', 'essbereich', 'Essbereich', 'An unserem großen Esstisch mit ergonomischen Kinderstühlen werden die Mahlzeiten gemeinsam eingenommen. Unter den wunderschönen alten Holzbalken schmeckt es gleich doppelt gut.', 5],
    ['raeumlichkeiten', 'kueche', 'Küche', 'Frisch, ausgewogen und mit Liebe zubereitet: In unserer voll ausgestatteten Küche kochen wir täglich frisch. Durch die offene Gestaltung behalten wir dabei immer den Essbereich im Blick.', 6],
    ['raeumlichkeiten', 'wickelbereich', 'Wickelbereich', 'Unser Sanitärbereich ist konsequent kindgerecht gestaltet: Wickelplatz mit Treppe zum selbstständigen Hinaufklettern, persönliche Fächer für jedes Kind und Waschbecken in Kinderhöhe — alles mit Verbrühungsschutz.', 7],
    ['aussenbereich', 'garten', 'Garten', 'Unser großzügiger Außenbereich mit Spielplatz, Sandkasten und Sonnensegel bietet den Kindern viel Platz zum Spielen und Entdecken an der frischen Luft.', 1],
    ['aussenbereich', 'bollerwagen', 'Bollerwagen / Ausflüge', 'Mit unserem Bollerwagen unternehmen wir regelmäßig Ausflüge in die Umgebung und erkunden die Natur rund um Walddorfhäslach.', 2],
];
$stmt = $pdo->prepare("INSERT OR IGNORE INTO alben (seite, schluessel, name, beschreibung, reihenfolge) VALUES (?, ?, ?, ?, ?)");
foreach ($alben as $a) {
    $stmt->execute($a);
}

// Bilder-Zuordnungen
$bilder = [
    ['startseite', 'hero', 'Haus.jpg', 'Fachwerkhaus der EntenbachTigeR', 1],
    ['startseite', 'logo', 'Logo.jpg', 'Logo EntenbachTigeR', 1],
    ['raeumlichkeiten', 'spielzimmer', 'Raum1.jpg', 'Spielzimmer mit Weltkarte-Teppich', 1],
    ['raeumlichkeiten', 'spielzimmer', 'Raum2.jpg', 'Bewegungs- und Sinnesraum', 2],
    ['raeumlichkeiten', 'bewegungsraum', 'Raum3.jpg', 'Bewegungsraum mit Schaumstoffelementen', 1],
    ['raeumlichkeiten', 'bewegungsraum', 'Raum4.jpg', 'Bewegungslandschaft', 2],
    ['raeumlichkeiten', 'garderobe', 'Raum5.jpg', 'Garderobe', 1],
    ['raeumlichkeiten', 'schlafraum', 'Raum6.jpg', 'Schlafraum', 1],
    ['raeumlichkeiten', 'essbereich', 'Essbereich.jpg', 'Essbereich mit Kinderstühlen', 1],
    ['raeumlichkeiten', 'essbereich', 'Essbereich2.jpg', 'Essbereich', 2],
    ['raeumlichkeiten', 'kueche', 'Küche.jpg', 'Moderne Küche mit Holzbalken', 1],
    ['raeumlichkeiten', 'wickelbereich', 'Wickelbereich.jpg', 'Wickelbereich mit Treppe', 1],
    ['raeumlichkeiten', 'wickelbereich', 'Wickelbereich2.jpg', 'Kinderbad mit Waschbecken', 2],
    ['aussenbereich', 'garten', 'Außen1.jpg', 'Außenbereich mit Spielplatz', 1],
    ['aussenbereich', 'garten', 'Außen2.jpg', 'Garten mit Sonnensegel', 2],
    ['aussenbereich', 'bollerwagen', 'Gerät.jpg', 'Bollerwagen für Ausflüge', 1],
];
$stmt = $pdo->prepare("INSERT OR IGNORE INTO bilder (seite, schluessel, dateiname, alt_text, reihenfolge) VALUES (?, ?, ?, ?, ?)");
foreach ($bilder as $b) {
    $stmt->execute($b);
}

echo "Datenbank erfolgreich initialisiert!\n";
