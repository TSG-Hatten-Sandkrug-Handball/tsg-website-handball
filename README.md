# TSG Handball – website of the handball department

New website of the handball department of TSG Hatten-Sandkrug e.V., planned for its own
subdomain (final name still open). Requirements: `TSG-Handball_Lastenheft.pdf`,
design: `TSG-Handball_Desktop.pdf` and `TSG-Handball_Mobil.pdf`.

The published site is **plain HTML, CSS and a little JavaScript**. PHP is only used as a
generator: `build.php` renders the templates in `src/` into static files in `dist/`.
The web server needs no PHP and no database.

## Build and preview

Requires PHP 7.2 or newer on your machine.

```
php build.php                       # production build into dist/
php -S localhost:8000 -t dist       # local preview at http://localhost:8000/
```

Options: `--origin=https://…` (domain), `--base=/folder` (when the site lives in a sub
folder, e.g. on GitHub Pages), `--noindex` (keeps search engines out), `--out=folder`.
Defaults live in `src/includes/config.php`. The build stops on any PHP warning.

## Structure

```
build.php                 generator: renders all routes, bundles CSS, copies assets
src/
├── data/                 all content as PHP arrays – edit these to change the site
├── pages/                one template per page type (home, news, team, …)
├── includes/
│   ├── config.php        domain, e-mail addresses, season, defaults
│   ├── routes.php        list of every generated page
│   ├── helpers.php       escaping, URLs, e-mail obfuscation, buttons, images
│   ├── repository.php    queries over the data (fixtures, training week, coaches …)
│   ├── schema.php        schema.org JSON-LD
│   ├── layout/           head, header, footer
│   └── partials/         reusable components (page hero, cards, roster, org chart …)
├── assets/
│   ├── css/              main.css imports tokens, base, layout, components/, utilities
│   ├── js/               main.js and one ES module per feature in modules/
│   ├── icons/            Lucide icons (ISC licence), used as CSS masks
│   ├── placeholders/     placeholder SVGs (Lastenheft 8.1)
│   ├── fonts/            Barlow Condensed, Carlito (SIL Open Font License)
│   └── img/              crest, favicon, Open Graph image
└── public/               copied as is into dist/ (.htaccess for Strato, llms.txt)
docs/                     redirects to set up on the club website
```

## Editing content

| What | Where |
| --- | --- |
| People (name, e-mail, photo) – maintained once, used everywhere | `src/data/people.php` |
| Teams, training times, coaches, squads, nuLiga IDs | `src/data/teams.php` |
| Schedule, last result, table of the 1. Herren | `src/data/matches.php` |
| News | `src/data/news.php` |
| Events | `src/data/events.php` |
| Contacts, referees, organisation chart, Förderkreis, Kids-Cup, prices | `contacts.php`, `referees.php`, `organization.php`, `support-club.php`, `kids-cup.php`, `tickets.php` |
| Downloads, Hallenhefte, partners | `documents.php`, `partners.php` |

Images go below `src/assets/img/`; set the path (e.g. `assets/img/teams/damen.webp`) in the
data entry. Without a path the matching placeholder is shown automatically.

After editing, rebuild. Past matches and events disappear in the browser automatically
(`upcoming.js`), so the site stays correct between builds; a rebuild only removes them
from the HTML.

## Adding things

- **Page:** add a template in `src/pages/`, register its path in `src/includes/routes.php`
  and, if it belongs in the menu, in `src/data/navigation.php`.
- **Component:** add `src/includes/partials/<name>.php` and
  `src/assets/css/components/<name>.css`, then import the CSS in `main.css`.
- **Team or article:** add an entry to the data file; its page is generated automatically.

## Conventions

English code, German page copy. Mobile-first CSS in `@layer`s (no `!important`), BEM-like
class names, values only from `tokens.css`. No inline styles, scripts or SVG in the markup.
All output goes through `e()`, mail links through `href()`/`email_link()` (obfuscated).
Everything is readable without JavaScript.

## Publishing

- **Preview for the board – GitHub Pages:** every push to `main` builds the site with
  `--noindex` and deploys it (`.github/workflows/pages.yml`). In the repository settings,
  *Pages › Source* must be set to *GitHub Actions*. For a private repository this requires a
  paid GitHub plan for the organisation; otherwise make the repository public.
- **Production – Strato webspace:** set the final subdomain in `config.php`, run
  `php build.php` and upload the contents of `dist/` (including `.htaccess`) into the
  subdomain's folder via SFTP. Point the subdomain to that folder in the Strato panel and
  enable SSL.
- **Old addresses:** see `docs/redirects-main-domain.md`.
