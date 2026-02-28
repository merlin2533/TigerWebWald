<?php
/**
 * Datenbank-Verbindung und Hilfsfunktionen.
 */

define('BASE_DIR', dirname(__DIR__));
define('DB_PATH', BASE_DIR . '/tiger.db');
define('UPLOAD_DIR', BASE_DIR . '/static/uploads');
define('IMAGE_DIR', BASE_DIR . '/static/images');

function get_db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO('sqlite:' . DB_PATH);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    return $pdo;
}

function db_initialisiert(): bool {
    try {
        $db = get_db();
        $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='admin'");
        return $result->fetch() !== false;
    } catch (Exception $e) {
        return false;
    }
}

function db_auto_init(): void {
    if (!db_initialisiert()) {
        require_once BASE_DIR . '/init_db.php';
        return;
    }
    // Neue Tabellen bei bestehender DB nachrüsten
    $db = get_db();
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='alben'");
    if ($result->fetch() === false) {
        $db->exec("
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
    }
    // Korrektur: Dateinamen Außen -> Aueßen (tatsaechliche Dateinamen im Dateisystem)
    $stmt = $db->prepare("UPDATE bilder SET dateiname = REPLACE(dateiname, 'Außen', 'Aueßen') WHERE dateiname LIKE 'Außen%'");
    $stmt->execute();
}

function get_inhalt(string $seite, string $schluessel, string $standard = ''): string {
    $db = get_db();
    $stmt = $db->prepare('SELECT wert FROM inhalte WHERE seite = ? AND schluessel = ?');
    $stmt->execute([$seite, $schluessel]);
    $row = $stmt->fetch();
    return $row ? $row['wert'] : $standard;
}

function get_alle_inhalte(string $seite): array {
    $db = get_db();
    $stmt = $db->prepare('SELECT schluessel, wert FROM inhalte WHERE seite = ?');
    $stmt->execute([$seite]);
    $result = [];
    foreach ($stmt->fetchAll() as $row) {
        $result[$row['schluessel']] = $row['wert'];
    }
    return $result;
}

function get_bilder(string $seite, ?string $schluessel = null): array {
    $db = get_db();
    if ($schluessel) {
        $stmt = $db->prepare('SELECT * FROM bilder WHERE seite = ? AND schluessel = ? ORDER BY reihenfolge');
        $stmt->execute([$seite, $schluessel]);
    } else {
        $stmt = $db->prepare('SELECT * FROM bilder WHERE seite = ? ORDER BY schluessel, reihenfolge');
        $stmt->execute([$seite]);
    }
    return $stmt->fetchAll();
}

function get_team(): array {
    $db = get_db();
    return $db->query('SELECT * FROM team ORDER BY reihenfolge')->fetchAll();
}

function get_alben(string $seite): array {
    $db = get_db();
    $stmt = $db->prepare('SELECT * FROM alben WHERE seite = ? ORDER BY reihenfolge');
    $stmt->execute([$seite]);
    return $stmt->fetchAll();
}

function bild_pfad(string $dateiname): string {
    if (file_exists(UPLOAD_DIR . '/' . $dateiname)) {
        return 'static/uploads/' . $dateiname;
    }
    return 'static/images/' . $dateiname;
}

/** Hilfsfunktion: HTML-Encoding */
function e(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
