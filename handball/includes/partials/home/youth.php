<?php
// Youth teaser with team tiles (Lastenheft UE-05).
$youthCount = count(youth_teams());
$tiles = [
    ['team' => team('maennliche-b-jugend')],
    ['team' => team('maennliche-c-jugend')],
    ['team' => team('maennliche-a-jugend')],
    ['team' => team('weibliche-b-jugend')],
    ['team' => team('weibliche-d-jugend-1')],
    ['team' => team('minis-sandkrug'), 'title' => 'Minis', 'meta' => 'Sandkrug und Kirchhatten', 'url' => url('mannschaften/?gruppe=minis#mannschaften')],
];
?>
<section class="section" aria-labelledby="home-youth-title">
    <div class="container split split--center">
        <div class="stack">
            <p class="kicker">Unser Nachwuchs</p>
            <h2 id="home-youth-title"><?= $youthCount ?> Jugendteams, ab 5 Jahren</h2>
            <p class="muted">Von den Minis bis zur A-Jugend: männlich und weiblich, vom Turnier bis zur Oberliga. Unsere D-Mädchen haben sich 2026 vorzeitig die Meisterschaft gesichert.</p>
            <div class="button-row">
                <?= button('Team und Trainingszeit finden', url('mannschaften/'), 'primary') ?>
                <?= button('Zum Kids-Cup', url('kids-cup/'), 'secondary') ?>
            </div>
        </div>
        <ul class="tile-grid" role="list">
<?php foreach ($tiles as $tile):
    $team = $tile['team'];
?>
            <li class="tile card--interactive">
                <a class="tile__title card__link" href="<?= e($tile['url'] ?? team_url($team)) ?>"><?= e($tile['title'] ?? $team['short_name']) ?></a>
                <span class="tile__meta"><?= e($tile['meta'] ?? $team['league']) ?></span>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
