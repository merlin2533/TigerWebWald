<?php
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
if (preg_match('#^/admin/inhalte/(.+)$#', $uri, $m)) {
    $_GET['seite'] = $m[1];
}
$_GET['aktion'] = 'inhalte';
require dirname(dirname(__DIR__)) . '/admin.php';
