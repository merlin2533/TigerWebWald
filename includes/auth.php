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

/** CSRF-Token erzeugen oder vorhandenes zurueckgeben */
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Hidden-Input-Feld mit CSRF-Token ausgeben */
function csrf_feld(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** CSRF-Token aus POST-Daten pruefen */
function csrf_pruefen(): bool {
    $token = $_POST['csrf_token'] ?? '';
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/** Passwort verifizieren (bcrypt mit SHA256-Fallback und Auto-Upgrade) */
function passwort_verifizieren(string $passwort, string $hash, ?int $admin_id = null): bool {
    // Zuerst bcrypt pruefen
    if (password_verify($passwort, $hash)) {
        return true;
    }
    // Fallback: SHA256 (altes Format)
    if ($hash === hash('sha256', $passwort)) {
        // Automatisch auf bcrypt upgraden
        if ($admin_id !== null) {
            $neuer_hash = password_hash($passwort, PASSWORD_DEFAULT);
            $db = get_db();
            $stmt = $db->prepare('UPDATE admin SET passwort_hash = ? WHERE id = ?');
            $stmt->execute([$neuer_hash, $admin_id]);
        }
        return true;
    }
    return false;
}
