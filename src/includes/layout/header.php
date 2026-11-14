<?php
/** @var array $page */
$navigation = data('navigation');
?>
<a class="skip-link" href="#main">Zum Inhalt springen</a>
<header class="site-header">
    <div class="container site-header__inner">
        <?php partial('brand'); ?>
        <nav class="main-nav" aria-label="Hauptnavigation">
            <ul class="main-nav__list">
<?php foreach ($navigation['main'] as $item):
    $isCurrent = $page['path'] === $item['path'];
    $isActive = ($page['nav'] ?? null) === $item['key'];
    $current = $isCurrent ? ' aria-current="page"' : ($isActive ? ' aria-current="true"' : '');
?>
                <li><a class="main-nav__link" href="<?= e(url($item['path'])) ?>"<?= $current ?>><?= e($item['label']) ?></a></li>
<?php endforeach; ?>
            </ul>
        </nav>
        <a class="button button--primary site-header__cta" href="<?= href(trial_training_mailto()) ?>">Probetraining anfragen</a>
        <a class="menu-toggle" href="#mobile-menu" aria-controls="mobile-menu" aria-haspopup="dialog" data-menu-open>
            <?= icon('menu') ?><span class="visually-hidden">Menü öffnen</span>
        </a>
    </div>
</header>
<?php partial('mobile-menu', ['page' => $page, 'items' => $navigation['mobile']]); ?>
