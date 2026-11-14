<?php
// Organisation chart (Lastenheft OG-01 to OG-10). The cards link to the detail
// blocks below; with JavaScript those blocks open in a side panel instead.
$organization = data('organization');
$leadership = $organization['leadership'];
$maxAvatars = 3;
?>
<section class="section" id="unsere-organisation" aria-labelledby="organization-title">
    <div class="container">
        <div class="section-head">
            <div class="section-head__text">
                <p class="kicker">Organisation</p>
                <h2 id="organization-title">Unsere Organisation</h2>
                <p class="section-head__intro">Die Menschen, Aufgaben und Bereiche hinter unserer Handballabteilung. Wähle einen Bereich, um das Team und seine Aufgaben zu sehen.</p>
            </div>
        </div>
        <div class="org-chart">
            <article class="org-card org-card--lead card--interactive">
                <div class="org-card__head">
                    <span class="org-card__icon"><?= icon($leadership['icon']) ?></span>
                    <div>
                        <h3 class="org-card__title org-card__title--lead">
                            <a class="card__link" href="#<?= e($leadership['slug']) ?>" data-org-open="<?= e($leadership['slug']) ?>"><?= e($leadership['title']) ?></a>
                        </h3>
                        <p class="org-card__text"><?= e($leadership['summary']) ?></p>
                    </div>
                </div>
                <div class="org-card__footer">
                    <ul class="org-card__people" role="list">
<?php foreach (unit_people($leadership) as $member): ?>
                        <li class="person-row">
                            <?= media($member['person']['photo'], 'avatar', 'Foto von ' . $member['person']['name'], ['class' => 'person-row__photo', 'decorative' => true]) ?>
                            <span>
                                <span class="person-row__name"><?= e($member['person']['name']) ?></span><br>
                                <span class="person-row__function"><?= e($member['function']) ?></span>
                            </span>
                        </li>
<?php endforeach; ?>
                    </ul>
                    <?= icon('arrow-right', 'card__arrow') ?>
                </div>
            </article>
            <ul class="org-chart__areas" role="list">
<?php foreach ($organization['areas'] as $area):
    $members = unit_people($area);
    $extra = count($members) - $maxAvatars;
?>
                <li class="org-card card--interactive">
                    <span class="org-card__icon"><?= icon($area['icon']) ?></span>
                    <h3 class="org-card__title">
                        <a class="card__link" href="#<?= e($area['slug']) ?>" data-org-open="<?= e($area['slug']) ?>"><?= e($area['title']) ?></a>
                    </h3>
                    <p class="org-card__text"><?= e($area['keywords']) ?></p>
                    <div class="org-card__footer">
<?php if ($members === []): ?>
                        <span class="org-card__text">Team folgt</span>
<?php else: ?>
                        <span class="avatar-stack">
<?php foreach (array_slice($members, 0, $maxAvatars) as $member): ?>
                            <?= media($member['person']['photo'], 'avatar', 'Foto von ' . $member['person']['name'], ['class' => 'avatar-stack__item', 'decorative' => true]) ?>
<?php endforeach; ?>
<?php if ($extra > 0): ?>
                            <span class="avatar-stack__more">+<?= $extra ?><span class="visually-hidden"> weitere Personen</span></span>
<?php endif; ?>
                        </span>
<?php endif; ?>
                        <?= icon('arrow-right', 'card__arrow') ?>
                    </div>
                </li>
<?php endforeach; ?>
            </ul>
        </div>
        <nav class="org-chart__links" aria-label="Weitere Seiten der Abteilung">
            <span class="muted">Weiter zu:</span>
            <a class="text-link" href="<?= e(url('uebungsleiter/')) ?>">Übungsleiter</a>
            <a class="text-link" href="<?= e(url('schiedsrichter/')) ?>">Schiedsrichter</a>
            <a class="text-link" href="<?= e(url('mitmachen/')) ?>">Mitmachen</a>
            <a class="text-link" href="<?= e(url('kontakt/')) ?>">Alle Ansprechpartner</a>
        </nav>
    </div>
</section>
<?php partial('org-details'); ?>
