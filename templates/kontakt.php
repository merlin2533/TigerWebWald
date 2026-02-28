<section class="seiten-header">
    <div class="container">
        <span class="sektion-label aufdecken">Wir freuen uns auf Sie</span>
        <h1 class="aufdecken"><?= e($inhalte['titel'] ?? 'Kontakt & Besichtigung') ?></h1>
        <p class="text-gross aufdecken"><?= e($inhalte['text'] ?? 'Vereinbaren Sie gerne einen Besichtigungstermin.') ?></p>
    </div>
</section>

<section class="sektion sektion--hell">
    <div class="container">
        <div class="kontakt-grid">
            <div class="kontakt-karten">
                <div class="kontakt-karte aufdecken">
                    <div class="kontakt-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <h3>Telefon</h3>
                    <a href="tel:<?= e($inhalte['telefon'] ?? '07127/9266-850') ?>" class="kontakt-wert"><?= e($inhalte['telefon'] ?? '07127/9266-850') ?></a>
                    <p>Am besten erreichbar während der Betreuungszeiten</p>
                </div>

                <div class="kontakt-karte aufdecken">
                    <div class="kontakt-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <h3>E-Mail</h3>
                    <a href="mailto:<?= e($inhalte['email'] ?? 'info@entenbachtiger.de') ?>" class="kontakt-wert"><?= e($inhalte['email'] ?? 'info@entenbachtiger.de') ?></a>
                    <p>Wir antworten in der Regel innerhalb von 1–2 Werktagen</p>
                </div>

                <div class="kontakt-karte aufdecken">
                    <div class="kontakt-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <h3>Adresse</h3>
                    <p class="kontakt-wert"><?= e($inhalte['adresse'] ?? 'Brühlstr. 272, 72141 Walddorfhäslach') ?></p>
                    <p>Im historischen Alten Notariat in Walddorf</p>
                </div>
            </div>

            <div class="kontakt-karte kontakt-karte--karte aufdecken">
                <h3>So finden Sie uns</h3>
                <div class="karte-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2634.5!2d9.18!3d48.58!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sBr%C3%BChlstr.+272%2C+72141+Walddorfh%C3%A4slach!5e0!3m2!1sde!2sde!4v1"
                        width="100%"
                        height="350"
                        style="border:0; border-radius: 12px;"
                        allowfullscreen=""
                        loading="lazy" decoding="async"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Standort EntenbachTigeR">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
