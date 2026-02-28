<?php
/**
 * EntenbachTigeR - Oeffentliche Seiten (Router).
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
        $meta_beschreibung = 'EntenbachTigeR - Kindertagespflege und U3-Betreuung im historischen Fachwerkhaus in Walddorfhäslach. 9 Plätze, 3 Fachkräfte, liebevolle Kinderbetreuung.';
        $canonical_pfad = '/';
        $inhalte = get_alle_inhalte('startseite');
        $template = 'startseite.php';
        break;

    case 'ueber-uns':
        $seitentitel = 'Über uns';
        $meta_beschreibung = 'Team, Öffnungszeiten und Betreuungsmodelle der EntenbachTigeR Kindertagespflege in Walddorfhäslach. Drei erfahrene Tagespflegepersonen für U3-Kinder.';
        $canonical_pfad = '/ueber-uns';
        $inhalte = get_alle_inhalte('ueber_uns');
        $team = get_team();
        $template = 'ueber_uns.php';
        break;

    case 'raeumlichkeiten':
        $seitentitel = 'Räumlichkeiten';
        $meta_beschreibung = 'Räumlichkeiten der EntenbachTigeR Kindertagespflege Walddorfhäslach. Spielzimmer, Bewegungsraum, Schlafraum, Essbereich und Garten im Alten Notariat.';
        $canonical_pfad = '/raeumlichkeiten';
        $bilder_raw = array_merge(get_bilder('raeumlichkeiten'), get_bilder('aussenbereich'));
        // Alben dynamisch aus DB laden (Innenraeume + Aussenbereich)
        $alben_raw = array_merge(get_alben('raeumlichkeiten'), get_alben('aussenbereich'));
        $kategorie_namen = [];
        $kategorie_beschreibungen = [];
        foreach ($alben_raw as $a) {
            $kategorie_namen[$a['schluessel']] = $a['name'];
            $kategorie_beschreibungen[$a['schluessel']] = $a['beschreibung'];
        }
        // Bilder nach Kategorien gruppieren, Reihenfolge der Alben beibehalten
        $kategorien = [];
        $bilder_nach_key = [];
        foreach ($bilder_raw as $b) {
            $bilder_nach_key[$b['schluessel']][] = $b;
        }
        foreach ($alben_raw as $a) {
            if (!empty($bilder_nach_key[$a['schluessel']])) {
                $kategorien[$a['schluessel']] = $bilder_nach_key[$a['schluessel']];
            }
        }
        $template = 'raeumlichkeiten.php';
        break;

    case 'konzept':
        $seitentitel = 'Pädagogisches Konzept';
        $meta_beschreibung = 'Pädagogisches Konzept der EntenbachTigeR Kindertagespflege. Sichere Bindung, Rituale, Selbstständigkeit und sanfte Eingewöhnung nach dem Berliner Modell.';
        $canonical_pfad = '/konzept';
        $inhalte = get_alle_inhalte('konzept');
        $template = 'konzept.php';
        break;

    case 'kontakt':
        $seitentitel = 'Kontakt';
        $meta_beschreibung = 'Kontakt und Besichtigungstermin bei der EntenbachTigeR Kindertagespflege in Walddorfhäslach. Telefon, E-Mail, Adresse und Anfahrt.';
        $canonical_pfad = '/kontakt';
        $inhalte = get_alle_inhalte('kontakt');
        $template = 'kontakt.php';
        break;

    case 'faq':
        $seitentitel = 'Häufige Fragen (FAQ)';
        $meta_beschreibung = 'Häufige Fragen zur Kindertagespflege EntenbachTigeR in Walddorfhäslach: Kosten, Eingewöhnung, Öffnungszeiten, Anmeldung, Qualifikation, Verpflegung und mehr. U3-Betreuung für Kinder unter 3 Jahren.';
        $canonical_pfad = '/faq';
        $inhalte = get_alle_inhalte('kontakt');
        $template = 'faq.php';
        break;

    case 'impressum':
        $seitentitel = 'Impressum';
        $meta_beschreibung = 'Impressum der EntenbachTigeR Kindertagespflege in Walddorfhäslach.';
        $canonical_pfad = '/impressum';
        $inhalte = get_alle_inhalte('kontakt');
        $template = 'impressum.php';
        break;

    case 'datenschutz':
        $seitentitel = 'Datenschutz';
        $meta_beschreibung = 'Datenschutzerklärung der EntenbachTigeR Kindertagespflege.';
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
