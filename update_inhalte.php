<?php
/**
 * Aktualisiert bestehende Inhalte in der Datenbank.
 * Wird benoetigt, weil init_db.php mit INSERT OR IGNORE arbeitet und
 * bestehende Eintraege nicht ueberschreibt.
 *
 * Aufruf: php update_inhalte.php
 */

$db_path = __DIR__ . '/tiger.db';
if (!file_exists($db_path)) {
    echo "Datenbank nicht gefunden: {$db_path}\n";
    echo "Bitte zuerst init_db.php ausfuehren.\n";
    exit(1);
}

$pdo = new PDO('sqlite:' . $db_path);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Zu aktualisierende Inhalte (Seite, Schluessel, Neuer Wert)
$updates = [
    [
        'konzept',
        'selbststaendigkeit_text',
        'Wir ermutigen die Kinder, Dinge eigenständig auszuprobieren und kleine Aufgaben selbst zu bewältigen. Selbstständigkeit im Alltag ist uns ein wichtiges pädagogisches Ziel — wir begleiten die Kinder unterstützend, ohne ihnen Aufgaben abzunehmen.',
    ],
];

$stmt = $pdo->prepare("UPDATE inhalte SET wert = ? WHERE seite = ? AND schluessel = ?");
$aktualisiert = 0;
foreach ($updates as [$seite, $schluessel, $wert]) {
    $stmt->execute([$wert, $seite, $schluessel]);
    if ($stmt->rowCount() > 0) {
        echo "Aktualisiert: {$seite} / {$schluessel}\n";
        $aktualisiert++;
    } else {
        // Falls der Eintrag noch nicht existiert, anlegen
        $insert = $pdo->prepare("INSERT OR IGNORE INTO inhalte (seite, schluessel, wert, typ) VALUES (?, ?, ?, 'text')");
        $insert->execute([$seite, $schluessel, $wert]);
        if ($insert->rowCount() > 0) {
            echo "Neu angelegt: {$seite} / {$schluessel}\n";
            $aktualisiert++;
        }
    }
}

echo "\nFertig. {$aktualisiert} Eintrag/Eintraege aktualisiert.\n";
