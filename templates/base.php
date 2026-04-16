<?php $flash_messages = get_flash_messages(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($meta_beschreibung ?? 'EntenbachTigeR - Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach. Liebevolle U3-Betreuung mit 9 Plätzen.') ?>">
    <meta name="keywords" content="Kindertagespflege, Walddorfhäslach, U3 Betreuung, Kinderbetreuung, Kinderkrippe, EntenbachTigeR, Tagesmutter, Tagespflege, Reutlingen, Kleinkindbetreuung, Kinderbetreuung Walddorfhäslach, U3 Walddorfhäslach, Kindertagespflege Reutlingen, Großtagespflege, Kinderbetreuung Reutlingen, Tagesmutter Walddorfhäslach">
    <title><?= e($seitentitel ?? 'EntenbachTigeR') ?> | Kindertagespflege Walddorfhäslach</title>

    <!-- Robots & Indexierung -->
    <?php if (($aktive_seite ?? '') === '404'): ?>
    <meta name="robots" content="noindex, nofollow">
    <?php else: ?>
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <?php endif; ?>

    <?php if (!empty($canonical_pfad)): ?>
    <link rel="canonical" href="<?= e($basis_url . $canonical_pfad) ?>">
    <?php endif; ?>

    <!-- Theme & Mobile Browser -->
    <meta name="theme-color" content="#1A3C4D">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="EntenbachTigeR">

    <!-- Geo-Tags fuer lokale Suche -->
    <meta name="geo.region" content="DE-BW">
    <meta name="geo.placename" content="Walddorfhäslach">
    <meta name="geo.position" content="48.5827;9.1800">
    <meta name="ICBM" content="48.5827, 9.1800">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= e($seitentitel ?? 'EntenbachTigeR') ?> | Kindertagespflege Walddorfhäslach">
    <meta property="og:description" content="<?= e($meta_beschreibung ?? 'Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach.') ?>">
    <meta property="og:image" content="<?= e($basis_url ?? '') ?>/static/images/Haus.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="EntenbachTigeR Kindertagespflege - Historisches Fachwerkhaus in Walddorfhäslach">
    <meta property="og:url" content="<?= e(($basis_url ?? '') . ($canonical_pfad ?? '/')) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="de_DE">
    <meta property="og:site_name" content="EntenbachTigeR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($seitentitel ?? 'EntenbachTigeR') ?> | Kindertagespflege Walddorfhäslach">
    <meta name="twitter:description" content="<?= e($meta_beschreibung ?? 'Kindertagespflege im historischen Fachwerkhaus in Walddorfhäslach.') ?>">
    <meta name="twitter:image" content="<?= e($basis_url ?? '') ?>/static/images/Haus.jpg">
    <meta name="twitter:image:alt" content="EntenbachTigeR Kindertagespflege - Historisches Fachwerkhaus in Walddorfhäslach">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/jpeg" href="/static/images/Logo.jpg">
    <link rel="apple-touch-icon" href="/static/images/Logo.jpg">
    <link rel="manifest" href="/manifest.webmanifest">

    <!-- Hero-Bild vorladen auf Startseite -->
    <?php if (($aktive_seite ?? '') === 'startseite'): ?>
    <link rel="preload" as="image" href="/static/images/Haus.jpg">
    <?php endif; ?>

    <!-- Preconnect fuer Google Maps (nur Kontaktseite) -->
    <?php if (($aktive_seite ?? '') === 'kontakt'): ?>
    <link rel="preconnect" href="https://www.google.com">
    <link rel="preconnect" href="https://maps.googleapis.com">
    <link rel="dns-prefetch" href="https://maps.gstatic.com">
    <?php endif; ?>

    <link rel="stylesheet" href="/static/css/style.css">

    <!-- Noscript: Animationen ohne JS sichtbar machen -->
    <noscript>
        <style>.aufdecken { opacity: 1 !important; transform: none !important; }</style>
    </noscript>

    <!-- Schema.org JSON-LD: Organisation (auf allen Seiten) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ChildCare",
        "@id": "<?= e($basis_url ?? '') ?>/#organization",
        "name": "EntenbachTigeR",
        "alternateName": ["EntenbachTigeR Kindertagespflege", "Kindertagespflege Walddorfhäslach", "Entenbach Tiger"],
        "description": "EntenbachTigeR - Kindertagespflege und U3-Betreuung im historischen Fachwerkhaus in Walddorfhäslach. 9 Betreuungsplätze für Kinder unter 3 Jahren mit 3 qualifizierten Tagespflegepersonen.",
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
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "48.5827",
            "longitude": "9.1800"
        },
        "hasMap": "https://www.google.com/maps?q=Brühlstr.+272,+72141+Walddorfhäslach",
        "image": [
            "<?= e($basis_url ?? '') ?>/static/images/Haus.jpg",
            "<?= e($basis_url ?? '') ?>/static/images/Logo.jpg"
        ],
        "logo": {
            "@type": "ImageObject",
            "url": "<?= e($basis_url ?? '') ?>/static/images/Logo.jpg",
            "width": 400,
            "height": 400
        },
        "numberOfEmployees": {
            "@type": "QuantitativeValue",
            "value": 3
        },
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
        "areaServed": [
            {"@type": "City", "name": "Walddorfhäslach"},
            {"@type": "City", "name": "Reutlingen"},
            {"@type": "AdministrativeArea", "name": "Landkreis Reutlingen"}
        ],
        "memberOf": {
            "@type": "Organization",
            "name": "Tagesmutterverein Reutlingen e.V."
        },
        "priceRange": "$$",
        "currenciesAccepted": "EUR",
        "paymentAccepted": "Überweisung",
        "isAccessibleForFree": false,
        "slogan": "Kindertagespflege im historischen Fachwerkhaus"
    }
    </script>

    <!-- Schema.org JSON-LD: WebSite -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "@id": "<?= e($basis_url ?? '') ?>/#website",
        "name": "EntenbachTigeR - Kindertagespflege Walddorfhäslach",
        "url": "<?= e($basis_url ?? '') ?>",
        "publisher": {"@id": "<?= e($basis_url ?? '') ?>/#organization"},
        "inLanguage": "de-DE"
    }
    </script>

    <?php if (!empty($breadcrumbs) && count($breadcrumbs) > 0): ?>
    <!-- Schema.org JSON-LD: BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            <?php foreach ($breadcrumbs as $i => $bc): ?>
            {
                "@type": "ListItem",
                "position": <?= $i + 1 ?>,
                "name": "<?= e($bc['name']) ?>",
                "item": "<?= e(($basis_url ?? '') . $bc['pfad']) ?>"
            }<?= $i < count($breadcrumbs) - 1 ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>

    <?php if (($aktive_seite ?? '') === 'faq'): ?>
    <!-- Schema.org FAQPage JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "name": "Häufige Fragen zur Kindertagespflege EntenbachTigeR",
        "description": "Antworten auf häufige Fragen zu Kosten, Eingewöhnung, Betreuung und Anmeldung bei der Kindertagespflege EntenbachTigeR in Walddorfhäslach.",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "Was ist Kindertagespflege und wie unterscheidet sie sich von einer Kita?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Kindertagespflege ist eine gesetzlich anerkannte und gleichwertige Betreuungsform neben der Kita. Bei EntenbachTigeR werden Kinder in einer kleinen, familienähnlichen Großtagespflege mit maximal 9 Betreuungsplätzen von drei qualifizierten Tagespflegepersonen betreut. Der größte Vorteil ist die familiäre Atmosphäre mit deutlich mehr individueller Zuwendung."
                }
            },
            {
                "@type": "Question",
                "name": "Welche Kinder werden bei Ihnen betreut?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Wir betreuen Kinder unter 3 Jahren (U3) — in der Regel ab ca. 1 Jahr bis zum Übergang in den Kindergarten. Seit dem 1. August 2013 haben Kinder ab dem vollendeten ersten Lebensjahr einen Rechtsanspruch auf einen Betreuungsplatz."
                }
            },
            {
                "@type": "Question",
                "name": "Welche Öffnungszeiten und Betreuungsmodelle gibt es?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Montag bis Donnerstag: 7:30–15:00 Uhr, Freitag: 8:00–12:30 Uhr. Je nach Verfügbarkeit bieten wir verschiedene Betreuungsmodelle an. Ein Vorteil der Kindertagespflege ist die Möglichkeit, flexible und individuelle Betreuungszeiten zu vereinbaren."
                }
            },
            {
                "@type": "Question",
                "name": "Was kostet ein Betreuungsplatz?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Die Kosten werden größtenteils vom Jugendamt getragen. Der Betreuungssatz liegt bei ca. 7,50 € pro Stunde für U3-Kinder. Eltern zahlen einen einkommensabhängigen Elternbeitrag an die Gemeinde, vergleichbar mit Kita-Gebühren. Zusätzlich kann Essensgeld anfallen."
                }
            },
            {
                "@type": "Question",
                "name": "Wie läuft die Eingewöhnung ab?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Die Eingewöhnung orientiert sich am Berliner Eingewöhnungsmodell und dauert in der Regel 2 bis 4 Wochen. Sie umfasst eine Grundphase mit Elternbegleitung, erste Trennungsversuche, eine Stabilisierungsphase und den Abschluss, wenn das Kind sich sicher fühlt."
                }
            },
            {
                "@type": "Question",
                "name": "Welche Qualifikation haben die Tagespflegepersonen?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Alle drei Tagespflegepersonen verfügen über eine qualifizierte Ausbildung nach dem kompetenzorientierten Qualifizierungshandbuch (QHB) mit mindestens 160 Unterrichtseinheiten. Sie nehmen regelmäßig an Fortbildungen teil und werden fachlich durch den Tagesmutterverein Reutlingen begleitet."
                }
            },
            {
                "@type": "Question",
                "name": "Wie kann ich mein Kind anmelden?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Der erste Schritt ist ein persönliches Kennenlerngespräch mit Besichtigung der Räumlichkeiten. Danach folgt der Betreuungsvertrag und die sanfte Eingewöhnung. Wir empfehlen, sich frühzeitig zu melden, da unsere Plätze begrenzt sind."
                }
            },
            {
                "@type": "Question",
                "name": "Was passiert, wenn eine Tagespflegeperson krank wird?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Da wir als Großtagespflege mit drei Tagespflegepersonen arbeiten, ist die Vertretung bei Krankheit oder Urlaub in der Regel intern abgesichert. Die Kinder kennen alle Bezugspersonen. Der Tagesmutterverein Reutlingen unterstützt zusätzlich bei der Organisation von Vertretungslösungen."
                }
            },
            {
                "@type": "Question",
                "name": "Wo befindet sich die Einrichtung?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Die EntenbachTigeR Kindertagespflege befindet sich in der Brühlstr. 272 in 72141 Walddorfhäslach — in einem historischen Fachwerkhaus (dem Alten Notariat). Die Räumlichkeiten umfassen Spielzimmer, Bewegungsraum, Schlafraum, Essbereich, Wickelbereich, Küche sowie Garten und Außenbereich."
                }
            }
        ]
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
                <img src="/static/images/Logo.jpg" alt="EntenbachTigeR - Kindertagespflege Walddorfhäslach" width="48" height="48">
            </a>

            <button class="nav-toggle" id="nav-toggle" aria-label="Menü öffnen">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="nav-menu" role="menubar">
                <li role="none"><a href="/" class="nav-link <?= ($aktive_seite ?? '') === 'startseite' ? 'aktiv' : '' ?>" role="menuitem" <?= ($aktive_seite ?? '') === 'startseite' ? 'aria-current="page"' : '' ?>>Start</a></li>
                <li role="none"><a href="/ueber-uns" class="nav-link <?= ($aktive_seite ?? '') === 'ueber-uns' ? 'aktiv' : '' ?>" role="menuitem" <?= ($aktive_seite ?? '') === 'ueber-uns' ? 'aria-current="page"' : '' ?>>Über uns</a></li>
                <li role="none"><a href="/raeumlichkeiten" class="nav-link <?= ($aktive_seite ?? '') === 'raeumlichkeiten' ? 'aktiv' : '' ?>" role="menuitem" <?= ($aktive_seite ?? '') === 'raeumlichkeiten' ? 'aria-current="page"' : '' ?>>Räumlichkeiten</a></li>
                <li role="none"><a href="/konzept" class="nav-link <?= ($aktive_seite ?? '') === 'konzept' ? 'aktiv' : '' ?>" role="menuitem" <?= ($aktive_seite ?? '') === 'konzept' ? 'aria-current="page"' : '' ?>>Konzept</a></li>
                <li role="none"><a href="/faq" class="nav-link <?= ($aktive_seite ?? '') === 'faq' ? 'aktiv' : '' ?>" role="menuitem" <?= ($aktive_seite ?? '') === 'faq' ? 'aria-current="page"' : '' ?>>FAQ</a></li>
                <li role="none"><a href="/kontakt" class="nav-link nav-link--cta <?= ($aktive_seite ?? '') === 'kontakt' ? 'aktiv' : '' ?>" role="menuitem" <?= ($aktive_seite ?? '') === 'kontakt' ? 'aria-current="page"' : '' ?>>Kontakt</a></li>
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
                    <img src="/static/images/Logo.jpg" alt="EntenbachTigeR Kindertagespflege" class="footer-logo" width="60" height="60" loading="lazy" decoding="async">
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
                        <li><a href="/faq">FAQ</a></li>
                        <li><a href="/kontakt">Kontakt</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-unten">
                <p>&copy; <?= date('Y') ?> EntenbachTigeR &mdash; Kindertagespflege Walddorfhäslach</p>
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
