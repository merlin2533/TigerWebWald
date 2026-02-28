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

// Datenbank automatisch erstellen falls Tabellen fehlen
db_auto_init();

$seite = $_GET['seite'] ?? 'startseite';

// Basis-URL fuer Canonical/OG
$basis_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');

// Seiten-spezifische Daten laden
switch ($seite) {
    case 'startseite':
        $seitentitel = 'Startseite';
        $meta_beschreibung = 'Entenbach TigeR - Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach. 9 Betreuungsplätze für Kinder unter 3 Jahren.';
        $canonical_pfad = '/';
        $inhalte = get_alle_inhalte('startseite');
        $template = 'startseite.php';
        break;

    case 'ueber-uns':
        $seitentitel = 'Über uns';
        $meta_beschreibung = 'Lernen Sie das Team der Entenbach TigeR kennen. Öffnungszeiten, Betreuungsmodelle und unsere pädagogischen Fachkräfte.';
        $canonical_pfad = '/ueber-uns';
        $inhalte = get_alle_inhalte('ueber_uns');
        $team = get_team();
        $template = 'ueber_uns.php';
        break;

    case 'raeumlichkeiten':
        $seitentitel = 'Räumlichkeiten';
        $meta_beschreibung = 'Bildergalerie der Entenbach TigeR. Spielzimmer, Bewegungsraum, Essbereich und Garten im historischen Alten Notariat.';
        $canonical_pfad = '/raeumlichkeiten';
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
        $meta_beschreibung = 'Pädagogisches Konzept der Entenbach TigeR. Sichere Bindung, Rituale und Selbstständigkeit nach dem Berliner Eingewöhnungsmodell.';
        $canonical_pfad = '/konzept';
        $inhalte = get_alle_inhalte('konzept');
        $template = 'konzept.php';
        break;

    case 'kontakt':
        $seitentitel = 'Kontakt';
        $meta_beschreibung = 'Kontakt und Besichtigungstermin bei den Entenbach TigeR in Walddorfhäslach. Telefon, E-Mail und Anfahrt.';
        $canonical_pfad = '/kontakt';
        $inhalte = get_alle_inhalte('kontakt');
        $template = 'kontakt.php';
        break;

    case 'impressum':
        $seitentitel = 'Impressum';
        $meta_beschreibung = 'Impressum der Entenbach TigeR Kindertagespflege in Walddorfhäslach.';
        $canonical_pfad = '/impressum';
        $inhalte = get_alle_inhalte('kontakt');
        $template = 'impressum.php';
        break;

    case 'datenschutz':
        $seitentitel = 'Datenschutz';
        $meta_beschreibung = 'Datenschutzerklärung der Entenbach TigeR Kindertagespflege.';
        $canonical_pfad = '/datenschutz';
        $inhalte = [];
        $template = 'datenschutz.php';
        break;

    case '404':
        http_response_code(404);
        $seitentitel = 'Seite nicht gefunden';
        $meta_beschreibung = '';
        $canonical_pfad = '';
        $inhalte = [];
        $template = '404.php';
        break;

    default:
        http_response_code(404);
        $seitentitel = 'Seite nicht gefunden';
        $meta_beschreibung = '';
        $canonical_pfad = '';
        $inhalte = [];
        $template = '404.php';
}

$aktive_seite = $seite;

// Base-Template mit eingebettetem Seiteninhalt rendern
ob_start();
require __DIR__ . '/templates/' . $template;
$page_content = ob_get_clean();

require __DIR__ . '/templates/base.php';
