<?php
/**
 * News list. Each topic and page is generated as its own static page (NE-04).
 *
 * @var array $params topic (key or null), page, page_count
 */
$topicKey = $params['topic'];
$currentPage = $params['page'];
$pageCount = $params['page_count'];
$pageItems = array_slice(news_items($topicKey), ($currentPage - 1) * NEWS_PER_PAGE, NEWS_PER_PAGE);
$featured = $currentPage === 1 && $pageItems !== [] ? array_shift($pageItems) : null;

$titleSuffix = ($topicKey !== null ? ': ' . news_topic_label($topicKey) : '') . ($currentPage > 1 ? ' – Seite ' . $currentPage : '');
$breadcrumbs = [['Neuigkeiten', 'neuigkeiten/']];
if ($topicKey !== null) {
    $breadcrumbs[] = [news_topic_label($topicKey), news_list_path($topicKey)];
}

$page = [
    'title' => 'Neuigkeiten' . $titleSuffix . ' | TSG Handball Hatten-Sandkrug',
    'description' => 'Spielberichte, Turniere, Aufrufe und alles, was sich in der Handballabteilung der TSG Hatten-Sandkrug tut: von den Minis bis zur 1. Herren.',
    'path' => news_list_path($topicKey, $currentPage),
    'nav' => 'news',
    'breadcrumbs' => $breadcrumbs,
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => 'Neuigkeiten aus der Abteilung',
    'intro' => 'Spielberichte, Turniere, Aufrufe und alles, was sich in der Abteilung tut.',
    'aside' => button('Zu den Terminen', url('termine/'), 'secondary'),
]]);
?>
<section class="section" id="meldungen" aria-label="Meldungen">
    <div class="container">
        <?php partial('topic-filter', ['activeKey' => $topicKey]); ?>
<?php if ($featured === null && $pageItems === []): ?>
        <p class="card card--dashed">Zu diesem Thema gibt es gerade keine Meldung.</p>
<?php else: ?>
<?php if ($featured !== null): ?>
        <?php partial('news-featured', ['item' => $featured]); ?>
<?php endif; ?>
<?php if ($pageItems !== []): ?>
        <ul class="news-grid" role="list">
<?php foreach ($pageItems as $item): ?>
            <li><?php partial('news-card', ['item' => $item]); ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
        <?php partial('pagination', [
            'pageUrl' => function (int $number) use ($topicKey): string {
                return url(news_list_path($topicKey, $number)) . '#meldungen';
            },
            'currentPage' => $currentPage,
            'pageCount' => $pageCount,
            'nextLabel' => 'Ältere Meldungen',
        ]); ?>
<?php endif; ?>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
