# TSG Handball – website for /handball

New site of the handball department of TSG Hatten-Sandkrug e.V., served under
`https://www.tsg-hatten-sandkrug.de/handball/`. Requirements: `TSG-Handball_Lastenheft.pdf`,
design: `TSG-Handball_Desktop.pdf` and `TSG-Handball_Mobil.pdf`.

Plain PHP (7.2 compatible, matching the current server) without framework, database or build step.
All page content is rendered on the server, JavaScript only enhances (menu, countdown, side panel).

## Structure

```
handball/                 deploy this folder as /handball on the web server
├── index.php             overview page; every other page is <route>/index.php
├── neuigkeiten/          news list (?thema=, ?seite=) + article.php (/neuigkeiten/<slug>/)
├── mannschaften/         teams overview (?gruppe=) + team.php (/mannschaften/<slug>/)
├── data/                 all content as PHP arrays – edit these to change the site
├── includes/
│   ├── config.php        site-wide constants (domain, base path, e-mail addresses, season)
│   ├── helpers.php       escaping, URLs, e-mail obfuscation, buttons, images
│   ├── repository.php    queries over the data (next home match, training week, coaches …)
│   ├── schema.php        schema.org JSON-LD
│   ├── layout/           head, header, footer, start/end of every page
│   └── partials/         reusable components (page hero, cards, roster, org chart …)
├── assets/
│   ├── css/main.css      @import list; tokens.css holds every colour, size and duration
│   ├── css/components/   one file per component
│   ├── js/main.js        ES modules in js/modules/
│   ├── icons/            Lucide icons (ISC licence), used as CSS masks
│   ├── placeholders/     placeholder SVGs (Lastenheft 8.1)
│   ├── fonts/            Barlow Condensed and Carlito (SIL Open Font License)
│   └── img/              crest, favicon, Open Graph image
├── .htaccess             old-URL redirects, clean URLs, protection of includes/ and data/
├── 404.php, sitemap.php (served as sitemap.xml), llms.txt
dev-router.php            emulates .htaccess for PHP's built-in server (local only)
```

## Run locally

```
php -S localhost:8000 dev-router.php
```

Then open <http://localhost:8000/handball/>.

## Editing content

| What | Where |
| --- | --- |
| People (name, e-mail, photo) – maintained once, used everywhere | `data/people.php` |
| Teams, training times, coaches, squads, nuLiga IDs | `data/teams.php` |
| Schedule, last result, table of the 1. Herren | `data/matches.php` |
| News | `data/news.php` (newest first is automatic) |
| Events | `data/events.php` (past events disappear automatically) |
| Contacts, referees, organisation chart, Förderkreis, Kids-Cup, prices | `data/contacts.php`, `referees.php`, `organization.php`, `support-club.php`, `kids-cup.php`, `tickets.php` |
| Downloads, Hallenhefte, partners | `data/documents.php`, `data/partners.php` |

Images: put the file below `handball/assets/img/` and set its path (e.g. `assets/img/teams/damen.webp`)
in the data entry. Without a path the matching placeholder is shown automatically.

## Adding things

- **Page:** create `handball/<route>/index.php`, copy the `$page` block from an existing page
  (title, description, path, nav, breadcrumbs), include `layout/start.php` and `layout/end.php`,
  and add the route to `sitemap.php` and, if needed, `data/navigation.php`.
- **Component:** add `includes/partials/<name>.php` and `assets/css/components/<name>.css`,
  then import the CSS file in `assets/css/main.css`.
- **Team:** add an entry to `data/teams.php`; its page `/mannschaften/<key>/` exists immediately.

## Conventions

English code, German page copy. Mobile-first CSS with `@layer` (no `!important`), BEM-like class
names, values only from `tokens.css`. No inline styles, scripts or SVG in the markup. Every output
goes through `e()`, mail links through `href()`/`email_link()` (obfuscated against harvesters).

## Deployment notes

- Upload the `handball/` folder to the web root so it is reachable as `/handball/`. Its `.htaccess`
  needs `AllowOverride All` (mod_rewrite) – the same as TYPO3 already uses.
- Add the sitemap to the domain's `robots.txt`:
  `Sitemap: https://www.tsg-hatten-sandkrug.de/handball/sitemap.xml`
- HTTPS and the preferred host (`www`) are enforced by the main site.
- PHP 7.2 is end of life; the code also runs on PHP 8.x, so an upgrade is safe.
