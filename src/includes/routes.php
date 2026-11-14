<?php
declare(strict_types=1);

// Every page of the site: output path (relative to the site root, without
// index.html), template in pages/, route parameters and whether it belongs
// in the sitemap. build.php renders exactly this list.
function site_routes(): array
{
    $routes = [['path' => '', 'template' => 'home']];

    foreach (array_merge([null], array_keys(data('news-topics'))) as $topicKey) {
        $pageCount = news_page_count($topicKey);

        for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
            $routes[] = [
                'path' => news_list_path($topicKey, $pageNumber),
                'template' => 'news',
                'params' => ['topic' => $topicKey, 'page' => $pageNumber, 'page_count' => $pageCount],
                'sitemap' => $topicKey === null && $pageNumber === 1,
            ];
        }
    }

    foreach (news_items() as $article) {
        $routes[] = ['path' => 'neuigkeiten/' . $article['slug'] . '/', 'template' => 'news-article', 'params' => ['article' => $article]];
    }

    $routes[] = ['path' => 'termine/', 'template' => 'events'];

    foreach (array_merge([null], array_keys(data('team-groups'))) as $groupKey) {
        $routes[] = [
            'path' => team_group_path($groupKey),
            'template' => 'teams',
            'params' => ['group' => $groupKey],
            'sitemap' => $groupKey === null,
        ];
    }

    foreach (teams() as $team) {
        if ($team['slug'] !== '1-herren') {
            $routes[] = ['path' => 'mannschaften/' . $team['slug'] . '/', 'template' => 'team', 'params' => ['team' => $team]];
        }
    }

    $simplePages = [
        '1-herren/' => 'first-team',
        'heimspiele/' => 'home-games',
        'kids-cup/' => 'kids-cup',
        'foerderkreis/' => 'support-club',
        'abteilung/' => 'department',
        'uebungsleiter/' => 'coaches',
        'schiedsrichter/' => 'referees',
        'mitmachen/' => 'get-involved',
        'service/' => 'service',
        'kontakt/' => 'contact',
    ];

    foreach ($simplePages as $path => $template) {
        $routes[] = ['path' => $path, 'template' => $template];
    }

    return array_map(function (array $route): array {
        return $route + ['params' => [], 'sitemap' => true];
    }, $routes);
}
