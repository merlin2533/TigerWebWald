<section class="seiten-header">
    <div class="container">
        <span class="sektion-label aufdecken">Unsere Räume</span>
        <h1 class="aufdecken">Räumlichkeiten</h1>
        <p class="text-gross aufdecken">Im Dachgeschoss des historischen Alten Notariats stehen liebevoll gestaltete und funktional eingerichtete Räume zur Verfügung.</p>
    </div>
</section>

<section class="sektion sektion--hell">
    <div class="container">
        <?php foreach ($kategorien as $schluessel => $bilder_liste): ?>
        <div class="raum-sektion aufdecken">
            <div class="raum-header">
                <h2><?= e($kategorie_namen[$schluessel] ?? $schluessel) ?></h2>
                <p><?= e($kategorie_beschreibungen[$schluessel] ?? '') ?></p>
            </div>
            <div class="galerie-grid galerie-grid--<?= count($bilder_liste) ?>">
                <?php foreach ($bilder_liste as $bild): ?>
                <div class="galerie-item" data-vollbild="/<?= e(bild_pfad($bild['dateiname'])) ?>">
                    <img src="/<?= e(bild_pfad($bild['dateiname'])) ?>"
                         alt="<?= e($bild['alt_text']) ?>"
                         loading="lazy" decoding="async">
                    <div class="galerie-overlay">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                            <path d="M11 8v6M8 11h6"/>
                        </svg>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <button class="lightbox-schliessen" aria-label="Schließen">&times;</button>
    <img src="" alt="" id="lightbox-bild">
</div>
