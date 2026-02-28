<?php
$raum_beschreibungen = [
    'spielzimmer' => 'Hier wird gespielt, gebaut und geträumt: Unser großzügiges Spielzimmer mit Kinderküche, Bauecke und kuscheliger Leseecke bietet vielfältige Möglichkeiten — für Rollenspiele, kreatives Bauen und ruhige Momente mit Büchern.',
    'bewegungsraum' => 'Klettern, schaukeln, rollen — unser Bewegungsraum mit Nestschaukel, Bällebad und modularer Bewegungslandschaft lädt zum Toben ein. Zur Mittagszeit verwandelt er sich in einen ruhigen Schlafraum.',
    'schlafraum' => 'Jedes Kind hat seinen eigenen festen Schlafplatz mit individueller Bettwäsche. Sanftes Licht, Ruhe und Geborgenheit sorgen dafür, dass die Kinder entspannt in die Mittagsruhe finden.',
    'garderobe' => 'Eigener Haken, eigenes Fach — in unserer Garderobe hat jedes Kind seinen persönlichen Platz. Das fördert die Selbstständigkeit und gibt Orientierung beim täglichen Ankommen und Verabschieden.',
    'essbereich' => 'An unserem großen Esstisch mit ergonomischen Kinderstühlen werden die Mahlzeiten gemeinsam eingenommen. Unter den wunderschönen alten Holzbalken schmeckt es gleich doppelt gut.',
    'kueche' => 'Frisch, ausgewogen und mit Liebe zubereitet: In unserer voll ausgestatteten Küche kochen wir täglich frisch. Durch die offene Gestaltung behalten wir dabei immer den Essbereich im Blick.',
    'wickelbereich' => 'Unser Sanitärbereich ist konsequent kindgerecht gestaltet: Wickelplatz mit Treppe zum selbstständigen Hinaufklettern, persönliche Fächer für jedes Kind und Waschbecken in Kinderhöhe — alles mit Verbrühungsschutz.',
];
?>
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
                <p><?= e($raum_beschreibungen[$schluessel] ?? '') ?></p>
            </div>
            <div class="galerie-grid galerie-grid--<?= count($bilder_liste) ?>">
                <?php foreach ($bilder_liste as $bild): ?>
                <div class="galerie-item" data-vollbild="/<?= e(bild_pfad($bild['dateiname'])) ?>">
                    <img src="/<?= e(bild_pfad($bild['dateiname'])) ?>"
                         alt="<?= e($bild['alt_text']) ?>"
                         loading="lazy">
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
