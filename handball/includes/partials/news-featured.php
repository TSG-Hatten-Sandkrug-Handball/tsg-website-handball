<?php /** @var array $item */ ?>
<article class="news-featured card--interactive">
    <?= media($item['image'], 'landscape', 'Bild zur Meldung „' . $item['title'] . '“', ['loading' => 'eager']) ?>
    <div class="news-featured__body">
        <p class="news-meta">
            <span class="tag"><?= e(news_topic_label($item['topic'])) ?></span>
            <time datetime="<?= e($item['date']->format('Y-m-d')) ?>"><?= e(date_short($item['date'])) ?></time>
        </p>
        <h2 class="news-featured__title"><?= e($item['title']) ?></h2>
<?php if ($item['teaser'] !== null): ?>
        <p class="news-featured__teaser"><?= e($item['teaser']) ?></p>
<?php endif; ?>
        <a class="news-featured__more card__link" href="<?= e(news_url($item)) ?>">Weiterlesen<span class="visually-hidden">: <?= e($item['title']) ?></span></a>
    </div>
</article>
