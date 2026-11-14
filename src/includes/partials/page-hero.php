<?php
/**
 * Subpage header (Lastenheft B-01).
 *
 * @var array $page  provides the breadcrumbs
 * @var array $hero  title, intro?, kicker?, note?, variant? (plain|dark|brand|xl, space separated),
 *                   actions? (HTML), aside? (HTML, button on the right), media? (HTML, image column),
 *                   before_title? (HTML, e.g. a league tag), after_title? (HTML), after_actions? (HTML)
 */
$variants = isset($hero['variant']) ? array_map(function (string $variant): string {
    return 'page-hero--' . $variant;
}, explode(' ', $hero['variant'])) : [];
$layout = isset($hero['media']) ? ' page-hero__inner--media' : (isset($hero['aside']) ? ' page-hero__inner--aside' : '');
?>
<header class="page-hero <?= e(implode(' ', $variants)) ?>">
    <div class="container page-hero__inner<?= $layout ?>">
        <div class="page-hero__content">
            <?php partial('breadcrumb', ['breadcrumbs' => $page['breadcrumbs']]); ?>
<?php if (isset($hero['kicker'])): ?>
            <p class="kicker"><?= e($hero['kicker']) ?></p>
<?php endif; ?>
            <?= $hero['before_title'] ?? '' ?>
            <h1><?= e($hero['title']) ?></h1>
            <?= $hero['after_title'] ?? '' ?>
<?php if (isset($hero['intro'])): ?>
            <p class="page-hero__intro"><?= e($hero['intro']) ?></p>
<?php endif; ?>
<?php if (isset($hero['note'])): ?>
            <p class="page-hero__note"><?= e($hero['note']) ?></p>
<?php endif; ?>
<?php if (isset($hero['actions'])): ?>
            <div class="button-row page-hero__actions"><?= $hero['actions'] ?></div>
<?php endif; ?>
            <?= $hero['after_actions'] ?? '' ?>
        </div>
<?php if (isset($hero['aside'])): ?>
        <div class="page-hero__aside"><?= $hero['aside'] ?></div>
<?php endif; ?>
<?php if (isset($hero['media'])): ?>
        <?= $hero['media'] ?>

<?php endif; ?>
    </div>
</header>
