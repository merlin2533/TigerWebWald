<?php
$flash_messages = get_flash_messages();
$seiten_namen = [
    'raeumlichkeiten' => 'Räumlichkeiten',
    'aussenbereich' => 'Außenbereich',
    'startseite' => 'Startseite',
];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#1A3C4D">
    <title>Alben: <?= e($seiten_namen[$seite] ?? $seite) ?> | EntenbachTigeR Admin</title>
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>Alben: <?= e($seiten_namen[$seite] ?? $seite) ?></h1>
        <div>
            <a href="/admin">&larr; Dashboard</a>
            &nbsp;&middot;&nbsp;
            <a href="/admin/bilder/<?= e($seite) ?>">Bilder verwalten</a>
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
        <!-- Vorhandene Alben bearbeiten -->
        <div class="admin-karte">
            <h2>Vorhandene Alben</h2>
            <?php if (!empty($alben)): ?>
            <form method="POST">
                <?= csrf_feld() ?>
                <input type="hidden" name="aktion" value="aktualisieren">
                <?php foreach ($alben as $album): ?>
                <div class="admin-team-karte">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <h3 style="margin: 0;"><?= e($album['name']) ?></h3>
                        <span style="color: var(--farbe-text-leicht); font-size: 0.85rem;">Schlüssel: <?= e($album['schluessel']) ?></span>
                    </div>
                    <div class="form-gruppe">
                        <label>Name</label>
                        <input type="text" name="name_<?= intval($album['id']) ?>" value="<?= e($album['name']) ?>">
                    </div>
                    <div class="form-gruppe">
                        <label>Beschreibung</label>
                        <textarea name="beschreibung_<?= intval($album['id']) ?>" rows="3"><?= e($album['beschreibung']) ?></textarea>
                    </div>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div class="form-gruppe" style="flex: 0 0 100px; margin-bottom: 0;">
                            <label>Reihenfolge</label>
                            <input type="number" name="reihenfolge_<?= intval($album['id']) ?>" value="<?= intval($album['reihenfolge']) ?>" min="0">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div style="display: flex; gap: 12px; margin-top: 16px;">
                    <button type="submit" class="btn-admin btn-admin--primary">Alle speichern</button>
                </div>
            </form>

            <!-- Loeschen als separate Formulare -->
            <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--farbe-border);">
                <h3 style="margin-bottom: 12px; color: var(--farbe-fehler);">Album löschen</h3>
                <p style="margin-bottom: 12px; color: var(--farbe-text-leicht); font-size: 0.9rem;">
                    Achtung: Das Album wird gelöscht. Die zugehörigen Bilder bleiben erhalten, werden aber nicht mehr auf der Seite angezeigt.
                </p>
                <?php foreach ($alben as $album): ?>
                <form method="POST" style="display: inline-block; margin: 4px;" onsubmit="return confirm('Album \'<?= e($album['name']) ?>\' wirklich löschen?')">
                    <?= csrf_feld() ?>
                    <input type="hidden" name="aktion" value="loeschen">
                    <input type="hidden" name="album_id" value="<?= intval($album['id']) ?>">
                    <button type="submit" class="btn-admin btn-admin--gefahr btn-admin--klein"><?= e($album['name']) ?> löschen</button>
                </form>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="color: var(--farbe-text-leicht);">Noch keine Alben vorhanden. Erstellen Sie unten ein neues Album.</p>
            <?php endif; ?>
        </div>

        <!-- Neues Album hinzufuegen -->
        <div class="admin-karte">
            <h2>Neues Album hinzufügen</h2>
            <form method="POST">
                <?= csrf_feld() ?>
                <input type="hidden" name="aktion" value="hinzufuegen">
                <div class="form-gruppe">
                    <label for="schluessel">Schlüssel (nur Kleinbuchstaben, Zahlen, Unterstriche)</label>
                    <input type="text" id="schluessel" name="schluessel" placeholder="z.B. spielzimmer, garten" required pattern="[a-z0-9_]+">
                </div>
                <div class="form-gruppe">
                    <label for="name">Anzeigename</label>
                    <input type="text" id="name" name="name" placeholder="z.B. Spielzimmer" required>
                </div>
                <div class="form-gruppe">
                    <label for="beschreibung">Beschreibung</label>
                    <textarea id="beschreibung" name="beschreibung" rows="3" placeholder="Beschreibung des Albums für die Website..."></textarea>
                </div>
                <div class="form-gruppe">
                    <label for="reihenfolge">Reihenfolge</label>
                    <input type="number" id="reihenfolge" name="reihenfolge" value="99" min="0">
                </div>
                <button type="submit" class="btn-admin btn-admin--primary">Album hinzufügen</button>
            </form>
        </div>
    </div>

    <script src="/static/js/main.js"></script>
</body>
</html>
