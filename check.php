<?php
/**
 * Diagnose-Seite: Prueft ob alle Voraussetzungen erfuellt sind.
 * Nach erfolgreichem Test diese Datei wieder loeschen!
 */

header('Content-Type: text/html; charset=utf-8');
echo '<h1>EntenbachTigeR - Server-Diagnose</h1>';
echo '<pre>';

// PHP-Version
$php_ok = version_compare(PHP_VERSION, '8.0', '>=');
echo ($php_ok ? '✅' : '❌') . " PHP-Version: " . PHP_VERSION . ($php_ok ? '' : ' (mind. 8.0 benoetigt)') . "\n";

// PDO SQLite
$pdo_ok = extension_loaded('pdo_sqlite');
echo ($pdo_ok ? '✅' : '❌') . " PDO SQLite: " . ($pdo_ok ? 'verfuegbar' : 'FEHLT - muss in PHP aktiviert werden') . "\n";

// GD Library
$gd_ok = extension_loaded('gd');
echo ($gd_ok ? '✅' : '❌') . " GD Library: " . ($gd_ok ? 'verfuegbar' : 'FEHLT - fuer Bildverarbeitung benoetigt') . "\n";

// EXIF
$exif_ok = function_exists('exif_read_data');
echo ($exif_ok ? '✅' : '⚠️') . " EXIF: " . ($exif_ok ? 'verfuegbar' : 'fehlt (optional, Bilder funktionieren trotzdem)') . "\n";

// mod_rewrite
$rewrite = in_array('mod_rewrite', apache_get_modules() ?? []);
if (function_exists('apache_get_modules')) {
    echo ($rewrite ? '✅' : '❌') . " mod_rewrite: " . ($rewrite ? 'aktiv' : 'NICHT AKTIV') . "\n";
} else {
    echo "⚠️ mod_rewrite: Kann nicht geprueft werden (nicht Apache oder CGI-Modus)\n";
}

// Datenbank
$db_path = __DIR__ . '/tiger.db';
$db_exists = file_exists($db_path);
echo ($db_exists ? '✅' : '❌') . " Datenbank (tiger.db): " . ($db_exists ? 'vorhanden' : 'FEHLT - fuehre php init_db.php aus') . "\n";

if ($db_exists) {
    $writable = is_writable($db_path);
    echo ($writable ? '✅' : '❌') . " Datenbank schreibbar: " . ($writable ? 'ja' : 'NEIN - chmod 664 tiger.db') . "\n";

    // DB-Verzeichnis muss auch schreibbar sein (fuer SQLite WAL/Journal)
    $dir_writable = is_writable(dirname($db_path));
    echo ($dir_writable ? '✅' : '❌') . " Verzeichnis schreibbar: " . ($dir_writable ? 'ja' : 'NEIN - SQLite braucht Schreibrechte im Verzeichnis') . "\n";
}

// Upload-Verzeichnis
$upload_dir = __DIR__ . '/static/uploads';
if (is_dir($upload_dir)) {
    $up_writable = is_writable($upload_dir);
    echo ($up_writable ? '✅' : '❌') . " uploads/ schreibbar: " . ($up_writable ? 'ja' : 'NEIN - chmod 775 static/uploads/') . "\n";
} else {
    echo "⚠️ uploads/ Verzeichnis existiert nicht (wird beim ersten Upload erstellt)\n";
}

// Dateien pruefen
echo "\n--- Dateien ---\n";
$dateien = ['index.php', 'admin.php', 'init_db.php', '.htaccess', 'includes/db.php', 'includes/auth.php', 'includes/images.php', 'templates/base.php', 'templates/startseite.php'];
foreach ($dateien as $d) {
    $exists = file_exists(__DIR__ . '/' . $d);
    echo ($exists ? '✅' : '❌') . " $d\n";
}

// Test DB-Verbindung
if ($db_exists && $pdo_ok) {
    echo "\n--- Datenbank-Test ---\n";
    try {
        $pdo = new PDO('sqlite:' . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $count = $pdo->query('SELECT COUNT(*) FROM inhalte')->fetchColumn();
        echo "✅ DB-Verbindung OK, $count Inhalte gefunden\n";
        $team_count = $pdo->query('SELECT COUNT(*) FROM team')->fetchColumn();
        echo "✅ $team_count Team-Mitglieder\n";
    } catch (Exception $e) {
        echo "❌ DB-Fehler: " . $e->getMessage() . "\n";
    }
}

echo "\n--- Ergebnis ---\n";
if ($php_ok && $pdo_ok && $gd_ok && $db_exists) {
    echo "✅ Alles in Ordnung! Die Website sollte funktionieren.\n";
    echo "   ⚠️ Bitte diese Datei (check.php) nach dem Test loeschen!\n";
} else {
    echo "❌ Es gibt Probleme. Bitte die markierten Punkte beheben.\n";
}

echo '</pre>';
