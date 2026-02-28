<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Entenbach Tiger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-karte">
            <img src="/static/images/Logo.jpg" alt="Entenbach Tiger">
            <h1>Admin-Bereich</h1>
            <p>Melden Sie sich an, um Inhalte zu bearbeiten.</p>

            <?php foreach ($flash_messages as $msg): ?>
            <div class="flash flash--<?= e($msg['kategorie']) ?>" style="margin-bottom: 16px; padding: 10px; border-radius: 8px; text-align: center;"><?= e($msg['nachricht']) ?></div>
            <?php endforeach; ?>

            <form method="POST">
                <div class="form-gruppe">
                    <label for="benutzername">Benutzername</label>
                    <input type="text" id="benutzername" name="benutzername" required autocomplete="username">
                </div>
                <div class="form-gruppe">
                    <label for="passwort">Passwort</label>
                    <input type="password" id="passwort" name="passwort" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn-admin btn-admin--primary" style="width: 100%; padding: 14px; font-size: 1rem; margin-top: 8px;">Anmelden</button>
            </form>

            <p style="margin-top: 24px; font-size: 0.8rem; opacity: 0.5;">
                <a href="/">Zurück zur Website</a>
            </p>
        </div>
    </div>
</body>
</html>
