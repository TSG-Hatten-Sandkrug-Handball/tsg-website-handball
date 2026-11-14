<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$tickets = data('tickets');
$firstTeam = team('1-herren');
$nextHomeFixture = next_home_fixture();

$page = [
    'title' => 'Heimspiele, Tickets und Dauerkarte | TSG Handball Hatten-Sandkrug',
    'description' => 'Heimspiele der 1. Herren im Sportzentrum Sandkrug: Tageskarte ' . $tickets['day'] . ' €, Dauerkarte ' . $tickets['season'] . ' €, Kinder bis ' . $tickets['free_until_age'] . ' Jahre frei. Dazu Hallenheft, Livestream und Anfahrt.',
    'path' => 'heimspiele/',
    'nav' => 'home-games',
    'breadcrumbs' => [['Heimspiele', 'heimspiele/']],
    'schema' => $nextHomeFixture !== null ? [home_match_schema($nextHomeFixture)] : [],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'variant' => 'plain xl',
    'title' => 'Sportzentrum Sandkrug, Schultredde.',
    'intro' => 'Bis zu 400 Plätze, im Schnitt kommen 250 Zuschauer. Karten gibt es an der Abendkasse, Dauerkarten per E-Mail.',
    'actions' => button('Nächste Heimspiele', nuliga_url($firstTeam, 'schedule'), 'primary', ['external' => true])
        . button('Zum Livestream', link_url('livestream'), 'secondary', ['external' => true]),
]]);
?>
<section class="section section--surface" aria-labelledby="tickets-title">
    <div class="container">
        <h2 class="section-title-sm" id="tickets-title">Tickets und Dauerkarten</h2>
        <ul class="grid grid--3" role="list">
            <li class="card price-card">
                <h3 class="price-card__title">Tageskarte</h3>
                <p class="card__figure"><?= e(format_euro($tickets['day'])) ?></p>
                <p class="card__meta">Ermäßigt <?= e(format_euro($tickets['day_reduced'])) ?> für Schüler und Studenten über 18 und mit Behindertenausweis. Nur an der Abendkasse.</p>
            </li>
            <li class="card price-card">
                <h3 class="price-card__title">Dauerkarte</h3>
                <p class="card__figure"><?= e(format_euro($tickets['season'])) ?></p>
                <p class="card__meta">Ermäßigt <?= e(format_euro($tickets['season_reduced'])) ?>. Gilt für alle Heimspiele der Saison und spart bis zu 22 Prozent.</p>
            </li>
            <li class="card price-card">
                <h3 class="price-card__title">Kinder</h3>
                <p class="card__figure">frei</p>
                <p class="card__meta">Bis einschließlich <?= e((string) $tickets['free_until_age']) ?> Jahre ist der Eintritt frei.</p>
            </li>
        </ul>
        <div class="button-row mt-6">
            <?= button('Dauerkarte bestellen', mailto(TICKET_EMAIL, 'Dauerkarte'), 'primary') ?>
        </div>
    </div>
</section>
<section class="section" aria-labelledby="programme-title">
    <div class="container split">
        <div class="stack">
            <h2 id="programme-title">Das Hallenheft</h2>
            <p class="muted">Zu jedem Heimspiel der 1. Herren erscheint ein Hallenheft mit Spielberichten und Neuem aus der Abteilung. Ältere Ausgaben gibt es bei der Abteilungsleitung.</p>
        </div>
        <div class="stack stack--lg">
<?php foreach (data('documents')['programmes'] as $season): ?>
            <section aria-label="<?= e($season['season']) ?>">
                <h3 class="list-heading list-heading--small"><?= e($season['season']) ?></h3>
                <ul class="row-list" role="list">
<?php foreach ($season['items'] as $issue):
    $date = local_date($issue['date']);
?>
                    <li class="row-list__item">
                        <a class="row-list__link" href="<?= e($issue['url']) ?>">
                            <span class="row-list__label">Hallenheft gegen <?= e($issue['opponent']) ?></span>
                            <span class="row-list__meta"><?= e(date_short($date)) ?> · PDF, <?= e(format_file_size($issue['size'])) ?></span>
                        </a>
                    </li>
<?php endforeach; ?>
                </ul>
            </section>
<?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section section--surface" aria-labelledby="directions-title">
    <div class="container split split--center">
        <div class="stack">
            <h2 id="directions-title">Anfahrt</h2>
            <address class="address">
                Sportzentrum Sandkrug<br>
                Schultredde<br>
                26209 Hatten
            </address>
            <p class="muted">Die Karte öffnet sich bei OpenStreetMap. Es werden keine Kartendaten in diese Seite geladen.</p>
        </div>
        <div>
            <?= button('Route in der Karte öffnen', link_url('map'), 'primary', ['external' => true]) ?>
        </div>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
