<?php
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
if (preg_match('#^/admin/bilder/(.+)$#', $uri, $m)) {
    $_GET['seite'] = $m[1];
}
$_GET['aktion'] = 'bilder';
require dirname(dirname(__DIR__)) . '/admin.php';
