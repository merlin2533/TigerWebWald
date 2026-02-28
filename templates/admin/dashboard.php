<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Entenbach Tiger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>Entenbach Tiger — Admin</h1>
        <div>
            <a href="/" target="_blank">Website ansehen</a>
            &nbsp;&middot;&nbsp;
            <a href="/admin/passwort">Passwort ändern</a>
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
            <h2>Texte bearbeiten</h2>
            <p style="margin-bottom: 20px; color: var(--farbe-text-leicht);">Wählen Sie eine Seite, um deren Texte zu bearbeiten.</p>
            <div class="admin-link-grid">
                <?php
                $seiten_namen = [
                    'startseite' => 'Startseite',
                    'ueber_uns' => 'Über uns',
                    'konzept' => 'Konzept',
                    'kontakt' => 'Kontakt',
                ];
                foreach ($seiten as $s): ?>
                <a href="/admin/inhalte/<?= e($s['seite']) ?>" class="admin-link-karte">
                    <?= e($seiten_namen[$s['seite']] ?? $s['seite']) ?>
                    <span>Texte anpassen</span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Bilder verwalten -->
        <div class="admin-karte">
            <h2>Bilder verwalten</h2>
            <p style="margin-bottom: 20px; color: var(--farbe-text-leicht);">Bilder hochladen, austauschen oder löschen. Alle Bilder werden automatisch optimiert (komprimiert und Thumbnails erstellt).</p>
            <div class="admin-link-grid">
                <a href="/admin/bilder/startseite" class="admin-link-karte">
                    Startseite
                    <span>Bilder verwalten</span>
                </a>
                <a href="/admin/bilder/raeumlichkeiten" class="admin-link-karte">
                    Räumlichkeiten
                    <span>Bilder verwalten</span>
                </a>
                <a href="/admin/bilder/aussenbereich" class="admin-link-karte">
                    Außenbereich
                    <span>Bilder verwalten</span>
                </a>
            </div>
        </div>

        <!-- Team bearbeiten -->
        <div class="admin-karte">
            <h2>Team bearbeiten</h2>
            <p style="margin-bottom: 20px; color: var(--farbe-text-leicht);">Bearbeiten Sie die Informationen und Fotos Ihres Teams.</p>
            <div class="admin-link-grid">
                <a href="/admin/team" class="admin-link-karte">
                    Team verwalten
                    <span><?= count($team) ?> Mitglieder</span>
                </a>
            </div>
        </div>
    </div>

    <script src="/static/js/main.js"></script>
</body>
</html>
