<?php
$kidsCup = data('kids-cup');
$documents = data('documents')['kids_cup'];
$registrationForm = current(array_filter($documents, function (array $document): bool {
    return !empty($document['registration_form']);
}));
$contact = person($kidsCup['contact']);
$feeTotal = array_sum(array_column($kidsCup['fees'], 'amount'));
$pending = 'wird noch bekanntgegeben';
$date = $kidsCup['date'] !== null ? date_long(local_date($kidsCup['date'])) : $pending;
$deadline = $kidsCup['registration_deadline'] !== null ? date_long(local_date($kidsCup['registration_deadline'])) : $pending;

$schema = [];
if ($kidsCup['date'] !== null) {
    $schema[] = [
        '@type' => 'SportsEvent',
        'name' => 'Kids-Cup ' . $kidsCup['next_year'],
        'sport' => 'Handball',
        'startDate' => local_date($kidsCup['date'])->format('Y-m-d'),
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'location' => ['@type' => 'Place', 'name' => 'Sportplatz an der Schultredde', 'address' => 'Schultredde, 26209 Hatten'],
        'organizer' => ['@id' => absolute_url('#organization')],
    ];
}

$page = [
    'title' => 'Kids-Cup: Jugendturnier an der Schultredde | TSG Handball',
    'description' => 'Der Kids-Cup der TSG Hatten-Sandkrug: Handball-Jugendturnier seit 1975 für Minis bis B-Jugend. Ablauf, Gebühren je Mannschaft, Anmeldung und Unterlagen.',
    'path' => 'kids-cup/',
    'nav' => 'kids-cup',
    'breadcrumbs' => [['Kids-Cup', 'kids-cup/']],
    'schema' => $schema,
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'variant' => 'brand',
    'title' => 'Der Kids-Cup an der Schultredde',
    'intro' => 'Unser Jugendturnier seit 1975: ein Wochenende im Juni auf dem Rasen, mit Minis, E- bis B-Jugend aus der ganzen Region. 2026 lief die 47. Ausgabe.',
    'note' => 'Termin ' . $kidsCup['next_year'] . ': ' . $date . ' · Anmeldeschluss: ' . $deadline,
    'actions' => button('Anmeldebogen laden', $registrationForm['url'], 'light')
        . button($contact['name'] . ' schreiben', mailto($contact['email'], 'Kids-Cup ' . $kidsCup['next_year']), 'outline-light'),
    'media' => media(null, 'wide-dark', 'Turnierbild vom Kids-Cup', ['loading' => 'eager']),
]]);
?>
<section class="section">
    <div class="container split">
        <section class="stack" aria-labelledby="schedule-title">
            <h2 class="section-title-sm" id="schedule-title">So läuft das Wochenende</h2>
            <ul class="row-list" role="list">
<?php foreach ($kidsCup['schedule'] as $slot): ?>
                <li class="row-list__item">
                    <span class="row-list__label"><?= e($slot['group']) ?></span>
                    <span class="row-list__value"><?= e($slot['time']) ?></span>
                </li>
<?php endforeach; ?>
            </ul>
            <p class="muted">Jedes Kind bekommt am Samstag eine Medaille, dazu gibt es Pokale und Sachpreise. Getränke und Essen gibt es auf dem Gelände.</p>
        </section>
        <section class="fee-box" aria-labelledby="fees-title">
            <h2 class="fee-box__title" id="fees-title">Gebühren je Mannschaft</h2>
            <ul class="row-list row-list--total" role="list">
<?php foreach ($kidsCup['fees'] as $fee): ?>
                <li class="row-list__item">
                    <span class="row-list__label"><?= e($fee['label']) ?></span>
                    <span class="fee-box__amount"><?= e(format_euro($fee['amount'])) ?></span>
                </li>
<?php endforeach; ?>
                <li class="row-list__item">
                    <span class="row-list__label">Summe</span>
                    <span class="fee-box__amount"><?= e(format_euro($feeTotal)) ?></span>
                </li>
            </ul>
            <p class="card__meta">Beide Kautionen kommen am Montag nach dem Turnier zurück. Minis zahlen 20 € plus 20 € Schiedsrichterkaution. Die Anmeldung gilt, sobald die Gebühr bezahlt ist.</p>
        </section>
    </div>
</section>
<section class="section section--surface" aria-labelledby="documents-title">
    <div class="container">
        <h2 class="section-title-sm" id="documents-title">Unterlagen</h2>
        <ul class="grid grid--4" role="list">
<?php foreach ($documents as $document): ?>
            <li class="card card--interactive">
                <h3 class="card__title"><a class="card__link" href="<?= e($document['url']) ?>"><?= e($document['label']) ?></a></h3>
                <p class="card__meta"><?= e($document['format']) ?>, <?= e(format_file_size($document['size'])) ?></p>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
