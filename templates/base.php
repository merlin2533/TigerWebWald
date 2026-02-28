<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($meta_beschreibung ?? 'Entenbach TigeR - Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach. Liebevolle U3-Betreuung mit 9 Plätzen.') ?>">
    <meta name="keywords" content="Kindertagespflege, Walddorfhäslach, U3, Kinderkrippe, Entenbach TigeR, Tagesmutter, Reutlingen">
    <title><?= e($seitentitel ?? 'Entenbach TigeR') ?> | Kindertagespflege Walddorfhäslach</title>

    <?php if (!empty($canonical_pfad)): ?>
    <link rel="canonical" href="<?= e($basis_url . $canonical_pfad) ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:title" content="<?= e($seitentitel ?? 'Entenbach TigeR') ?> | Kindertagespflege Walddorfhäslach">
    <meta property="og:description" content="<?= e($meta_beschreibung ?? 'Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach.') ?>">
    <meta property="og:image" content="<?= e($basis_url ?? '') ?>/static/images/Haus.jpg">
    <meta property="og:url" content="<?= e(($basis_url ?? '') . ($canonical_pfad ?? '/')) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="de_DE">
    <meta property="og:site_name" content="Entenbach TigeR">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="/static/images/Logo.jpg">
    <link rel="apple-touch-icon" href="/static/images/Logo.jpg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Hero-Bild vorladen auf Startseite -->
    <?php if (($aktive_seite ?? '') === 'startseite'): ?>
    <link rel="preload" as="image" href="/static/images/Haus.jpg">
    <?php endif; ?>

    <link rel="stylesheet" href="/static/css/style.css">

    <!-- Noscript: Animationen ohne JS sichtbar machen -->
    <noscript>
        <style>.aufdecken { opacity: 1 !important; transform: none !important; }</style>
    </noscript>

    <?php if (($aktive_seite ?? '') === 'startseite'): ?>
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ChildCare",
        "name": "Entenbach TigeR",
        "description": "Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach. 9 Betreuungsplätze für Kinder unter 3 Jahren.",
        "url": "<?= e($basis_url ?? '') ?>",
        "telephone": "<?= e(get_inhalt('kontakt', 'telefon', '07127/9266-850')) ?>",
        "email": "<?= e(get_inhalt('kontakt', 'email', 'info@entenbachtiger.de')) ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Brühlstr. 272",
            "addressLocality": "Walddorfhäslach",
            "postalCode": "72141",
            "addressRegion": "Baden-Württemberg",
            "addressCountry": "DE"
        },
        "image": "<?= e($basis_url ?? '') ?>/static/images/Haus.jpg",
        "logo": "<?= e($basis_url ?? '') ?>/static/images/Logo.jpg",
        "numberOfEmployees": 3,
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday"],
                "opens": "07:30",
                "closes": "15:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": "Friday",
                "opens": "08:00",
                "closes": "12:30"
            }
        ],
        "areaServed": {
            "@type": "City",
            "name": "Walddorfhäslach"
        },
        "priceRange": "$$"
    }
    </script>
    <?php endif; ?>
</head>
<body>
    <!-- Skip-Link fuer Barrierefreiheit -->
    <a href="#hauptinhalt" class="skip-link">Zum Hauptinhalt springen</a>

    <!-- Navigation -->
    <header class="site-header" id="site-header">
        <nav class="nav-container">
            <a href="/" class="nav-logo">
                <img src="/static/images/Logo.jpg" alt="Entenbach TigeR Logo" width="48" height="48">
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
    <main id="hauptinhalt">
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
                    <img src="/static/images/Logo.jpg" alt="Entenbach TigeR" class="footer-logo" loading="lazy" decoding="async">
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
                <p>&copy; <?= date('Y') ?> Entenbach TigeR &mdash; Kindertagespflege Walddorfhäslach</p>
                <p class="footer-verein">Angeschlossen an den Tagesmutterverein Reutlingen</p>
                <p class="footer-legal">
                    <a href="/impressum">Impressum</a> &middot; <a href="/datenschutz">Datenschutz</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Cookie-Hinweis -->
    <div class="cookie-banner" id="cookie-banner" hidden>
        <p>Diese Website verwendet nur technisch notwendige Cookies. Kein Tracking, keine Werbung.</p>
        <button class="btn btn--primary btn--klein" id="cookie-ok">Verstanden</button>
    </div>

    <script src="/static/js/main.js"></script>
</body>
</html>
