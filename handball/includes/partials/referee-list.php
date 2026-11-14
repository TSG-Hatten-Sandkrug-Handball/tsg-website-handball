<?php
/**
 * @var array    $team    referee entries from data/referees.php
 * @var string|null $columns grid modifier, default 4
 */
$columns = $columns ?? '4';
?>
<ul class="grid grid--<?= e($columns) ?>" role="list">
<?php foreach ($team as $referee):
    $person = person($referee['person']);
?>
    <li class="card">
        <h3 class="person-card__name"><?= e($person['name']) ?></h3>
        <p class="card__meta"><?= e($referee['level']) ?></p>
    </li>
<?php endforeach; ?>
</ul>
