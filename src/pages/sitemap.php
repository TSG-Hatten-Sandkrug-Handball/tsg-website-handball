<?php
/**
 * XML sitemap (Lastenheft SEO-04), generated as sitemap.xml.
 *
 * @var array $params routes
 */
$lastModified = [];
foreach (news_items() as $item) {
    $lastModified['neuigkeiten/' . $item['slug'] . '/'] = $item['date']->format('Y-m-d');
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($params['routes'] as $route): ?>
<?php if ($route['sitemap']): ?>
    <url>
        <loc><?= e(absolute_url($route['path'])) ?></loc>
<?php if (isset($lastModified[$route['path']])): ?>
        <lastmod><?= e($lastModified[$route['path']]) ?></lastmod>
<?php endif; ?>
    </url>
<?php endif; ?>
<?php endforeach; ?>
</urlset>
