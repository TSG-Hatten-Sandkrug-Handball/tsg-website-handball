<?php
/**
 * Next four matches, last result and league table of the 1. Herren (Lastenheft UE-04).
 *
 * @var array      $fixtures
 * @var array|null $result
 */
$matches = data('matches');
$updated = local_date($matches['updated']);
?>
<section class="section section--surface" aria-labelledby="home-schedule-title">
    <div class="container">
        <div class="section-head">
            <div class="section-head__text">
                <p class="kicker">1. Herren · Saison <?= e(SEASON_LABEL) ?></p>
                <h2 id="home-schedule-title">Spielplan und Tabelle</h2>
            </div>
            <p class="card__meta">Stand <?= e(date_short($updated)) ?> · Quelle: <?= e($matches['source']) ?></p>
        </div>
        <div class="split split--wide-start">
            <div>
                <h3 class="label-heading">Kommende Spiele</h3>
<?php if ($fixtures === []): ?>
                <p class="card card--dashed">Die nächsten Spiele stehen noch nicht fest.</p>
<?php else: ?>
                <ol class="fixture-list" role="list">
<?php foreach ($fixtures as $fixture): ?>
                    <li><?php partial('fixture', ['fixture' => $fixture]); ?></li>
<?php endforeach; ?>
                </ol>
<?php endif; ?>
<?php if ($result !== null): ?>
                <p class="last-result">
                    <span>Letztes Spiel, <?= e(date_day_month($result['date'])) ?>:
                        <?= e($result['home'] ? $matches['own_short_name'] . ' – ' . $result['opponent_short'] : $result['opponent_short'] . ' – ' . $matches['own_short_name']) ?></span>
                    <span class="last-result__score">
                        <?= e($result['home'] ? $result['goals_for'] . ':' . $result['goals_against'] : $result['goals_against'] . ':' . $result['goals_for']) ?>
<?php if ($result['outcome'] !== 0): ?>
                        <span class="tag <?= $result['outcome'] > 0 ? 'tag--win' : 'tag--loss' ?>"><?= $result['outcome'] > 0 ? 'Sieg' : 'Niederlage' ?></span>
<?php endif; ?>
                    </span>
                </p>
<?php endif; ?>
            </div>
            <?php partial('league-table', ['rows' => $matches['table'], 'own' => $matches['own_name']]); ?>
        </div>
    </div>
</section>
