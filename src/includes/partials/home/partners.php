<?php
// Partner grid (Lastenheft UE-07). Links are marked as sponsored for search engines.
?>
<section class="section" aria-labelledby="home-partners-title">
    <div class="container">
        <div class="section-head">
            <div class="section-head__text">
                <p class="kicker">Starke Partner</p>
                <h2 id="home-partners-title">Partner des Handballs in Hatten</h2>
            </div>
            <a class="text-link" href="<?= e(link_url('sponsoring')) ?>" <?= external_attributes() ?>>Partner werden</a>
        </div>
        <ul class="partner-grid" role="list">
<?php foreach (data('partners') as $partner): ?>
            <li class="partner-grid__item">
                <a class="partner-grid__link" href="<?= e($partner['url']) ?>" target="_blank" rel="sponsored noopener">
<?php if ($partner['logo'] !== null): ?>
                    <img class="partner-grid__logo" src="<?= e(url($partner['logo'])) ?>" alt="<?= e($partner['name']) ?>" width="300" height="200" loading="lazy">
<?php else: ?>
                    <?= e($partner['name']) ?>
<?php endif; ?>
                </a>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
