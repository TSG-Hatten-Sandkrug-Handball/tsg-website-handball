<?php
/**
 * Full-screen menu below 700 px (Lastenheft M-01 to M-04).
 * With JS it opens as a modal <dialog>; without JS the menu link targets
 * this element and CSS (:target) shows it.
 *
 * @var array $page
 * @var array $items
 */
?>
<dialog class="mobile-menu" id="mobile-menu" aria-label="Menü" data-mobile-menu>
    <div class="mobile-menu__header">
        <?php partial('brand'); ?>
        <a class="mobile-menu__close" href="#" data-menu-close>
            <?= icon('close') ?><span class="visually-hidden">Menü schließen</span>
        </a>
    </div>
    <nav class="mobile-menu__nav" aria-label="Hauptnavigation mobil">
        <ul class="mobile-menu__list">
<?php foreach ($items as $item): ?>
            <li>
                <a class="mobile-menu__link" href="<?= e(url($item['path'])) ?>"<?= $page['path'] === $item['path'] ? ' aria-current="page"' : '' ?>>
                    <?= e($item['label']) ?><?= icon('arrow-right', 'mobile-menu__arrow') ?>
                </a>
            </li>
<?php endforeach; ?>
        </ul>
    </nav>
    <div class="mobile-menu__actions">
        <?= button('Probetraining anfragen', trial_training_mailto(), 'primary') ?>
        <?= button('Zur Vereinsseite', link_url('club_home'), 'secondary') ?>
    </div>
</dialog>
