<?php
// Team page template for every team except the 1. Herren (Lastenheft 6.5),
// reached via /handball/mannschaften/<slug>/ (rewrite in .htaccess).
// Blocks without data are left out instead of showing empty areas.
require dirname(__DIR__) . '/includes/bootstrap.php';

$slug = isset($_GET['slug']) && is_string($_GET['slug']) ? $_GET['slug'] : '';
$team = team($slug);

if ($team === null) {
    render_not_found();
}

if ($team['slug'] === '1-herren') {
    header('Location: ' . url('1-herren/'), true, 301);
    exit;
}

$coaches = team_coaches($team);
$scheduleUrl = nuliga_url($team, 'schedule');
$tableUrl = nuliga_url($team, 'table');
$ageLabel = $team['age'] . ($team['birth_years'] !== null ? ' · ' . $team['birth_years'] : '');

$page = [
    'title' => $team['name'] . ': Training und Trainer | TSG Handball Hatten-Sandkrug',
    'description' => $team['name'] . ' der TSG Hatten-Sandkrug (' . $team['league'] . ', ' . $team['age'] . '): Trainingszeiten, Halle, Trainerteam und Probetraining.',
    'path' => 'mannschaften/' . $team['slug'] . '/',
    'nav' => 'teams',
    'breadcrumbs' => [['Mannschaften', 'mannschaften/'], [$team['name'], 'mannschaften/' . $team['slug'] . '/']],
    'schema' => [sports_team_schema($team)],
];

$actions = '';
if ($scheduleUrl !== null) {
    $actions .= button('Spielplan öffnen', $scheduleUrl, 'primary', ['external' => true]);
}
if ($tableUrl !== null) {
    $actions .= button('Tabelle ansehen', $tableUrl, 'secondary', ['external' => true]);
}

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => $team['name'],
    'before_title' => '<p><span class="tag">' . e($team['league']) . '</span></p>',
    'after_title' => '<p class="muted">' . e($ageLabel) . '</p>',
    'actions' => $actions !== '' ? $actions : null,
    'media' => media($team['photo'], 'landscape', 'Teamfoto ' . $team['name'], ['loading' => 'eager']),
]]);
?>
<section class="section">
    <div class="container split">
        <section aria-labelledby="training-title">
            <h2 class="section-title-sm" id="training-title">Training</h2>
            <?php partial('training-list', ['sessions' => $team['training']]); ?>
            <a class="button button--text mt-6" href="<?= href(trial_training_mailto($team['name'])) ?>">Probetraining bei der <?= e($team['name']) ?> anfragen</a>
        </section>
<?php if ($coaches !== []): ?>
        <section aria-labelledby="coaches-title">
            <h2 class="section-title-sm" id="coaches-title">Trainer</h2>
            <ul class="stack" role="list">
<?php foreach ($coaches as $coach): ?>
                <li><?php partial('person-card', ['person' => $coach['person'], 'function' => $coach['role']]); ?></li>
<?php endforeach; ?>
            </ul>
        </section>
<?php endif; ?>
    </div>
</section>
<?php if ($team['roster'] !== []): ?>
<section class="section section--surface" aria-labelledby="roster-title">
    <div class="container">
        <h2 class="section-title-sm" id="roster-title">Kader <?= e(SEASON_LABEL) ?></h2>
        <?php partial('roster', ['players' => $team['roster']]); ?>
    </div>
</section>
<?php endif; ?>
<section class="section" aria-labelledby="other-teams-title">
    <div class="container">
        <h2 class="section-title-sm" id="other-teams-title">Weitere Mannschaften</h2>
        <ul class="chip-list" role="list">
<?php foreach (teams() as $other): ?>
<?php if ($other['slug'] !== $team['slug']): ?>
            <li><a class="chip" href="<?= e(team_url($other)) ?>"><?= e($other['name']) ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
