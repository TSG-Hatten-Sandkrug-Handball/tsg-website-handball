<?php
/** @var array $breadcrumbs [[label, path], ...] without the root, last item is the current page */
$lastIndex = count($breadcrumbs) - 1;
?>
<nav class="breadcrumb" aria-label="Brotkrumen">
    <ol class="breadcrumb__list">
        <li class="breadcrumb__item"><a class="breadcrumb__link" href="<?= e(url()) ?>">Handball</a></li>
<?php foreach ($breadcrumbs as $index => $crumb): ?>
<?php if ($index === $lastIndex): ?>
        <li class="breadcrumb__item" aria-current="page"><?= e($crumb[0]) ?></li>
<?php else: ?>
        <li class="breadcrumb__item"><a class="breadcrumb__link" href="<?= e(url($crumb[1])) ?>"><?= e($crumb[0]) ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
    </ol>
</nav>
