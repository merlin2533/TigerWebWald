<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort ändern | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>Passwort ändern</h1>
        <div>
            <a href="/admin">&larr; Dashboard</a>
            &nbsp;&middot;&nbsp;
            <a href="/admin/logout">Abmelden</a>
        </div>
    </header>

    <?php if (!empty($flash_messages)): ?>
    <div class="flash-container">
        <?php foreach ($flash_messages as $msg): ?>
        <div class="flash flash--<?= e($msg['kategorie']) ?>"><?= e($msg['nachricht']) ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="admin-container">
        <div class="admin-karte" style="max-width: 480px;">
            <h2>Neues Passwort setzen</h2>
            <form method="POST">
                <?= csrf_feld() ?>
                <div class="form-gruppe">
                    <label for="altes_passwort">Aktuelles Passwort</label>
                    <input type="password" id="altes_passwort" name="altes_passwort" required>
                </div>
                <div class="form-gruppe">
                    <label for="neues_passwort">Neues Passwort</label>
                    <input type="password" id="neues_passwort" name="neues_passwort" required minlength="6">
                </div>
                <button type="submit" class="btn-admin btn-admin--primary">Passwort ändern</button>
            </form>
        </div>
    </div>

    <script src="/static/js/main.js"></script>
</body>
</html>
