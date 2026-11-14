<?php
/**
 * Single article at /neuigkeiten/<slug>/ (Lastenheft NE-05).
 *
 * @var array $params article
 */
$article = $params['article'];

$topicLabel = news_topic_label($article['topic']);
$excerpt = $article['teaser'] ?? $article['title'] . ': Meldung der Handballabteilung der TSG Hatten-Sandkrug vom ' . date_short($article['date']) . '.';

$page = [
    'title' => $article['title'] . ' | TSG Handball',
    'description' => $excerpt,
    'path' => 'neuigkeiten/' . $article['slug'] . '/',
    'nav' => 'news',
    'og_type' => 'article',
    'og_title' => $article['title'],
    'og_image' => $article['image'] !== null ? url($article['image']) : null,
    'breadcrumbs' => [['Neuigkeiten', 'neuigkeiten/'], [$article['title'], 'neuigkeiten/' . $article['slug'] . '/']],
    'schema' => [news_article_schema($article)],
];

require INCLUDES_DIR . '/layout/start.php';
?>
<article class="article">
    <header class="page-hero">
        <div class="container page-hero__inner">
            <div class="page-hero__content article__header">
                <?php partial('breadcrumb', ['breadcrumbs' => $page['breadcrumbs']]); ?>
                <p class="news-meta">
                    <span class="tag"><?= e($topicLabel) ?></span>
                    <time datetime="<?= e($article['date']->format('Y-m-d')) ?>"><?= e(date_long($article['date'])) ?></time>
                </p>
                <h1 class="article__title"><?= e($article['title']) ?></h1>
            </div>
        </div>
    </header>
    <div class="section">
        <div class="container article__layout">
            <?= media($article['image'], 'landscape', 'Bild zur Meldung „' . $article['title'] . '“', ['loading' => 'eager', 'class' => 'article__image']) ?>
            <div class="article__body">
<?php if ($article['teaser'] !== null): ?>
                <p class="article__lead"><?= e($article['teaser']) ?></p>
<?php endif; ?>
<?php if ($article['body'] === []): ?>
                <p class="muted">Der ausführliche Bericht zu dieser Meldung folgt in Kürze.</p>
<?php else: ?>
<?php foreach ($article['body'] as $paragraph): ?>
                <p><?= e($paragraph) ?></p>
<?php endforeach; ?>
<?php endif; ?>
            </div>
<?php if ($article['gallery'] !== []): ?>
            <section class="article__gallery" aria-label="Bildergalerie">
                <ul class="grid grid--3" role="list">
<?php foreach ($article['gallery'] as $image): ?>
                    <li><?= media($image['src'], 'landscape', $image['alt']) ?></li>
<?php endforeach; ?>
                </ul>
            </section>
<?php endif; ?>
            <p><a class="text-link" href="<?= e(url('neuigkeiten/')) ?>"><?= icon('arrow-left') ?>&nbsp;Alle Neuigkeiten</a></p>
        </div>
    </div>
</article>
<section class="section section--surface" aria-labelledby="related-title">
    <div class="container">
        <h2 class="section-title-sm" id="related-title">Weitere Meldungen</h2>
        <ul class="news-grid" role="list">
<?php foreach (related_news($article, 4) as $item): ?>
            <li><?php partial('news-card', ['item' => $item, 'headingLevel' => 'h3']); ?></li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
