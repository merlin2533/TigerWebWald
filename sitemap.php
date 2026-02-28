<?php
/**
 * Dynamische Sitemap (XML).
 * Wird ueber .htaccess als /sitemap.xml ausgeliefert.
 */
header('Content-Type: application/xml; charset=utf-8');

$basis_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');

$heute = date('Y-m-d');

$seiten = [
    ['pfad' => '/',               'prioritaet' => '1.0', 'frequenz' => 'weekly'],
    ['pfad' => '/ueber-uns',      'prioritaet' => '0.8', 'frequenz' => 'monthly'],
    ['pfad' => '/raeumlichkeiten', 'prioritaet' => '0.8', 'frequenz' => 'monthly'],
    ['pfad' => '/konzept',        'prioritaet' => '0.7', 'frequenz' => 'monthly'],
    ['pfad' => '/kontakt',        'prioritaet' => '0.9', 'frequenz' => 'monthly'],
    ['pfad' => '/faq',            'prioritaet' => '0.7', 'frequenz' => 'monthly'],
    ['pfad' => '/impressum',      'prioritaet' => '0.3', 'frequenz' => 'yearly'],
    ['pfad' => '/datenschutz',    'prioritaet' => '0.3', 'frequenz' => 'yearly'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($seiten as $s): ?>
    <url>
        <loc><?= htmlspecialchars($basis_url . $s['pfad']) ?></loc>
        <lastmod><?= $heute ?></lastmod>
        <changefreq><?= $s['frequenz'] ?></changefreq>
        <priority><?= $s['prioritaet'] ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
