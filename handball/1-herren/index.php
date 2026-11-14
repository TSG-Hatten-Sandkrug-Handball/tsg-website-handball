<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$team = team('1-herren');
$playerCount = count($team['roster']);

$page = [
    'title' => '1. Herren in der Oberliga Nord | TSG Handball Hatten-Sandkrug',
    'description' => 'Die 1. Herren der TSG Hatten-Sandkrug in der ' . $team['league'] . ': Kader ' . SEASON_LABEL . ', Trainer und Staff, Spielplan, Tabelle und Livestream der Heimspiele.',
    'path' => '1-herren/',
    'nav' => 'first-team',
    'breadcrumbs' => [['1. Herren', '1-herren/']],
    'schema' => [sports_team_schema($team)],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'variant' => 'dark',
    'title' => '1. Herren in der Oberliga Nord',
    'intro' => 'Saison ' . SEASON_LABEL . ' mit ' . $playerCount . ' Spielern, viele davon aus der eigenen Jugend. Heimspiele im Sportzentrum Sandkrug.',
    'actions' => button('Spielplan öffnen', nuliga_url($team, 'schedule'), 'light', ['external' => true])
        . button('Tabelle ansehen', nuliga_url($team, 'table'), 'outline-light', ['external' => true]),
    'after_actions' => '<a class="text-link" href="' . e(link_url('livestream')) . '" ' . external_attributes() . '>Heimspiele im Livestream<span class="visually-hidden"> (öffnet in neuem Tab)</span></a>',
    'media' => media($team['photo'], 'wide-dark', 'Mannschaftsfoto der 1. Herren', ['loading' => 'eager']),
]]);
?>
<section class="section" aria-labelledby="roster-title">
    <div class="container">
        <h2 class="section-title-sm" id="roster-title">Kader <?= e(SEASON_LABEL) ?></h2>
        <?php partial('roster', ['players' => $team['roster']]); ?>
    </div>
</section>
<section class="section section--surface" aria-labelledby="staff-title">
    <div class="container">
        <h2 class="section-title-sm" id="staff-title">Trainer und Staff</h2>
        <ul class="grid grid--5" role="list">
<?php foreach ($team['staff'] as $member): ?>
            <li><?php partial('person-card', ['person' => person($member[0]), 'function' => $member[1], 'showEmail' => false]); ?></li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
