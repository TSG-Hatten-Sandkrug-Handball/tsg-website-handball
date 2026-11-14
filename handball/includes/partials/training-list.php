<?php
/**
 * Training sessions of one team (Lastenheft TS-02). On phones the hall
 * moves to its own line.
 *
 * @var array $sessions [day, start, end, hall key]
 */
?>
<ul class="training-list" role="list">
<?php foreach ($sessions as $session): ?>
    <li class="training-list__item">
        <span class="training-list__day"><?= e(TRAINING_DAYS[$session[0]]) ?></span>
        <span class="training-list__time"><?= e($session[1]) ?>–<?= e($session[2]) ?> Uhr</span>
        <span class="training-list__hall"><?= e(hall($session[3])['long']) ?></span>
    </li>
<?php endforeach; ?>
</ul>
