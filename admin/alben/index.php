<?php
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
if (preg_match('#^/admin/alben/(.+)$#', $uri, $m)) {
    $_GET['seite'] = $m[1];
}
$_GET['aktion'] = 'alben';
require dirname(dirname(__DIR__)) . '/admin.php';
