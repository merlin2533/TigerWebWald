<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Texte: <?= e($seite) ?> | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>Texte: <?= e($seite) ?></h1>
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
        <div class="admin-karte">
            <h2>Inhalte bearbeiten</h2>
            <form method="POST">
                <?= csrf_feld() ?>
                <?php foreach ($inhalte as $inhalt): ?>
                <div class="form-gruppe">
                    <label for="<?= e($inhalt['schluessel']) ?>"><?= e(ucwords(str_replace('_', ' ', $inhalt['schluessel']))) ?></label>
                    <?php if (strlen($inhalt['wert']) > 100): ?>
                    <textarea id="<?= e($inhalt['schluessel']) ?>" name="<?= e($inhalt['schluessel']) ?>" rows="4"><?= e($inhalt['wert']) ?></textarea>
                    <?php else: ?>
                    <input type="text" id="<?= e($inhalt['schluessel']) ?>" name="<?= e($inhalt['schluessel']) ?>" value="<?= e($inhalt['wert']) ?>">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <button type="submit" class="btn-admin btn-admin--primary">Speichern</button>
            </form>
        </div>
    </div>

    <script src="/static/js/main.js"></script>
</body>
</html>
