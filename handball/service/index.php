<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$page = [
    'title' => 'Formulare und Anträge | TSG Handball Hatten-Sandkrug',
    'description' => 'Formulare der Handballabteilung zum Download: Abrechnungen für Trainer und Kampfgericht, Spielberechtigung und Gastspielrecht, Abteilungsordnung.',
    'path' => 'service/',
    'nav' => 'service',
    'breadcrumbs' => [['Service', 'service/']],
];

require INCLUDES_DIR . '/layout/start.php';
?>
<header class="page-hero">
    <div class="container page-hero__inner">
        <div class="page-hero__content">
            <?php partial('breadcrumb', ['breadcrumbs' => $page['breadcrumbs']]); ?>
            <h1>Formulare und Anträge</h1>
            <p class="page-hero__intro">Für Trainer, Kampfgericht, Spieler und Eltern. Die Hallenhefte findest du bei den <a class="link" href="<?= e(url('heimspiele/')) ?>">Heimspielen</a>, die Turnierunterlagen beim <a class="link" href="<?= e(url('kids-cup/')) ?>">Kids-Cup</a>.</p>
        </div>
    </div>
</header>
<section class="section" aria-label="Formulare">
    <div class="container grid grid--3 doc-groups">
<?php foreach (data('documents')['service'] as $group): ?>
        <section aria-label="<?= e($group['title']) ?>">
            <h2 class="list-heading"><?= e($group['title']) ?></h2>
            <ul class="row-list" role="list">
<?php foreach ($group['items'] as $item):
    $isExternal = !empty($item['external']);
    $meta = array_filter([
        $item['source'] ?? null,
        $item['format'] ?? null,
        isset($item['size']) ? format_file_size($item['size']) : null,
    ]);
?>
                <li class="row-list__item">
                    <a class="row-list__link" href="<?= e($item['url']) ?>"<?= $isExternal ? ' ' . external_attributes() : '' ?>>
                        <span class="row-list__label"><?= e($item['label']) ?><?= $isExternal ? '<span class="visually-hidden"> (öffnet in neuem Tab)</span>' : '' ?></span>
                        <span class="row-list__meta"><?= e(implode(' · ', $meta)) ?></span>
                    </a>
                </li>
<?php endforeach; ?>
            </ul>
        </section>
<?php endforeach; ?>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
