<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Entenbach TigeR - Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach. Liebevolle U3-Betreuung mit 9 Plätzen.">
    <meta name="keywords" content="Kindertagespflege, Walddorfhäslach, U3, Kinderkrippe, Entenbach TigeR, Tagesmutter, Reutlingen">
    <title><?= e($seitentitel ?? 'Entenbach TigeR') ?> | Kindertagespflege Walddorfhäslach</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <header class="site-header" id="site-header">
        <nav class="nav-container">
            <a href="/" class="nav-logo">
                <img src="/static/images/Logo.jpg" alt="Entenbach TigeR Logo" loading="lazy">
            </a>

            <button class="nav-toggle" id="nav-toggle" aria-label="Menü öffnen">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="nav-menu">
                <li><a href="/" class="nav-link <?= ($aktive_seite ?? '') === 'startseite' ? 'aktiv' : '' ?>">Start</a></li>
                <li><a href="/ueber-uns" class="nav-link <?= ($aktive_seite ?? '') === 'ueber-uns' ? 'aktiv' : '' ?>">Über uns</a></li>
                <li><a href="/raeumlichkeiten" class="nav-link <?= ($aktive_seite ?? '') === 'raeumlichkeiten' ? 'aktiv' : '' ?>">Räumlichkeiten</a></li>
                <li><a href="/konzept" class="nav-link <?= ($aktive_seite ?? '') === 'konzept' ? 'aktiv' : '' ?>">Konzept</a></li>
                <li><a href="/kontakt" class="nav-link nav-link--cta <?= ($aktive_seite ?? '') === 'kontakt' ? 'aktiv' : '' ?>">Kontakt</a></li>
            </ul>
        </nav>
    </header>

    <!-- Flash Messages -->
    <?php if (!empty($flash_messages)): ?>
    <div class="flash-container">
        <?php foreach ($flash_messages as $msg): ?>
        <div class="flash flash--<?= e($msg['kategorie']) ?>"><?= e($msg['nachricht']) ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Hauptinhalt -->
    <main>
        <?= $page_content ?>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-wave">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,40 C360,100 720,0 1080,60 C1260,90 1380,40 1440,50 L1440,100 L0,100 Z" fill="var(--farbe-creme)"/>
            </svg>
        </div>
        <div class="footer-inhalt">
            <div class="footer-grid">
                <div class="footer-spalte">
                    <img src="/static/images/Logo.jpg" alt="Entenbach TigeR" class="footer-logo" loading="lazy">
                    <p class="footer-claim">Kindertagespflege im<br>historischen Fachwerkhaus</p>
                </div>
                <div class="footer-spalte">
                    <h4>Kontakt</h4>
                    <p>
                        <a href="tel:<?= e(get_inhalt('kontakt', 'telefon', '07127/9266-850')) ?>"><?= e(get_inhalt('kontakt', 'telefon', '07127/9266-850')) ?></a><br>
                        <a href="mailto:<?= e(get_inhalt('kontakt', 'email', 'info@entenbachtiger.de')) ?>"><?= e(get_inhalt('kontakt', 'email', 'info@entenbachtiger.de')) ?></a>
                    </p>
                </div>
                <div class="footer-spalte">
                    <h4>Adresse</h4>
                    <p><?= e(get_inhalt('kontakt', 'adresse', 'Brühlstr. 272, 72141 Walddorfhäslach')) ?></p>
                </div>
                <div class="footer-spalte">
                    <h4>Seiten</h4>
                    <ul>
                        <li><a href="/">Startseite</a></li>
                        <li><a href="/ueber-uns">Über uns</a></li>
                        <li><a href="/raeumlichkeiten">Räumlichkeiten</a></li>
                        <li><a href="/konzept">Konzept</a></li>
                        <li><a href="/kontakt">Kontakt</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-unten">
                <p>&copy; 2025 Entenbach TigeR &mdash; Kindertagespflege Walddorfhäslach</p>
                <p class="footer-verein">Angeschlossen an den Tagesmutterverein Reutlingen</p>
            </div>
        </div>
    </footer>

    <script src="/static/js/main.js"></script>
</body>
</html>
