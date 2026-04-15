<?php
// Admin-Router fuer Plesk ohne mod_rewrite
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$pfad = preg_replace('#^/admin/?#', '', $uri);
$teile = array_values(array_filter(explode('/', $pfad)));

$aktion = $teile[0] ?? 'dashboard';

switch ($aktion) {
    case 'inhalte':
    case 'bilder':
    case 'alben':
        $_GET['aktion'] = $aktion;
        $_GET['seite']  = $teile[1] ?? '';
        break;
    case 'bild':
        // /admin/bild/loeschen/123
        $_GET['aktion']   = 'bild_loeschen';
        $_GET['bild_id']  = $teile[2] ?? '';
        break;
    default:
        $_GET['aktion'] = $aktion;
}

require dirname(__DIR__) . '/admin.php';
