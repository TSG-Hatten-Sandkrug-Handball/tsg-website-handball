<?php
// Detail blocks for every area and person of the organisation chart.
// Without JavaScript they are listed below the chart (and readable by search
// engines); with JavaScript org-panel.js moves them into the side panel (OG-04).
?>
<section class="section section--surface org-details" aria-labelledby="org-details-title" data-org-details>
    <div class="container">
        <h2 class="section-title-sm" id="org-details-title">Bereiche und Ansprechpartner im Detail</h2>
        <div class="org-details__list">
<?php foreach (organization_units() as $unit):
    $members = unit_people($unit);
?>
            <article class="org-detail" id="<?= e($unit['slug']) ?>" data-org-view="<?= e($unit['slug']) ?>">
                <p class="kicker"><?= e($unit['title']) ?></p>
                <h3 class="org-detail__title" tabindex="-1" data-org-focus><?= e($unit['team_name']) ?></h3>
                <p class="muted"><?= e($unit['intro']) ?></p>
                <h4 class="org-detail__subtitle">Unsere Ansprechpartner</h4>
<?php if ($members === []): ?>
                <p class="muted">Das Team stellt sich gerade auf. Bis dahin erreichst du die Abteilung unter <?= email_link(DEPARTMENT_EMAIL) ?>.</p>
<?php else: ?>
                <ul class="org-detail__people" role="list">
<?php foreach ($members as $member): ?>
                    <li>
                        <a class="org-person-link" href="#person-<?= e($member['person']['key']) ?>" data-org-person="person-<?= e($member['person']['key']) ?>">
                            <span class="person-row">
                                <?= media($member['person']['photo'], 'avatar', 'Foto von ' . $member['person']['name'], ['class' => 'person-row__photo', 'decorative' => true]) ?>
                                <span>
                                    <span class="person-row__name"><?= e($member['person']['name']) ?></span><br>
                                    <span class="person-row__function"><?= e($member['function']) ?></span>
                                </span>
                            </span>
                            <?= icon('arrow-right', 'card__arrow') ?>
                        </a>
                    </li>
<?php endforeach; ?>
                </ul>
<?php endif; ?>
                <h4 class="org-detail__subtitle">Unsere Aufgaben</h4>
                <ul class="check-list" role="list">
<?php foreach ($unit['tasks'] as $task): ?>
                    <li class="check-list__item">
                        <?= icon('check') ?>
                        <span>
                            <strong><?= e($task['title']) ?></strong>
<?php if ($task['description'] !== null): ?>
                            <br><span class="muted"><?= e($task['description']) ?></span>
<?php endif; ?>
                        </span>
                    </li>
<?php endforeach; ?>
                </ul>
            </article>
<?php endforeach; ?>
<?php foreach (organization_people() as $key => $entry):
    $person = $entry['person'];
    $firstUnit = $entry['roles'][0]['unit'];
?>
            <article class="org-detail" id="person-<?= e($key) ?>" data-org-view="person-<?= e($key) ?>">
                <a class="org-detail__back" href="#<?= e($firstUnit['slug']) ?>" data-org-back="<?= e($firstUnit['slug']) ?>"><?= icon('arrow-left') ?> Zur Übersicht</a>
                <?= media($person['photo'], 'avatar', 'Foto von ' . $person['name'], ['class' => 'org-detail__photo']) ?>
                <h3 class="org-detail__title" tabindex="-1" data-org-focus><?= e($person['name']) ?></h3>
                <p class="org-detail__tags">
<?php foreach ($entry['roles'] as $role): ?>
                    <span class="tag tag--soft"><?= e($role['unit']['title']) ?></span>
<?php endforeach; ?>
                </p>
<?php if ($person['about'] !== null): ?>
                <h4 class="org-detail__subtitle">Über mich</h4>
                <p><?= e($person['about']) ?></p>
<?php endif; ?>
                <h4 class="org-detail__subtitle">Meine Aufgaben</h4>
                <ul class="check-list" role="list">
<?php foreach ($entry['roles'] as $role): ?>
                    <li class="check-list__item"><?= icon('check') ?><span><?= e($role['function']) ?></span></li>
<?php endforeach; ?>
                </ul>
<?php if ($person['email'] !== null): ?>
                <div><?= button('E-Mail schreiben', mailto($person['email']), 'primary', ['icon' => 'mail']) ?></div>
<?php endif; ?>
            </article>
<?php endforeach; ?>
        </div>
    </div>
</section>
<dialog class="side-panel" aria-label="Details zur Organisation" data-org-panel>
    <div class="side-panel__inner">
        <div class="side-panel__bar">
            <button class="side-panel__close" type="button" data-org-close>
                <?= icon('close') ?><span class="visually-hidden">Schließen</span>
            </button>
        </div>
        <div class="side-panel__content" data-org-panel-content></div>
    </div>
</dialog>
