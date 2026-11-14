<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$supportClub = data('support-club');

$page = [
    'title' => 'Förderkreis TSG 2000: Jugendhandball fördern | TSG Handball',
    'description' => 'Der Förderkreis TSG 2000 unterstützt seit 1988 den Jugendhandball der TSG Hatten-Sandkrug: Mitglied werden für 24 €, ein Hallenfeld pachten für 25 € oder spenden.',
    'path' => 'foerderkreis/',
    'nav' => 'support-club',
    'breadcrumbs' => [['Förderkreis', 'foerderkreis/']],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'variant' => 'plain',
    'kicker' => 'Förderkreis TSG 2000 · seit 1988',
    'title' => 'Ein Feld im Hallenboden für die Jugend',
    'intro' => 'Der Förderkreis bezahlt, was der Beitrag nicht trägt. Auf der Tafel in der Halle an der Waldschule ist der Hallenboden in Felder geteilt; jedes gepachtete Feld trägt den Namen seines Paten.',
    'actions' => button('Förderkreis schreiben', mailto($supportClub['email'], 'Förderkreis'), 'primary'),
    'media' => media(null, 'landscape', 'Jugendmannschaft, unterstützt vom Förderkreis', ['loading' => 'eager']),
]]);
?>
<section class="section section--surface" aria-labelledby="support-options-title">
    <div class="container">
        <h2 class="visually-hidden" id="support-options-title">So kannst du unterstützen</h2>
        <ul class="grid grid--3" role="list">
<?php foreach ($supportClub['options'] as $option): ?>
            <li class="card price-card">
                <h3 class="price-card__title price-card__title--display"><?= e($option['title']) ?></h3>
                <p class="card__figure"><?= e($option['amount']) ?></p>
                <p class="card__meta"><?= e($option['note']) ?></p>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<section class="section">
    <div class="container split">
        <section aria-labelledby="funding-title">
            <h2 class="section-title-sm" id="funding-title">Was wir fördern</h2>
            <ul class="row-list" role="list">
<?php foreach ($supportClub['funding'] as $item): ?>
                <li class="row-list__item"><?= e($item) ?></li>
<?php endforeach; ?>
            </ul>
        </section>
        <section class="card card--brand apply-box" aria-labelledby="apply-title">
            <h2 class="apply-box__title" id="apply-title">Zuschuss beantragen</h2>
            <p>Vor der Maßnahme per E-Mail. Ausgezahlt wird gegen eine Kopie der Rechnung.</p>
            <ol class="apply-box__steps">
<?php foreach ($supportClub['application_steps'] as $step): ?>
                <li><?= e($step) ?></li>
<?php endforeach; ?>
            </ol>
            <div><?= button('Antrag per E-Mail stellen', mailto($supportClub['application_email'], 'Antrag auf Zuschuss'), 'light') ?></div>
        </section>
    </div>
</section>
<section class="section section--surface" aria-labelledby="board-title">
    <div class="container">
        <h2 class="section-title-sm" id="board-title">Vorstand</h2>
        <ul class="grid grid--3" role="list">
<?php foreach ($supportClub['board'] as $member): ?>
            <li><?php partial('person-card', ['person' => person($member[0]), 'function' => $member[1], 'showEmail' => false]); ?></li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
