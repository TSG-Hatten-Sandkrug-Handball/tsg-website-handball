<?php
// Built from the team data, so coaches are maintained in one place only (UL-01).
$coaches = coaches_overview();
$coachCount = count($coaches);
$teamCount = count(teams());

$page = [
    'title' => 'Übungsleiterinnen und Übungsleiter | TSG Handball Hatten-Sandkrug',
    'description' => $coachCount . ' Ehrenamtliche trainieren ' . $teamCount . ' Handballmannschaften der TSG Hatten-Sandkrug. Alle Trainerinnen und Trainer mit ihren Teams und Kontakt.',
    'path' => 'uebungsleiter/',
    'nav' => 'department',
    'breadcrumbs' => [['Abteilung', 'abteilung/'], ['Übungsleiter', 'uebungsleiter/']],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => 'Unsere Übungsleiterinnen und Übungsleiter',
    'intro' => $coachCount . ' Ehrenamtliche trainieren ' . $teamCount . ' Mannschaften. Für Fragen zum Training schreibst du am besten direkt das Trainerteam an.',
    'aside' => button('Selbst Trainer werden', url('mitmachen/'), 'secondary'),
]]);
?>
<section class="section" aria-label="Alle Übungsleiterinnen und Übungsleiter">
    <div class="container">
        <ul class="grid grid--4" role="list">
<?php foreach ($coaches as $entry):
    $person = $entry['person'];
?>
            <li class="card coach-card">
                <h2 class="person-card__name"><?= e($person['name']) ?></h2>
                <ul class="coach-card__teams" role="list">
<?php foreach ($entry['assignments'] as $assignment): ?>
                    <li><a class="coach-card__team" href="<?= e($assignment['url']) ?>"><?= e($assignment['label']) ?></a> · <?= e($assignment['role']) ?></li>
<?php endforeach; ?>
                </ul>
<?php if ($person['email'] !== null): ?>
                <p class="person-card__email"><?= email_link($person['email']) ?></p>
<?php endif; ?>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<?php
partial('cta-band', [
    'variant' => 'brand-dark',
    'title' => 'Trainerinnen und Trainer gesucht',
    'text' => 'Von den Minis bis zur A-Jugend suchen wir Leute, die eine Gruppe übernehmen oder unterstützen.',
    'action' => button('Offene Aufgaben ansehen', url('mitmachen/'), 'light'),
]);

require INCLUDES_DIR . '/layout/end.php';
