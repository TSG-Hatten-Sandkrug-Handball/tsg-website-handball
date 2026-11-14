<?php
declare(strict_types=1);

// Read-only queries over the data files. Templates call these functions
// instead of digging through the raw arrays themselves.

function person(string $key): array
{
    $people = data('people');

    if (!isset($people[$key])) {
        throw new InvalidArgumentException('Unknown person: ' . $key);
    }

    return $people[$key] + ['key' => $key, 'email' => null, 'photo' => null, 'about' => null];
}

/* Teams ------------------------------------------------------------------ */

function teams(): array
{
    $teams = [];

    foreach (data('teams') as $slug => $team) {
        $teams[$slug] = $team + ['slug' => $slug, 'staff' => [], 'roster' => [], 'coaching_group' => null];
    }

    return $teams;
}

function team(string $slug): ?array
{
    return teams()[$slug] ?? null;
}

function team_url(array $team): string
{
    return $team['slug'] === '1-herren' ? url('1-herren/') : url('mannschaften/' . $team['slug'] . '/');
}

function team_group_path(?string $groupKey): string
{
    return $groupKey === null ? 'mannschaften/' : 'mannschaften/gruppe/' . data('team-groups')[$groupKey]['slug'] . '/';
}

function teams_in_group(?string $groupKey): array
{
    return array_filter(teams(), function (array $team) use ($groupKey): bool {
        return $groupKey === null || $team['group'] === $groupKey;
    });
}

function youth_teams(): array
{
    return array_filter(teams(), function (array $team): bool {
        return $team['group'] !== 'adults';
    });
}

function team_coaches(array $team): array
{
    return array_map(function (array $coach): array {
        return ['person' => person($coach[0]), 'role' => $coach[1]];
    }, $team['coaches']);
}

function coach_names(array $team): string
{
    return implode(', ', array_map(function (array $coach): string {
        return $coach['person']['name'];
    }, team_coaches($team)));
}

function team_email(array $team): string
{
    return $team['email'] ?? DEPARTMENT_EMAIL;
}

function nuliga_url(array $team, string $page): ?string
{
    if ($team['nuliga'] === null) {
        return null;
    }

    $base = 'https://hvnb-handball.liga.nu/cgi-bin/WebObjects/nuLigaHBDE.woa/wa/';
    $params = ['championship' => $team['nuliga']['championship'], 'group' => $team['nuliga']['group']];

    if ($page === 'schedule') {
        $params = ['teamtable' => $team['nuliga']['team_table'], 'pageState' => 'vorrunde'] + $params;

        return $base . 'teamPortrait?' . http_build_query($params);
    }

    return $base . 'groupPage?' . http_build_query($params);
}

function hall(string $key): array
{
    return data('halls')[$key];
}

// All sessions of the given teams grouped by weekday, sorted by start time.
function training_week(array $teams): array
{
    $week = array_fill_keys(array_keys(TRAINING_DAYS), []);
    $order = array_flip(array_keys(teams()));

    foreach ($teams as $team) {
        foreach ($team['training'] as $session) {
            $week[$session[0]][] = [
                'team' => $team,
                'start' => $session[1],
                'end' => $session[2],
                'hall' => hall($session[3]),
            ];
        }
    }

    foreach ($week as &$sessions) {
        usort($sessions, function (array $a, array $b) use ($order): int {
            return [$a['start'], $order[$a['team']['slug']]] <=> [$b['start'], $order[$b['team']['slug']]];
        });
    }
    unset($sessions);

    return $week;
}

// Coaches grouped by person for /uebungsleiter (Lastenheft UL-01). Teams that
// share a coaching group (e.g. Weibliche D-Jugend 1 und 2) are merged per role.
function coaches_overview(): array
{
    $people = [];

    foreach (teams() as $team) {
        foreach ($team['coaches'] as $coach) {
            list($key, $role) = $coach;
            $label = $team['coaching_group'] ?? $team['name'];

            if (!isset($people[$key])) {
                $people[$key] = ['person' => person($key), 'assignments' => []];
            }

            $people[$key]['assignments'][$label . '|' . $role] = [
                'label' => $label,
                'role' => $role,
                'url' => team_url($team),
            ];
        }
    }

    uasort($people, function (array $a, array $b): int {
        return sort_key($a['person']['name']) <=> sort_key($b['person']['name']);
    });

    return $people;
}

/* Matches ---------------------------------------------------------------- */

function fixtures(): array
{
    $matches = data('matches');

    return array_map(function (array $fixture) use ($matches): array {
        $fixture['kickoff'] = local_date($fixture['kickoff']);
        $fixture['home_team'] = $fixture['home'] ? $matches['own_name'] : $fixture['opponent'];
        $fixture['away_team'] = $fixture['home'] ? $fixture['opponent'] : $matches['own_name'];

        return $fixture;
    }, $matches['fixtures']);
}

function upcoming_fixtures(int $limit): array
{
    $now = now();
    $upcoming = array_filter(fixtures(), function (array $fixture) use ($now): bool {
        return $fixture['kickoff'] > $now;
    });

    return array_slice(array_values($upcoming), 0, $limit);
}

// Home fixtures still ahead at build time. The page shows the first one;
// upcoming.js switches to the next once kick-off has passed (Lastenheft UE-02).
function upcoming_home_fixtures(): array
{
    return array_values(array_filter(upcoming_fixtures(PHP_INT_MAX), function (array $fixture): bool {
        return $fixture['home'];
    }));
}


function last_result(): ?array
{
    $results = data('matches')['results'];

    if ($results === []) {
        return null;
    }

    $result = $results[0];
    $result['date'] = local_date($result['date']);
    $result['outcome'] = $result['goals_for'] <=> $result['goals_against'];

    return $result;
}

/* News ------------------------------------------------------------------- */

// Every topic and page of the news list is its own static page, so the
// filter survives paging and stays in the URL (Lastenheft NE-04).
function news_list_path(?string $topicKey, int $pageNumber = 1): string
{
    $path = 'neuigkeiten/';

    if ($topicKey !== null) {
        $path .= 'thema/' . data('news-topics')[$topicKey]['slug'] . '/';
    }

    if ($pageNumber > 1) {
        $path .= 'seite/' . $pageNumber . '/';
    }

    return $path;
}

function news_page_count(?string $topicKey): int
{
    return max(1, (int) ceil(count(news_items($topicKey)) / NEWS_PER_PAGE));
}

function news_topic_label(string $key): string
{
    return data('news-topics')[$key]['label'];
}

function news_items(?string $topicKey = null): array
{
    $items = array_map(function (array $item): array {
        $item['date'] = local_date($item['date']);

        return $item;
    }, data('news'));

    if ($topicKey !== null) {
        $items = array_values(array_filter($items, function (array $item) use ($topicKey): bool {
            return $item['topic'] === $topicKey;
        }));
    }

    usort($items, function (array $a, array $b): int {
        return $b['date'] <=> $a['date'];
    });

    return $items;
}

function news_item(string $slug): ?array
{
    foreach (news_items() as $item) {
        if ($item['slug'] === $slug) {
            return $item;
        }
    }

    return null;
}

function news_url(array $item): string
{
    return url('neuigkeiten/' . $item['slug'] . '/');
}

// Same topic first, then the latest articles, never the article itself.
function related_news(array $article, int $limit): array
{
    $sameTopic = news_items($article['topic']);
    $candidates = array_merge($sameTopic, news_items());
    $related = [];

    foreach ($candidates as $item) {
        if ($item['slug'] !== $article['slug'] && !isset($related[$item['slug']])) {
            $related[$item['slug']] = $item;
        }
    }

    return array_slice(array_values($related), 0, $limit);
}

/* Events ----------------------------------------------------------------- */

function upcoming_events(): array
{
    $today = today();
    $events = array_map(function (array $event): array {
        $event['date'] = local_date($event['date']);

        return $event;
    }, data('events'));

    $events = array_values(array_filter($events, function (array $event) use ($today): bool {
        return $event['date'] >= $today;
    }));

    usort($events, function (array $a, array $b): int {
        return $a['date'] <=> $b['date'];
    });

    return $events;
}

/* Organisation ----------------------------------------------------------- */

function organization_units(): array
{
    $organization = data('organization');

    return array_merge([$organization['leadership']], $organization['areas']);
}

function unit_people(array $unit): array
{
    return array_map(function (array $entry): array {
        return ['person' => person($entry[0]), 'function' => $entry[1]];
    }, $unit['people']);
}

// Every person in the chart once, with all their functions across areas.
function organization_people(): array
{
    $people = [];

    foreach (organization_units() as $unit) {
        foreach ($unit['people'] as $entry) {
            list($key, $function) = $entry;

            if (!isset($people[$key])) {
                $people[$key] = ['person' => person($key), 'roles' => []];
            }

            $people[$key]['roles'][] = ['unit' => $unit, 'function' => $function];
        }
    }

    return $people;
}
