<?php
$referees = data('referees');
$refereeWarden = person($referees['leads'][0]['person']);

$page = [
    'title' => 'Schiedsrichter der Handballabteilung | TSG Hatten-Sandkrug',
    'description' => 'Das Schiedsrichterteam der TSG Hatten-Sandkrug vom Jugendspiel bis zur Verbandsebene. Ansprechpartner und wie du selbst Schiedsrichter wirst.',
    'path' => 'schiedsrichter/',
    'nav' => 'department',
    'breadcrumbs' => [['Abteilung', 'abteilung/'], ['Schiedsrichter', 'schiedsrichter/']],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => 'Unsere Schiedsrichter',
    'intro' => 'Ohne Schiedsrichter kein Spielbetrieb. Diese Leute pfeifen für die TSG, vom Jugendspiel bis zur Verbandsebene.',
]]);
?>
<section class="section">
    <div class="container stack stack--lg">
        <section aria-labelledby="referee-leads-title">
            <h2 class="visually-hidden" id="referee-leads-title">Ansprechpartner</h2>
            <ul class="grid grid--2" role="list">
<?php foreach ($referees['leads'] as $lead): ?>
                <li><?php partial('person-card', ['person' => person($lead['person']), 'function' => $lead['function'], 'variant' => 'brand']); ?></li>
<?php endforeach; ?>
            </ul>
        </section>
        <section aria-labelledby="referee-team-title">
            <h2 class="section-title-sm" id="referee-team-title">Das Schiedsrichterteam</h2>
            <?php partial('referee-list', ['team' => $referees['team']]); ?>
        </section>
    </div>
</section>
<?php
partial('cta-band', [
    'variant' => 'brand-dark',
    'title' => 'Schiedsrichter werden',
    'text' => 'Schon Jugendliche können den Schein machen. Der Verein begleitet dich von der Ausbildung bis zum ersten Spiel.',
    'action' => button($refereeWarden['name'] . ' schreiben', mailto($refereeWarden['email'], 'Schiedsrichter werden'), 'light'),
]);

require INCLUDES_DIR . '/layout/end.php';
