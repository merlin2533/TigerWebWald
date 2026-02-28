<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team | Admin</title>
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>Team verwalten</h1>
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
        <!-- Texte bearbeiten -->
        <div class="admin-karte">
            <h2>Team-Informationen</h2>
            <form method="POST">
                <?= csrf_feld() ?>
                <input type="hidden" name="aktion" value="aktualisieren">
                <?php foreach ($team as $mitglied): ?>
                <div class="admin-team-karte">
                    <h3><?= e($mitglied['name']) ?></h3>
                    <div class="form-gruppe">
                        <label>Name</label>
                        <input type="text" name="name_<?= intval($mitglied['id']) ?>" value="<?= e($mitglied['name']) ?>">
                    </div>
                    <div class="form-gruppe">
                        <label>Rolle</label>
                        <input type="text" name="rolle_<?= intval($mitglied['id']) ?>" value="<?= e($mitglied['rolle']) ?>">
                    </div>
                    <div class="form-gruppe">
                        <label>Beschreibung</label>
                        <textarea name="beschreibung_<?= intval($mitglied['id']) ?>" rows="3"><?= e($mitglied['beschreibung']) ?></textarea>
                    </div>
                </div>
                <?php endforeach; ?>
                <button type="submit" class="btn-admin btn-admin--primary">Alle speichern</button>
            </form>
        </div>

        <!-- Fotos hochladen -->
        <div class="admin-karte">
            <h2>Team-Fotos</h2>
            <p style="margin-bottom: 20px; color: var(--farbe-text-leicht); font-size: 0.9rem;">
                Laden Sie ein Foto für jedes Teammitglied hoch. Bilder werden automatisch optimiert.
            </p>
            <?php foreach ($team as $mitglied): ?>
            <div class="admin-team-karte" style="display: flex; gap: 24px; align-items: center; flex-wrap: wrap;">
                <div style="flex-shrink: 0;">
                    <?php if (!empty($mitglied['bild'])): ?>
                    <img src="/static/uploads/<?= e($mitglied['bild']) ?>" alt="<?= e($mitglied['name']) ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--farbe-gelb-hell); display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 2rem; color: var(--farbe-blau-hell); opacity: 0.4;">?</span>
                    </div>
                    <?php endif; ?>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <h3 style="margin-bottom: 8px;"><?= e($mitglied['name']) ?></h3>
                    <form method="POST" enctype="multipart/form-data">
                        <?= csrf_feld() ?>
                        <input type="hidden" name="aktion" value="bild_hochladen">
                        <input type="hidden" name="mitglied_id" value="<?= intval($mitglied['id']) ?>">
                        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                            <input type="file" name="bild" accept="image/*" required style="flex: 1; min-width: 150px;">
                            <button type="submit" class="btn-admin btn-admin--primary btn-admin--klein">Hochladen</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="/static/js/main.js"></script>
</body>
</html>
