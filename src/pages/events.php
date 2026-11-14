<?php
$events = upcoming_events();
$kidsCup = data('kids-cup');
$kidsCupDate = $kidsCup['date'] !== null ? date_long(local_date($kidsCup['date'])) : 'Termin wird noch bekanntgegeben';

$page = [
    'title' => 'Termine der Handballabteilung | TSG Hatten-Sandkrug',
    'description' => 'Turniere, Feste und Versammlungen der Handballabteilung der TSG Hatten-Sandkrug. Dazu die festen Termine im Jahr: Heimspiele und Kids-Cup.',
    'path' => 'termine/',
    'nav' => 'news',
    'breadcrumbs' => [['Neuigkeiten', 'neuigkeiten/'], ['Termine', 'termine/']],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => 'Termine der Abteilung',
    'intro' => 'Turniere, Feste und Versammlungen. Die Spieltermine stehen in den Spielplänen der Mannschaften.',
]]);
?>
<section class="section" aria-labelledby="events-title">
    <div class="container">
        <h2 class="section-title-sm" id="events-title">Kommende Termine</h2>
        <div data-upcoming>
        <div class="card card--dashed" data-upcoming-empty<?= $events !== [] ? ' hidden' : '' ?>>
            <p class="card__title">Gerade sind keine Termine eingetragen.</p>
            <p class="card__meta">Neue Termine erscheinen hier, sobald die Abteilung sie veröffentlicht.</p>
        </div>
<?php if ($events !== []): ?>
        <ul class="event-list" role="list">
<?php foreach ($events as $event): ?>
            <li class="event" data-start="<?= e($event['date']->format(DATE_ATOM)) ?>" data-end="<?= e($event['date']->setTime(23, 59, 59)->format(DATE_ATOM)) ?>">
                <time class="event__date" datetime="<?= e($event['date']->format('Y-m-d')) ?>">
                    <span class="event__day"><?= e($event['date']->format('d')) ?></span>
                    <span class="event__month"><?= e(month_short($event['date'])) ?></span>
                </time>
                <div>
                    <h3 class="card__title"><?= e($event['title']) ?></h3>
                    <p class="card__meta"><?= e(isset($event['time']) ? $event['time'] . ' Uhr · ' : '') ?><?= e($event['location']) ?></p>
                </div>
            </li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
        </div>
    </div>
</section>
<section class="section section--surface" aria-labelledby="fixed-events-title">
    <div class="container">
        <h2 class="section-title-sm" id="fixed-events-title">Feste Termine im Jahr</h2>
        <ul class="grid grid--3" role="list">
            <li class="card card--interactive">
                <h3 class="card__title"><a class="card__link" href="<?= e(url('heimspiele/')) ?>">Heimspiele</a></h3>
                <p class="card__meta">September bis Mai im Sportzentrum Sandkrug</p>
            </li>
            <li class="card card--interactive">
                <h3 class="card__title"><a class="card__link" href="<?= e(url('kids-cup/')) ?>">Kids-Cup</a></h3>
                <p class="card__meta">Ein Wochenende im Juni, <?= e((string) $kidsCup['next_year']) ?>: <?= e($kidsCupDate) ?></p>
            </li>
            <li class="card card--interactive">
                <h3 class="card__title"><a class="card__link" href="<?= e(url('mannschaften/')) ?>">Spielpläne der Teams</a></h3>
                <p class="card__meta">Auf jeder Teamseite verlinkt</p>
            </li>
        </ul>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
