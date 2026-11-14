<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$referees = data('referees');
$roles = [
    ['title' => 'Trainerin oder Trainer', 'text' => 'Von den Minis bis zur A-Jugend suchen wir Leute, die eine Gruppe übernehmen oder unterstützen.'],
    ['title' => 'Kampfgericht und Helfer', 'text' => 'Zeitnahme, Anschreiben, Hallenaufbau und Kasse bei Heimspielen.'],
    ['title' => 'Turniere und Projekte', 'text' => 'Kids-Cup, Minispielfest und alles, was die Abteilung besser macht.'],
    ['title' => 'Spielerinnen gesucht', 'text' => 'Die Damen, die weibliche B- und C-Jugend freuen sich über Verstärkung.'],
];

$page = [
    'title' => 'Mitmachen: Trainer, Helfer, Schiedsrichter | TSG Handball',
    'description' => 'Engagier dich in der Handballabteilung der TSG Hatten-Sandkrug: als Trainerin oder Trainer, am Kampfgericht, bei Turnieren oder als Spielerin.',
    'path' => 'mitmachen/',
    'nav' => 'department',
    'breadcrumbs' => [['Mitmachen', 'mitmachen/']],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => 'Mitmachen an der Seitenlinie',
    'intro' => 'Ob am Kampfgericht, an der Pfeife, als Trainerin oder beim Turnier: Wir finden für jeden eine Aufgabe.',
    'actions' => button('Nachricht an die Abteilung', mailto(DEPARTMENT_EMAIL, 'Mitmachen'), 'primary')
        . button('Offene Aufgaben ansehen', '#aufgaben', 'secondary'),
]]);
?>
<section class="section" id="aufgaben" aria-labelledby="roles-title">
    <div class="container">
        <h2 class="visually-hidden" id="roles-title">Offene Aufgaben</h2>
        <ul class="grid grid--4" role="list">
<?php foreach ($roles as $role): ?>
            <li class="card role-card">
                <h3 class="card__title card__title--display"><?= e($role['title']) ?></h3>
                <p class="card__meta"><?= e($role['text']) ?></p>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<section class="section section--surface" aria-labelledby="referees-title">
    <div class="container split">
        <div class="stack">
            <h2 id="referees-title">Unsere Schiedsrichter</h2>
            <p class="muted">Schiedsrichterwart ist <?= e(person($referees['leads'][0]['person'])['name']) ?>, für die Jugend ist <?= e(person($referees['leads'][1]['person'])['name']) ?> Schiedsrichterobmann. Wer pfeifen lernen möchte, meldet sich bei ihnen.</p>
            <div><?= button('Zur Schiedsrichter-Seite', url('schiedsrichter/'), 'primary') ?></div>
        </div>
        <?php partial('referee-list', ['team' => $referees['team'], 'columns' => '2']); ?>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
