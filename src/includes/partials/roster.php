<?php
/**
 * Squad grid with shirt number, name and position, no birth dates (TS-04 / HE-02).
 *
 * @var array $players [number, name, position]
 */
?>
<ul class="roster" role="list">
<?php foreach ($players as $player): ?>
    <li class="roster__player">
        <span class="roster__number"><span class="visually-hidden">Nummer </span><?= e((string) $player[0]) ?></span>
        <span class="roster__name"><?= e($player[1]) ?></span>
        <span class="roster__position"><?= e($player[2]) ?></span>
    </li>
<?php endforeach; ?>
</ul>
