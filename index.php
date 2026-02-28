<?php
/**
 * Entenbach Tiger - Oeffentliche Seiten (Router).
 */

// Fehler anzeigen falls Datenbank oder Extensions fehlen
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

// Datenbank automatisch erstellen falls nicht vorhanden
if (!file_exists(DB_PATH)) {
    require_once __DIR__ . '/init_db.php';
}

$seite = $_GET['seite'] ?? 'startseite';

// Seiten-spezifische Daten laden
switch ($seite) {
    case 'startseite':
        $seitentitel = 'Startseite';
        $inhalte = get_alle_inhalte('startseite');
        $template = 'startseite.php';
        break;

    case 'ueber-uns':
        $seitentitel = 'Über uns';
        $inhalte = get_alle_inhalte('ueber_uns');
        $team = get_team();
        $template = 'ueber_uns.php';
        break;

    case 'raeumlichkeiten':
        $seitentitel = 'Räumlichkeiten';
        $bilder_raw = get_bilder('raeumlichkeiten');
        $kategorien = [];
        foreach ($bilder_raw as $b) {
            $kategorien[$b['schluessel']][] = $b;
        }
        $kategorie_namen = [
            'spielzimmer' => 'Spielzimmer',
            'bewegungsraum' => 'Bewegungsraum',
            'schlafraum' => 'Schlafraum',
            'garderobe' => 'Garderobe',
            'essbereich' => 'Essbereich',
            'kueche' => 'Küche',
            'wickelbereich' => 'Wickelbereich',
        ];
        $template = 'raeumlichkeiten.php';
        break;

    case 'konzept':
        $seitentitel = 'Pädagogisches Konzept';
        $inhalte = get_alle_inhalte('konzept');
        $template = 'konzept.php';
        break;

    case 'kontakt':
        $seitentitel = 'Kontakt';
        $inhalte = get_alle_inhalte('kontakt');
        $template = 'kontakt.php';
        break;

    default:
        http_response_code(404);
        echo '<h1>Seite nicht gefunden</h1>';
        exit;
}

$aktive_seite = $seite;

// Base-Template mit eingebettetem Seiteninhalt rendern
ob_start();
require __DIR__ . '/templates/' . $template;
$page_content = ob_get_clean();

require __DIR__ . '/templates/base.php';
