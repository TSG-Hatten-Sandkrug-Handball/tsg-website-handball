<?php
/**
 * Topic switches on /neuigkeiten (Lastenheft NE-01). A plain GET form, so it
 * works without JavaScript and the chosen topic ends up in the URL.
 *
 * @var string|null $activeKey
 */
?>
<form class="filter" action="<?= e(url('neuigkeiten/')) ?>#meldungen" method="get" aria-label="Meldungen nach Thema filtern">
    <button class="filter__option" type="submit" aria-pressed="<?= $activeKey === null ? 'true' : 'false' ?>">Alle</button>
<?php foreach (data('news-topics') as $key => $topic): ?>
    <button class="filter__option" type="submit" name="thema" value="<?= e($topic['slug']) ?>" aria-pressed="<?= $activeKey === $key ? 'true' : 'false' ?>"><?= e($topic['label']) ?></button>
<?php endforeach; ?>
</form>
