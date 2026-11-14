<?php
// XML sitemap, served as /handball/sitemap.xml (rewrite in .htaccess).
// Reference it from the domain's robots.txt or sitemap index (Lastenheft SEO-04).
require __DIR__ . '/includes/bootstrap.php';

$entries = [];

foreach (['', 'neuigkeiten/', 'termine/', 'mannschaften/', 'heimspiele/', 'kids-cup/', 'foerderkreis/', 'abteilung/', 'uebungsleiter/', 'schiedsrichter/', 'mitmachen/', 'service/', 'kontakt/'] as $path) {
    $entries[] = ['loc' => absolute_url($path), 'lastmod' => null];
}

foreach (teams() as $team) {
    $entries[] = ['loc' => SITE_ORIGIN . team_url($team), 'lastmod' => null];
}

foreach (news_items() as $item) {
    $entries[] = ['loc' => SITE_ORIGIN . news_url($item), 'lastmod' => $item['date']->format('Y-m-d')];
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($entries as $entry): ?>
    <url>
        <loc><?= e($entry['loc']) ?></loc>
<?php if ($entry['lastmod'] !== null): ?>
        <lastmod><?= e($entry['lastmod']) ?></lastmod>
<?php endif; ?>
    </url>
<?php endforeach; ?>
</urlset>
