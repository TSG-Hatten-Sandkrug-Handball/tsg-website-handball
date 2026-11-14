<?php
declare(strict_types=1);

// schema.org objects (Lastenheft SEO-02). They only contain facts that are
// also visible on the page that outputs them.

function organization_schema(): array
{
    return [
        '@type' => 'SportsOrganization',
        '@id' => absolute_url('#organization'),
        'name' => DEPARTMENT_NAME,
        'alternateName' => SITE_NAME,
        'sport' => 'Handball',
        'url' => absolute_url(),
        'logo' => SITE_ORIGIN . url('assets/img/tsg-crest.png'),
        'email' => DEPARTMENT_EMAIL,
        'foundingDate' => '1968',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Schultredde',
            'postalCode' => '26209',
            'addressLocality' => 'Hatten',
            'addressCountry' => 'DE',
        ],
        'parentOrganization' => [
            '@type' => 'SportsClub',
            'name' => CLUB_NAME,
            'url' => link_url('club_home'),
        ],
        'sameAs' => [link_url('instagram')],
    ];
}

function website_schema(): array
{
    return [
        '@type' => 'WebSite',
        'name' => SITE_NAME . ' · ' . CLUB_NAME,
        'url' => absolute_url(),
        'inLanguage' => SITE_LANG,
        'publisher' => ['@id' => absolute_url('#organization')],
    ];
}

function breadcrumb_schema(array $breadcrumbs): array
{
    $items = [['label' => 'Handball', 'path' => '']];

    foreach ($breadcrumbs as $crumb) {
        $items[] = ['label' => $crumb[0], 'path' => $crumb[1]];
    }

    $list = [];

    foreach ($items as $index => $item) {
        $list[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['label'],
            'item' => absolute_url($item['path']),
        ];
    }

    return ['@type' => 'BreadcrumbList', 'itemListElement' => $list];
}

function sports_team_schema(array $team): array
{
    $schema = [
        '@type' => 'SportsTeam',
        'name' => 'TSG Hatten-Sandkrug ' . $team['name'],
        'sport' => 'Handball',
        'url' => SITE_ORIGIN . team_url($team),
        'memberOf' => ['@id' => absolute_url('#organization')],
        'coach' => array_map(function (array $coach): array {
            return ['@type' => 'Person', 'name' => $coach['person']['name']];
        }, team_coaches($team)),
    ];

    if (in_array($team['accent'], ['female'], true)) {
        $schema['gender'] = 'Female';
    }

    return $schema;
}

function home_match_schema(array $fixture): array
{
    $own = data('matches')['own_name'];

    return [
        '@type' => 'SportsEvent',
        'name' => $own . ' – ' . $fixture['opponent'],
        'sport' => 'Handball',
        'startDate' => $fixture['kickoff']->format(DATE_ATOM),
        'eventStatus' => 'https://schema.org/EventScheduled',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'location' => [
            '@type' => 'Place',
            'name' => 'Sportzentrum Sandkrug',
            'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Schultredde', 'postalCode' => '26209', 'addressLocality' => 'Hatten', 'addressCountry' => 'DE'],
        ],
        'homeTeam' => ['@type' => 'SportsTeam', 'name' => $own . ' 1. Herren'],
        'awayTeam' => ['@type' => 'SportsTeam', 'name' => $fixture['opponent']],
        'organizer' => ['@id' => absolute_url('#organization')],
        'offers' => [
            '@type' => 'Offer',
            'price' => number_format(data('tickets')['day'], 2, '.', ''),
            'priceCurrency' => 'EUR',
            'url' => absolute_url('heimspiele/'),
        ],
    ];
}

function news_article_schema(array $article): array
{
    return [
        '@type' => 'NewsArticle',
        'headline' => $article['title'],
        'datePublished' => $article['date']->format(DATE_ATOM),
        'url' => SITE_ORIGIN . news_url($article),
        'inLanguage' => SITE_LANG,
        'image' => [SITE_ORIGIN . ($article['image'] !== null ? url($article['image']) : url('assets/img/og-default.png'))],
        'author' => ['@id' => absolute_url('#organization')],
        'publisher' => [
            '@type' => 'Organization',
            'name' => DEPARTMENT_NAME,
            'logo' => ['@type' => 'ImageObject', 'url' => SITE_ORIGIN . url('assets/img/tsg-crest.png')],
        ],
    ];
}
