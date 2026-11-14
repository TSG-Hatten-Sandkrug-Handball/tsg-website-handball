<?php
/**
 * "News aus der Halle": top story plus the next four (Lastenheft UE-03).
 *
 * @var array $items latest five articles
 */
if ($items === []) {
    return;
}

$feature = array_shift($items);
?>
<section class="section" aria-labelledby="home-news-title">
    <div class="container">
        <div class="section-head">
            <div class="section-head__text">
                <p class="kicker">Aktuelles</p>
                <h2 id="home-news-title">News aus der Halle</h2>
            </div>
            <a class="text-link" href="<?= e(url('neuigkeiten/')) ?>">Alle Neuigkeiten</a>
        </div>
        <div class="news-overview">
            <article class="news-spotlight card--interactive">
                <?= media($feature['image'], 'landscape', 'Bild zur Meldung „' . $feature['title'] . '“') ?>
                <div class="news-spotlight__body">
                    <p class="news-meta news-meta--light">
                        <span class="tag tag--light-on-brand tag--uppercase"><?= e(news_topic_label($feature['topic'])) ?></span>
                        <time datetime="<?= e($feature['date']->format('Y-m-d')) ?>"><?= e(date_short($feature['date'])) ?></time>
                    </p>
                    <h3 class="news-spotlight__title">
                        <a class="card__link" href="<?= e(news_url($feature)) ?>"><?= e($feature['title']) ?></a>
                    </h3>
                </div>
            </article>
            <ul class="news-list" role="list">
<?php foreach ($items as $item): ?>
                <li class="news-list__item">
                    <article class="news-list__article">
                        <?= media($item['image'], 'square', 'Vorschaubild zur Meldung „' . $item['title'] . '“', ['class' => 'news-list__thumb']) ?>
                        <div>
                            <p class="news-meta">
                                <time datetime="<?= e($item['date']->format('Y-m-d')) ?>"><?= e(date_short($item['date'])) ?></time>
                                · <?= e(news_topic_label($item['topic'])) ?>
                            </p>
                            <h3 class="news-list__title">
                                <a class="card__link" href="<?= e(news_url($item)) ?>"><?= e($item['title']) ?></a>
                            </h3>
                        </div>
                    </article>
                </li>
<?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
