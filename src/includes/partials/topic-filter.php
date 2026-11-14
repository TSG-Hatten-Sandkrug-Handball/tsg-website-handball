<?php
/**
 * Topic filter on the news list (Lastenheft NE-01). Each option links to the
 * static page of its topic; the active one is marked with aria-current.
 *
 * @var string|null $activeKey
 */
$options = array_merge(['all' => ['label' => 'Alle', 'key' => null]], array_map(function (string $key) {
    return ['label' => news_topic_label($key), 'key' => $key];
}, array_combine(array_keys(data('news-topics')), array_keys(data('news-topics')))));
?>
<nav class="filter" aria-label="Meldungen nach Thema filtern">
<?php foreach ($options as $option): ?>
    <a class="filter__option" href="<?= e(url(news_list_path($option['key']))) ?>#meldungen"<?= $activeKey === $option['key'] ? ' aria-current="page"' : '' ?>><?= e($option['label']) ?></a>
<?php endforeach; ?>
</nav>
