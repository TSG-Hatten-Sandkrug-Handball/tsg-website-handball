<?php
require __DIR__ . '/includes/bootstrap.php';

$nextHomeFixture = next_home_fixture();
$schema = [organization_schema(), website_schema()];

if ($nextHomeFixture !== null) {
    $schema[] = home_match_schema($nextHomeFixture);
}

$page = [
    'title' => 'TSG Handball Hatten-Sandkrug: Heimspiele, Teams, Jugend',
    'description' => 'Handball bei der TSG Hatten-Sandkrug: nächstes Heimspiel der 1. Herren in der Oberliga, 15 Mannschaften, Trainingszeiten und Probetraining ab 5 Jahren.',
    'path' => '',
    'nav' => null,
    'schema' => $schema,
    'extended_footer' => true,
];

require INCLUDES_DIR . '/layout/start.php';
?>
<h1 class="visually-hidden">Handball bei der TSG Hatten-Sandkrug</h1>
<?php
partial('home/match-stage', ['fixture' => $nextHomeFixture]);
partial('home/news', ['items' => array_slice(news_items(), 0, 5)]);
partial('home/schedule', ['fixtures' => upcoming_fixtures(4), 'result' => last_result()]);
partial('home/youth');
partial('cta-band', [
    'kicker' => 'Mitmachen',
    'title' => 'Trainer, Helfer, Schiedsrichter gesucht',
    'text' => 'Ob an der Seitenlinie, am Kampfgericht oder mit der Pfeife: Wir finden für jeden eine Aufgabe.',
    'action' => button('Aufgaben ansehen', url('mitmachen/'), 'light'),
]);
partial('home/partners');

require INCLUDES_DIR . '/layout/end.php';
