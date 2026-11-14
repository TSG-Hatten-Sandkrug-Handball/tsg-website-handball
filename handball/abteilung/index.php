<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$rules = data('documents')['department_rules'];
$stats = [
    ['value' => '1892', 'label' => 'Gründung der TSG'],
    ['value' => '1968', 'label' => 'Gründung der Handballabteilung'],
    ['value' => (string) count(teams()), 'label' => 'Mannschaften von den Minis bis zu den Herren'],
    ['value' => '400', 'label' => 'Plätze in der Halle, im Schnitt 250 Zuschauer'],
];
$achievements = [
    'Zahlreiche Kreis-, Bezirks- und Landesmeisterschaften',
    'Norddeutsche Vizemeisterschaften mit der männlichen A- und B-Jugend',
    'Viele Berufungen in Kreis-, Bezirks- und Landesauswahl',
    'Berufungen zu Jugendnationalspielern und Nationalspielern',
];

$page = [
    'title' => 'Die Handballabteilung: Organisation und Geschichte | TSG Hatten-Sandkrug',
    'description' => 'Hatter Handball seit 1968: Zahlen, Erfolge der Jugend, die Organisation der Abteilung mit allen Bereichen und Ansprechpartnern sowie die Abteilungsordnung.',
    'path' => 'abteilung/',
    'nav' => 'department',
    'breadcrumbs' => [['Abteilung', 'abteilung/']],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => 'Hatter Handball: familiär, ehrgeizig, aus der eigenen Jugend',
    'intro' => 'Die TSG Hatten-Sandkrug ist mit rund 3.000 Mitgliedern einer der größten Vereine im Landkreis Oldenburg. Die Handballabteilung gibt es seit 1968, die 1. Herren spielen heute in der Oberliga Männer Nord.',
]]);
?>
<section class="section" aria-label="Zahlen">
    <div class="container">
        <dl class="stats">
<?php foreach ($stats as $stat): ?>
            <div class="stats__item">
                <dt class="stats__label"><?= e($stat['label']) ?></dt>
                <dd class="stats__value"><?= e($stat['value']) ?></dd>
            </div>
<?php endforeach; ?>
        </dl>
    </div>
</section>
<section class="section section--brand-dark" aria-labelledby="youth-work-title">
    <div class="container split">
        <div class="stack">
            <h2 id="youth-work-title">Erfolgreiche Jugendarbeit</h2>
            <p>Viele, die heute in der 1. Herren oder anderswo hochklassig spielen, sind in der Hatter Handballjugend groß geworden. Jugendarbeit ist ein fester Teil unseres Konzepts.</p>
        </div>
        <ul class="achievements" role="list">
<?php foreach ($achievements as $achievement): ?>
            <li class="achievements__item"><?= e($achievement) ?></li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<?php partial('org-chart'); ?>
<section class="section section--surface section--tight" aria-labelledby="rules-title">
    <div class="container cta-band__inner">
        <div>
            <h2 class="section-title-sm" id="rules-title">Abteilungsordnung</h2>
            <p class="muted">Beschlossen am 14. Juli 2020. Sie regelt Aufgaben, Wahlen und Finanzen der Handballabteilung.</p>
        </div>
        <div><?= button('Abteilungsordnung öffnen', $rules['url'], 'primary') ?></div>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
