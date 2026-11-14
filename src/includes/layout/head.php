<?php
/** @var array $page */
$canonical = absolute_url($page['canonical'] ?? $page['path']);
$ogImage = SITE_ORIGIN . ($page['og_image'] ?? asset('img/og-default.png'));
$schemas = $page['schema'] ?? [];

if (!empty($page['breadcrumbs'])) {
    $schemas[] = breadcrumb_schema($page['breadcrumbs']);
}
?>
<!doctype html>
<html lang="<?= e(SITE_LANG) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page['title']) ?></title>
    <meta name="description" content="<?= e($page['description']) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
<?php if (SITE_NOINDEX || !empty($page['noindex'])): ?>
    <meta name="robots" content="noindex">
<?php endif; ?>
    <meta name="theme-color" content="<?= e(THEME_COLOR) ?>">
    <link rel="icon" href="<?= e(asset('img/favicon.png')) ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?= e(asset('img/tsg-crest.png')) ?>">
    <link rel="preload" href="<?= e(url('assets/fonts/barlow-condensed-700-latin.woff2')) ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
    <script type="module" src="<?= e(asset('js/main.js')) ?>"></script>

    <meta property="og:type" content="<?= e($page['og_type'] ?? 'website') ?>">
    <meta property="og:locale" content="<?= e(SITE_LOCALE) ?>">
    <meta property="og:site_name" content="<?= e(SITE_NAME . ' · ' . CLUB_NAME) ?>">
    <meta property="og:title" content="<?= e($page['og_title'] ?? $page['title']) ?>">
    <meta property="og:description" content="<?= e($page['description']) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($page['og_title'] ?? $page['title']) ?>">
    <meta name="twitter:description" content="<?= e($page['description']) ?>">
    <meta name="twitter:image" content="<?= e($ogImage) ?>">
<?php foreach ($schemas as $schema): ?>
    <?= json_ld($schema) ?>

<?php endforeach; ?>
</head>
