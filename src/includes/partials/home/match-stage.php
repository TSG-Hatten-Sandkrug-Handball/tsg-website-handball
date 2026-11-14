<?php
/**
 * Match-day stage with countdown (Lastenheft UE-01 / UE-02). Every upcoming
 * home fixture is rendered; upcoming.js shows the next one after kick-off of
 * the previous, so the static page stays correct without a rebuild.
 *
 * @var array $fixtures upcoming home fixtures of the 1. Herren
 */
$firstTeam = team('1-herren');
$matches = data('matches');
?>
<section class="match-stage" aria-label="Nächstes Heimspiel">
    <div class="container match-stage__inner">
        <div class="match-stage__content" data-upcoming data-limit="1">
<?php foreach ($fixtures as $index => $fixture):
    $kickoff = $fixture['kickoff'];
    $remaining = max(0, $kickoff->getTimestamp() - time());
?>
            <div class="match-stage__fixture" data-start="<?= e($kickoff->format(DATE_ATOM)) ?>"<?= $index > 0 ? ' hidden' : '' ?>>
                <p class="kicker">Nächstes Heimspiel · <?= e($firstTeam['league']) ?></p>
                <h2 class="match-stage__title">
                    <span class="match-stage__team">
                        <img class="match-stage__crest" src="<?= e(asset('img/tsg-crest.webp')) ?>" alt="" width="134" height="133">
                        <span><?= e($matches['own_name']) ?></span>
                    </span>
                    <span class="match-stage__versus"><span aria-hidden="true">vs</span><span class="visually-hidden">gegen</span></span>
                    <span class="match-stage__team match-stage__team--guest">
                        <?= media(null, 'team-crest', 'Wappen von ' . $fixture['opponent'], ['class' => 'match-stage__crest', 'loading' => 'eager', 'decorative' => true]) ?>
                        <span><?= breakable($fixture['opponent']) ?></span>
                    </span>
                </h2>
                <p class="match-stage__meta">
                    <time datetime="<?= e($kickoff->format(DATE_ATOM)) ?>"><?= e(date_with_weekday($kickoff)) ?> · <?= e(time_label($kickoff)) ?></time><br>
                    <?= e($fixture['venue']) ?>
                </p>
                <div class="countdown" data-countdown data-target="<?= e($kickoff->format(DATE_ATOM)) ?>">
                    <p class="visually-hidden">Anwurf am <?= e(date_with_weekday($kickoff)) ?> um <?= e(time_label($kickoff)) ?>.</p>
                    <div class="countdown__grid" aria-hidden="true">
                        <div class="countdown__unit"><span class="countdown__value" data-unit="days"><?= intdiv($remaining, 86400) ?></span><span class="countdown__label">Tage</span></div>
                        <div class="countdown__unit"><span class="countdown__value" data-unit="hours"><?= sprintf('%02d', intdiv($remaining % 86400, 3600)) ?></span><span class="countdown__label">Std</span></div>
                        <div class="countdown__unit"><span class="countdown__value" data-unit="minutes"><?= sprintf('%02d', intdiv($remaining % 3600, 60)) ?></span><span class="countdown__label">Min</span></div>
                        <div class="countdown__unit"><span class="countdown__value" data-unit="seconds"><?= sprintf('%02d', $remaining % 60) ?></span><span class="countdown__label">Sek</span></div>
                    </div>
                </div>
                <div class="button-row">
                    <?= button('Tickets und Anfahrt', url('heimspiele/'), 'light') ?>
                    <?= button('Livestream', link_url('livestream'), 'outline-light', ['external' => true]) ?>
                    <?= button('Spielplan', nuliga_url($firstTeam, 'schedule'), 'outline-light', ['external' => true]) ?>
                </div>
            </div>
<?php endforeach; ?>
            <div class="match-stage__fixture" data-upcoming-empty<?= $fixtures !== [] ? ' hidden' : '' ?>>
                <p class="kicker">Nächstes Heimspiel · <?= e($firstTeam['league']) ?></p>
                <h2 class="match-stage__title">Das nächste Heimspiel folgt</h2>
                <p class="match-stage__meta">Sobald der Spielplan steht, findest du hier Termin und Gegner.</p>
                <div class="button-row">
                    <?= button('Spielplan', nuliga_url($firstTeam, 'schedule'), 'light', ['external' => true]) ?>
                </div>
            </div>
        </div>
        <?= media($matches['stage_photo'], 'wide-dark', 'Die 1. Herren in Aktion', ['class' => 'match-stage__media', 'loading' => 'eager']) ?>
    </div>
</section>
