<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

// Filter and page live in the URL, so they survive paging and can be shared (NE-04).
$topicSlug = isset($_GET['thema']) && is_string($_GET['thema']) ? $_GET['thema'] : null;
$topicKey = news_topic_key_from_slug($topicSlug);
$items = news_items($topicKey);
$pageCount = max(1, (int) ceil(count($items) / NEWS_PER_PAGE));
$currentPage = isset($_GET['seite']) ? (int) $_GET['seite'] : 1;
$currentPage = min(max(1, $currentPage), $pageCount);
$pageItems = array_slice($items, ($currentPage - 1) * NEWS_PER_PAGE, NEWS_PER_PAGE);
$featured = $currentPage === 1 && $pageItems !== [] ? array_shift($pageItems) : null;

$page = [
    'title' => 'Neuigkeiten der Handballabteilung | TSG Hatten-Sandkrug',
    'description' => 'Spielberichte, Turniere, Aufrufe und alles, was sich in der Handballabteilung der TSG Hatten-Sandkrug tut: von den Minis bis zur 1. Herren.',
    'path' => 'neuigkeiten/',
    'nav' => 'news',
    'breadcrumbs' => [['Neuigkeiten', 'neuigkeiten/']],
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
            'baseUrl' => url('neuigkeiten/'),
            'currentPage' => $currentPage,
            'pageCount' => $pageCount,
            'query' => $topicKey !== null ? ['thema' => $topicSlug] : [],
            'anchor' => 'meldungen',
            'nextLabel' => 'Ältere Meldungen',
        ]); ?>
<?php endif; ?>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
