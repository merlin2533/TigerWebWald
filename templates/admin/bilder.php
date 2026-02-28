<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilder: <?= e($seite) ?> | Admin</title>
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>Bilder: <?= e($seite) ?></h1>
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
        <!-- Vorhandene Bilder -->
        <div class="admin-karte">
            <h2>Vorhandene Bilder</h2>
            <?php if (!empty($bilder)): ?>
            <div class="admin-bilder-grid">
                <?php foreach ($bilder as $bild): ?>
                <div class="admin-bild-karte">
                    <img src="/<?= e(bild_pfad($bild['dateiname'])) ?>" alt="<?= e($bild['alt_text']) ?>">
                    <div class="admin-bild-info">
                        <strong><?= e($bild['schluessel']) ?></strong><br>
                        <?= e($bild['dateiname']) ?><br>
                        <em><?= e($bild['alt_text']) ?></em>
                        <form method="POST" action="/admin/bild/loeschen/<?= intval($bild['id']) ?>" style="margin-top: 8px;" onsubmit="return confirm('Bild wirklich löschen?')">
                            <?= csrf_feld() ?>
                            <button type="submit" class="btn-admin btn-admin--gefahr btn-admin--klein">Löschen</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="color: var(--farbe-text-leicht);">Noch keine Bilder vorhanden.</p>
            <?php endif; ?>
        </div>

        <!-- Neues Bild hochladen -->
        <div class="admin-karte">
            <h2>Neues Bild hochladen</h2>
            <p style="margin-bottom: 16px; color: var(--farbe-text-leicht); font-size: 0.9rem;">
                Bilder werden automatisch auf max. 1200px Breite skaliert, komprimiert und ein Thumbnail wird erstellt.
            </p>
            <form method="POST" enctype="multipart/form-data">
                <?= csrf_feld() ?>
                <?php $seite_alben = get_alben($seite); ?>
                <div class="form-gruppe">
                    <label for="schluessel">Kategorie</label>
                    <?php if (!empty($seite_alben)): ?>
                    <select id="schluessel" name="schluessel">
                        <?php foreach ($seite_alben as $album): ?>
                        <option value="<?= e($album['schluessel']) ?>"><?= e($album['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p style="margin-top: 4px; font-size: 0.8rem; color: var(--farbe-text-leicht);">
                        <a href="/admin/alben/<?= e($seite) ?>">Kategorien bearbeiten</a>
                    </p>
                    <?php else: ?>
                    <input type="text" id="schluessel" name="schluessel" placeholder="z.B. hero, logo" required>
                    <?php endif; ?>
                </div>
                <div class="form-gruppe">
                    <label for="alt_text">Bildbeschreibung (Alt-Text für SEO)</label>
                    <input type="text" id="alt_text" name="alt_text" placeholder="z.B. Spielzimmer mit Kinderküche">
                </div>
                <div class="form-gruppe">
                    <label for="bild">Bild auswählen</label>
                    <input type="file" id="bild" name="bild" accept="image/*" required>
                </div>
                <button type="submit" class="btn-admin btn-admin--primary">Bild hochladen</button>
            </form>
        </div>
    </div>

    <script src="/static/js/main.js"></script>
</body>
</html>
