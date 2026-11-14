<?php
/**
 * @var array       $item
 * @var string|null $headingLevel h2 (default) or h3
 */
$heading = $headingLevel ?? 'h2';
?>
<article class="news-card card--interactive">
    <?= media($item['image'], 'landscape', 'Bild zur Meldung „' . $item['title'] . '“') ?>
    <div class="news-card__body">
        <p class="news-card__meta">
            <time datetime="<?= e($item['date']->format('Y-m-d')) ?>"><?= e(date_short($item['date'])) ?></time>
            <span class="tag"><?= e(news_topic_label($item['topic'])) ?></span>
        </p>
        <<?= $heading ?> class="news-card__title"><a class="card__link" href="<?= e(news_url($item)) ?>"><?= e($item['title']) ?></a></<?= $heading ?>>
    </div>
</article>
