<?php
/** @var array $page */
$isContactPage = $page['path'] === 'kontakt/';
$links = [
    ['label' => 'Zur Vereinsseite', 'url' => link_url('club_home'), 'external' => true],
    $isContactPage
        ? ['label' => 'Instagram', 'url' => link_url('instagram'), 'external' => true]
        : ['label' => 'Kontakt', 'url' => url('kontakt/'), 'external' => false],
    ['label' => 'Impressum', 'url' => link_url('imprint'), 'external' => true],
    ['label' => 'Datenschutz', 'url' => link_url('privacy'), 'external' => true],
];
$extendedLinks = [
    ['label' => 'Zur Vereinsseite', 'url' => link_url('club_home')],
    ['label' => 'Instagram', 'url' => link_url('instagram')],
    ['label' => 'Fanshop', 'url' => link_url('fanshop')],
    ['label' => 'Impressum', 'url' => link_url('imprint')],
    ['label' => 'Datenschutz', 'url' => link_url('privacy')],
];
?>
<footer class="site-footer<?= !empty($page['extended_footer']) ? ' site-footer--extended' : '' ?>">
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            <img class="site-footer__crest" src="<?= e(asset('img/tsg-crest.webp')) ?>" alt="" width="134" height="133" loading="lazy">
<?php if (!empty($page['extended_footer'])): ?>
            <div>
                <p class="site-footer__title">TSG Hatten-Sandkrug · Handball</p>
                <p class="site-footer__address">Sportzentrum an der Schultredde, Hatten</p>
            </div>
<?php else: ?>
            <p class="site-footer__title">TSG Hatten-Sandkrug e.V. · Handball</p>
<?php endif; ?>
        </div>
<?php if (!empty($page['extended_footer'])): ?>
        <nav class="site-footer__sitemap" aria-label="Seitenverzeichnis">
<?php foreach (data('navigation')['footer_sitemap'] as $column): ?>
            <ul class="site-footer__list">
<?php foreach ($column as $item): ?>
                <li><a class="site-footer__link" href="<?= e(url($item['path'])) ?>"><?= e($item['label']) ?></a></li>
<?php endforeach; ?>
            </ul>
<?php endforeach; ?>
            <ul class="site-footer__list">
<?php foreach ($extendedLinks as $item): ?>
                <li><a class="site-footer__link" href="<?= e($item['url']) ?>" <?= external_attributes() ?>><?= e($item['label']) ?></a></li>
<?php endforeach; ?>
            </ul>
        </nav>
<?php else: ?>
        <nav aria-label="Fußzeile">
            <ul class="site-footer__links">
<?php foreach ($links as $item): ?>
                <li><a class="site-footer__link" href="<?= e($item['url']) ?>"<?= $item['external'] ? ' ' . external_attributes() : '' ?>><?= e($item['label']) ?></a></li>
<?php endforeach; ?>
            </ul>
        </nav>
<?php endif; ?>
    </div>
</footer>
