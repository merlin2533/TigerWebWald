<!-- Hero Section -->
<section class="hero">
    <div class="hero-bild">
        <img src="/static/images/Haus.jpg" alt="Fachwerkhaus der EntenbachTigeR" loading="eager">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-inhalt">
        <img src="/static/images/Logo.jpg" alt="EntenbachTigeR Logo" class="hero-logo aufdecken">
        <h1 class="aufdecken"><?= e($inhalte['hero_titel'] ?? 'Willkommen beim EntenbachTigeR') ?></h1>
        <p class="hero-untertitel aufdecken"><?= e($inhalte['hero_untertitel'] ?? 'Kindertagespflege im historischen Fachwerkhaus') ?></p>
        <a href="/kontakt" class="btn btn--primary aufdecken">Jetzt Kennenlernen</a>
    </div>
    <div class="hero-scroll-hinweis">
        <span>Mehr entdecken</span>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12l7 7 7-7"/>
        </svg>
    </div>
</section>

<!-- Intro Section -->
<section class="sektion sektion--hell">
    <div class="container">
        <div class="intro-grid">
            <div class="intro-text aufdecken">
                <span class="sektion-label">Herzlich Willkommen</span>
                <h2>Ein Ort, an dem Kindheit zählt</h2>
                <p class="text-gross"><?= e($inhalte['intro_text'] ?? 'Im Herzen von Walddorf bieten wir 9 Betreuungsplätze für Kinder unter 3 Jahren.') ?></p>
                <p class="text-hervorhebung"><?= e($inhalte['cta_text'] ?? 'Lernen Sie uns und unsere Räumlichkeiten kennen!') ?></p>
                <div class="intro-zahlen">
                    <div class="zahl-box aufdecken">
                        <span class="zahl">9</span>
                        <span class="zahl-label">Betreuungs&shy;plätze</span>
                    </div>
                    <div class="zahl-box aufdecken">
                        <span class="zahl">3</span>
                        <span class="zahl-label">Tagespflege&shy;personen</span>
                    </div>
                    <div class="zahl-box aufdecken">
                        <span class="zahl">U3</span>
                        <span class="zahl-label">Alters&shy;bereich</span>
                    </div>
                </div>
            </div>
            <div class="intro-bilder aufdecken">
                <div class="bild-collage">
                    <img src="/static/images/Raum1.jpg" alt="Spielzimmer" class="collage-1" loading="lazy" decoding="async">
                    <img src="/static/images/Essbereich.jpg" alt="Essbereich" class="collage-2" loading="lazy" decoding="async">
                    <img src="/static/images/Aueßen1.jpg" alt="Außenbereich" class="collage-3" loading="lazy" decoding="async">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Highlights Section -->
<section class="sektion sektion--akzent">
    <div class="container">
        <div class="highlights-grid">
            <div class="highlight-karte aufdecken">
                <div class="highlight-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <h3>Sichere Bindung</h3>
                <p>Vertrauen ist die Grundlage. Durch feste Bezugspersonen und einfühlsame Begleitung geben wir Ihrem Kind die Sicherheit, die es braucht, um mutig die Welt zu entdecken.</p>
                <a href="/ueber-uns#team" class="link-pfeil">Unser Team</a>
            </div>
            <div class="highlight-karte aufdecken">
                <div class="highlight-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <h3>Verlässlicher Rahmen</h3>
                <p>Morgenkreis, gemeinsame Mahlzeiten, Freispiel und Ruhezeiten — wiederkehrende Rituale geben kleinen Kindern die Orientierung und Stabilität, die sie brauchen.</p>
                <a href="/raeumlichkeiten" class="link-pfeil">Unsere Räume</a>
            </div>
            <div class="highlight-karte aufdecken">
                <div class="highlight-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <h3>Selbstständigkeit fördern</h3>
                <p>Nach Maria Montessori: „Hilf mir, es selbst zu tun." Wir geben Kindern Zeit und Raum, eigene Erfahrungen zu machen — und stärken so ihr Selbstvertrauen nachhaltig.</p>
                <a href="/konzept" class="link-pfeil">Unser Konzept</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="sektion sektion--cta">
    <div class="container text-mitte">
        <h2 class="aufdecken">Neugierig geworden?</h2>
        <p class="text-gross aufdecken">Vereinbaren Sie einen unverbindlichen Besichtigungstermin — wir zeigen Ihnen gerne unsere Räume und beantworten alle Ihre Fragen.</p>
        <div class="cta-buttons aufdecken">
            <a href="tel:<?= e(get_inhalt('kontakt', 'telefon', '07127/9266-850')) ?>" class="btn btn--primary btn--gross">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Anrufen
            </a>
            <a href="mailto:<?= e(get_inhalt('kontakt', 'email', 'info@entenbachtiger.de')) ?>" class="btn btn--secondary btn--gross">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                E-Mail schreiben
            </a>
        </div>
    </div>
</section>
