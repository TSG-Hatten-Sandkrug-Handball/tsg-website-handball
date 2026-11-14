<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$groupSlug = isset($_GET['gruppe']) && is_string($_GET['gruppe']) ? $_GET['gruppe'] : null;
$groupKey = team_group_key_from_slug($groupSlug);
$groups = data('team-groups');
$teams = teams_in_group($groupKey);
$teamCount = count(teams());

$page = [
    'title' => 'Mannschaften und Trainingszeiten | TSG Handball Hatten-Sandkrug',
    'description' => $teamCount . ' Handballteams von den Minis ab 5 Jahren bis zu den Herren: Trainingszeiten, Hallen, Ligen und Trainerteams der TSG Hatten-Sandkrug.',
    'path' => 'mannschaften/',
    'nav' => 'teams',
    'breadcrumbs' => [['Mannschaften', 'mannschaften/']],
];

require INCLUDES_DIR . '/layout/start.php';
?>
<header class="page-hero">
    <div class="container page-hero__inner">
        <div class="page-hero__content">
            <?php partial('breadcrumb', ['breadcrumbs' => $page['breadcrumbs']]); ?>
            <h1><?= $teamCount ?> Mannschaften, ein Verein</h1>
            <p class="page-hero__intro">Wähle eine Gruppe und sieh, wer trainiert, wann und wo. Ein Probetraining ist jederzeit möglich: einfach beim Trainerteam oder unter <?= email_link(DEPARTMENT_EMAIL, null, 'link', 'Probetraining') ?> melden.</p>
        </div>
    </div>
</header>
<section class="section" id="mannschaften" aria-label="Alle Mannschaften">
    <div class="container">
        <form class="filter" action="<?= e(url('mannschaften/')) ?>#mannschaften" method="get" aria-label="Mannschaften nach Gruppe filtern">
            <button class="filter__option" type="submit" aria-pressed="<?= $groupKey === null ? 'true' : 'false' ?>">Alle</button>
<?php foreach ($groups as $key => $group): ?>
            <button class="filter__option" type="submit" name="gruppe" value="<?= e($group['slug']) ?>" aria-pressed="<?= $groupKey === $key ? 'true' : 'false' ?>"><?= e($group['label']) ?></button>
<?php endforeach; ?>
        </form>
        <ul class="grid grid--4" role="list">
<?php foreach ($teams as $team): ?>
            <li><?php partial('team-card', ['team' => $team]); ?></li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<section class="section section--surface" aria-labelledby="training-week-title">
    <div class="container">
        <div class="section-head">
            <div class="section-head__text">
                <h2 id="training-week-title">Die Trainingswoche</h2>
                <p class="section-head__intro">Sportzentrum Sandkrug, Halle 1A und 2A. Die Minis Kirchhatten trainieren in der Sporthalle Kirchhatten. Der Filter oben gilt auch hier.</p>
            </div>
            <p class="card__meta">Gezeigt: <strong><?= e($groupKey === null ? 'Alle' : $groups[$groupKey]['label']) ?></strong></p>
        </div>
        <?php partial('training-week', ['week' => training_week($teams)]); ?>
        <div class="card age-classes">
            <h3 class="card__title"><strong>Altersklassen Saison <?= e(SEASON_LABEL) ?></strong></h3>
            <dl class="age-classes__list">
<?php foreach (data('age-classes') as $ageClass): ?>
                <div>
                    <dt><?= e($ageClass['class']) ?></dt>
                    <dd class="card__meta"><?= e($ageClass['years']) ?></dd>
                </div>
<?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
