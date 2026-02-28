<?php
/**
 * Authentifizierung und Flash-Messages.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function admin_eingeloggt(): bool {
    return !empty($_SESSION['admin_eingeloggt']);
}

function admin_erforderlich(): void {
    if (!admin_eingeloggt()) {
        header('Location: /admin/login');
        exit;
    }
}

function flash(string $nachricht, string $kategorie = 'info'): void {
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    $_SESSION['flash'][] = ['kategorie' => $kategorie, 'nachricht' => $nachricht];
}

function get_flash_messages(): array {
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}
