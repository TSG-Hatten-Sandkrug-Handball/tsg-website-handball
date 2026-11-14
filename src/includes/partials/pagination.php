<?php
/**
 * Page numbers with a "next" link (Lastenheft NE-04). Hidden for a single page.
 *
 * @var callable $pageUrl     page number => URL
 * @var int      $currentPage
 * @var int      $pageCount
 * @var string   $nextLabel
 */
if ($pageCount < 2) {
    return;
}

// Show the first pages, the neighbours of the current page and the last page.
$visible = array_unique(array_filter([1, 2, 3, $currentPage - 1, $currentPage, $currentPage + 1, $pageCount], function (int $number) use ($pageCount): bool {
    return $number >= 1 && $number <= $pageCount;
}));
sort($visible);
?>
<nav class="pagination" aria-label="Seiten">
    <ul class="pagination__list">
<?php
$previous = 0;
foreach ($visible as $number):
    if ($number - $previous > 1): ?>
        <li class="pagination__gap" aria-hidden="true">…</li>
<?php endif; ?>
        <li>
<?php if ($number === $currentPage): ?>
            <span class="pagination__item" aria-current="page"><span class="visually-hidden">Seite </span><?= $number ?></span>
<?php else: ?>
            <a class="pagination__item" href="<?= e($pageUrl($number)) ?>"><span class="visually-hidden">Seite </span><?= $number ?></a>
<?php endif; ?>
        </li>
<?php
    $previous = $number;
endforeach;
?>
<?php if ($currentPage < $pageCount): ?>
        <li><a class="pagination__item pagination__item--next" href="<?= e($pageUrl($currentPage + 1)) ?>" rel="next"><?= e($nextLabel) ?></a></li>
<?php endif; ?>
    </ul>
</nav>
