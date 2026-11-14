<?php
/**
 * Teams overview. Each group filter is its own static page; group pages
 * point their canonical URL to the full overview.
 *
 * @var array $params group (key or null)
 */
$groupKey = $params['group'];
$groups = data('team-groups');
$teams = teams_in_group($groupKey);
$teamCount = count(teams());

$page = [
    'title' => 'Mannschaften und Trainingszeiten | TSG Handball Hatten-Sandkrug',
    'description' => $teamCount . ' Handballteams von den Minis ab 5 Jahren bis zu den Herren: Trainingszeiten, Hallen, Ligen und Trainerteams der TSG Hatten-Sandkrug.',
    'path' => team_group_path($groupKey),
    'canonical' => 'mannschaften/',
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
        <nav class="filter" aria-label="Mannschaften nach Gruppe filtern">
            <a class="filter__option" href="<?= e(url(team_group_path(null))) ?>#mannschaften"<?= $groupKey === null ? ' aria-current="page"' : '' ?>>Alle</a>
<?php foreach ($groups as $key => $group): ?>
            <a class="filter__option" href="<?= e(url(team_group_path($key))) ?>#mannschaften"<?= $groupKey === $key ? ' aria-current="page"' : '' ?>><?= e($group['label']) ?></a>
<?php endforeach; ?>
        </nav>
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
