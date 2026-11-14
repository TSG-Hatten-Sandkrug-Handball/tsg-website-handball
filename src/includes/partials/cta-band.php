<?php
/**
 * Full-width call-to-action band.
 *
 * @var string      $title
 * @var string      $text
 * @var string      $action  button HTML
 * @var string|null $kicker
 * @var string|null $variant brand (default) | brand-dark
 */
$variant = $variant ?? 'brand';
?>
<section class="section section--<?= e($variant) ?> cta-band">
    <div class="container cta-band__inner">
        <div class="stack">
<?php if (!empty($kicker)): ?>
            <p class="kicker"><?= e($kicker) ?></p>
<?php endif; ?>
            <h2><?= e($title) ?></h2>
            <p><?= e($text) ?></p>
        </div>
        <div><?= $action ?></div>
    </div>
</section>
