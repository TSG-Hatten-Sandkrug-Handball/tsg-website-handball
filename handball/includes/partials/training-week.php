<?php
/**
 * Monday to Friday grid of all sessions (Lastenheft MA-04). Days stack on phones.
 *
 * @var array $week day number => sessions
 */
?>
<div class="training-week">
<?php foreach ($week as $day => $sessions): ?>
    <section class="training-week__day" aria-labelledby="training-day-<?= $day ?>">
        <h3 class="training-week__heading" id="training-day-<?= $day ?>"><?= e(TRAINING_DAYS[$day]) ?></h3>
<?php if ($sessions === []): ?>
        <p class="card__meta">Kein Training</p>
<?php else: ?>
        <ul class="training-week__list" role="list">
<?php foreach ($sessions as $session):
    $accent = $session['team']['accent'] !== null ? ' training-session--' . $session['team']['accent'] : '';
?>
            <li class="training-session<?= e($accent) ?>">
                <span class="training-session__time"><?= e($session['start']) ?>–<?= e($session['end']) ?></span>
                <a class="training-session__team" href="<?= e(team_url($session['team'])) ?>"><?= e($session['team']['name']) ?></a>
                <span class="training-session__hall"><?= e($session['hall']['short']) ?></span>
            </li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
    </section>
<?php endforeach; ?>
</div>
