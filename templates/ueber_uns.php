<!-- Page Header -->
<section class="seiten-header">
    <div class="container">
        <span class="sektion-label aufdecken">Wer wir sind</span>
        <h1 class="aufdecken"><?= e($inhalte['titel'] ?? 'Über die EntenbachTigeR') ?></h1>
    </div>
</section>

<!-- Über uns Text -->
<section class="sektion sektion--hell">
    <div class="container">
        <div class="ueber-grid">
            <div class="ueber-text aufdecken">
                <p class="text-gross"><?= e($inhalte['text_1'] ?? '') ?></p>
                <p><?= e($inhalte['text_2'] ?? '') ?></p>
            </div>
            <div class="ueber-bild aufdecken">
                <img src="/static/images/Haus.jpg" alt="Historisches Altes Notariat in Walddorfhäslach - Standort der EntenbachTigeR Kindertagespflege" width="800" height="600" loading="lazy" decoding="async">
            </div>
        </div>
    </div>
</section>

<!-- Öffnungszeiten -->
<section class="sektion sektion--akzent">
    <div class="container text-mitte">
        <h2 class="aufdecken">Öffnungszeiten & Betreuungsmodelle</h2>
        <div class="zeiten-grid aufdecken">
            <div class="zeiten-karte">
                <div class="zeiten-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <h3>Modell 1</h3>
                <p class="zeiten-plaetze">5 Plätze</p>
                <p><?= e($inhalte['oeffnungszeiten_1'] ?? 'Montag–Donnerstag 07:30–15:00 Uhr, Freitag 08:00–12:30 Uhr') ?></p>
            </div>
            <div class="zeiten-karte">
                <div class="zeiten-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <h3>Modell 2</h3>
                <p class="zeiten-plaetze">4 Plätze</p>
                <p><?= e($inhalte['oeffnungszeiten_2'] ?? 'Montag–Donnerstag 07:30–12:30 Uhr, Freitag 08:00–12:30 Uhr') ?></p>
            </div>
        </div>
        <p class="aufdecken text-klein">Die betreuungsfreie Zeit umfasst 30 Schließtage pro Jahr. Die Schließtage werden spätestens bis zum 31.12. des Vorjahres bekannt gegeben.</p>
    </div>
</section>

<!-- Team Section -->
<section class="sektion sektion--hell" id="team">
    <div class="container">
        <div class="text-mitte">
            <span class="sektion-label aufdecken">Das Tiger-Team</span>
            <h2 class="aufdecken">Die Menschen hinter den EntenbachTigeRn</h2>
            <p class="text-gross aufdecken">Drei qualifizierte Tagespflegepersonen mit Herz, Erfahrung und der gemeinsamen Überzeugung: Jedes Kind verdient eine Betreuung, die es als Persönlichkeit ernst nimmt.</p>
        </div>
        <div class="team-grid">
            <?php foreach ($team as $mitglied): ?>
            <div class="team-karte aufdecken">
                <div class="team-bild">
                    <?php if (!empty($mitglied['bild'])): ?>
                    <img src="/static/uploads/<?= e($mitglied['bild']) ?>" alt="<?= e($mitglied['name']) ?>" loading="lazy" decoding="async">
                    <?php else: ?>
                    <div class="team-avatar">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="team-info">
                    <h3><?= e($mitglied['name']) ?></h3>
                    <span class="team-rolle"><?= e($mitglied['rolle']) ?></span>
                    <p><?= e($mitglied['beschreibung']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
