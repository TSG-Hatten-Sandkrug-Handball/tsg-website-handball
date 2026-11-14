<?php
/**
 * Team card on /mannschaften (Lastenheft MA-03).
 *
 * @var array $team
 */
$isFirstTeam = $team['slug'] === '1-herren';
$accent = $team['accent'] !== null ? ' team-card--' . $team['accent'] : '';
?>
<article class="team-card card--interactive<?= e($accent) ?>">
    <h2 class="team-card__title"><?= e($team['name']) ?></h2>
    <p class="card__meta"><?= e($team['age']) ?><?= $team['birth_years'] !== null ? ' · ' . e($team['birth_years']) : '' ?></p>
    <p><span class="tag"><?= e($team['league']) ?></span></p>
    <table class="team-card__training">
        <caption class="visually-hidden">Trainingszeiten</caption>
        <tbody>
<?php foreach ($team['training'] as $session): ?>
            <tr>
                <th scope="row"><abbr title="<?= e(TRAINING_DAYS[$session[0]]) ?>"><?= e(TRAINING_DAYS_SHORT[$session[0]]) ?></abbr></th>
                <td><?= e($session[1]) ?>–<?= e($session[2]) ?></td>
                <td class="team-card__hall"><?= e(hall($session[3])['short']) ?></td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    <p class="team-card__coaches">Training: <?= e(coach_names($team)) ?></p>
    <a class="team-card__link card__link" href="<?= e(team_url($team)) ?>"><?= $isFirstTeam ? 'Zur Seite der 1. Herren' : 'Zur Teamseite' ?><span class="visually-hidden">: <?= e($team['name']) ?></span></a>
</article>
