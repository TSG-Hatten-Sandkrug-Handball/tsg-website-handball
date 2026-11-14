<?php
/** @var array $fixture */
$own = data('matches')['own_name'];
?>
<article class="fixture">
    <p class="fixture__date">
        <time datetime="<?= e($fixture['kickoff']->format(DATE_ATOM)) ?>">
            <span class="fixture__day"><?= e(date_day_month($fixture['kickoff'])) ?></span>
            <span class="fixture__time"><?= e(time_label($fixture['kickoff'])) ?></span>
        </time>
    </p>
    <p class="fixture__teams">
        <span class="<?= $fixture['home_team'] === $own ? 'fixture__own' : '' ?>"><?= breakable($fixture['home_team']) ?></span>
        <span class="visually-hidden"> gegen </span>
        <span class="<?= $fixture['away_team'] === $own ? 'fixture__own' : '' ?>"><?= breakable($fixture['away_team']) ?></span>
    </p>
    <span class="tag tag--uppercase<?= $fixture['home'] ? '' : ' tag--away' ?>"><?= $fixture['home'] ? 'Heim' : 'Auswärts' ?></span>
</article>
