# TSG Handball – website of the handball department

New website of the handball department of TSG Hatten-Sandkrug e.V., planned for its own
subdomain (final name still open). Requirements: `TSG-Handball_Lastenheft.pdf`,
design: `TSG-Handball_Desktop.pdf` and `TSG-Handball_Mobil.pdf`.

**Plain HTML, CSS and a little JavaScript. No build step, no PHP, no database.**
Everything in `site/` is published exactly as it is. The only script outside `site/` is
the daily schedule import (see *Schedules and standings*), which writes JSON into `site/data/`.

## Structure

```
site/                       the website – upload this folder
├── index.html              overview page
├── <page>/index.html       one folder per page, e.g. kontakt/index.html → /kontakt/
├── neuigkeiten/<slug>/     one folder per article; thema/<topic>/ holds the filtered lists
├── mannschaften/<team>/    one folder per team; gruppe/<group>/ holds the filtered lists
├── data/teams/<team>.json  schedules and standings, written by the import – do not edit
│                           (opponents' crests land in assets/img/crests/)
├── 404.html, robots.txt, sitemap.xml, llms.txt
├── .htaccess               Strato settings (HTTPS, 404, caching); ignored by GitHub Pages
└── assets/
    ├── css/main.css        imports tokens.css (all colours, sizes, durations), base,
    │                       layout, components/ (one file per component), utilities
    ├── js/main.js          ES modules in js/modules/ (menu, countdown, schedules, video, …)
    ├── icons/              Lucide icons (ISC licence), used as CSS masks
    ├── placeholders/       placeholder images (Lastenheft 8.1)
    ├── fonts/              Barlow Condensed, Carlito (SIL Open Font License)
    └── img/                crest, favicon, Open Graph image
scripts/                    schedule import: import-hvnb.mjs, teams.json, sources/
docs/                       redirects to set up on the club website
```

All links inside the site are relative (`../kontakt/`), so the same files work in a sub
folder (GitHub Pages preview) and at the root of the subdomain (Strato).

## Preview locally

Any static web server works, for example from the repository root:

```
python -m http.server 8000 --directory site
```

Then open <http://localhost:8000/>. (Opening the files by double-click works too, but
links to folders then show a file list instead of the page.)

## Editing content

Without a build step, information that appears on several pages has to be changed in
each of them. Use *Find in files* in your editor (e.g. VS Code: Ctrl+Shift+F) and search
for the old value.

| Change | Files to edit |
| --- | --- |
| Menu, header or footer | every `index.html` and `404.html` (identical block in each file) |
| Person: name or e-mail | `kontakt/`, `uebungsleiter/`, the team pages, `abteilung/` (organisation chart), `schiedsrichter/`, `mitmachen/`, `foerderkreis/`, `1-herren/` |
| Training times or coaches | `mannschaften/index.html`, `mannschaften/gruppe/*/`, the team page, `uebungsleiter/` |
| Next home match of the 1. Herren | automatic (see *Schedules and standings*) |
| Ticket prices, directions | `index.html` (section `#tickets`) |
| New article | new folder `neuigkeiten/<slug>/` (copy an existing article), plus `neuigkeiten/index.html`, `index.html` (news block) and `sitemap.xml` |
| Event | `termine/index.html` (pattern below) |
| Downloads | `kontakt/` (Formulare, Hallenheft), `kids-cup/` |
| Sponsor | `sponsoren/index.html` (category section), plus the logo grid in `index.html` if there is a logo in `assets/img/partners/` |

Matches and events carry their date in `data-start`. Once it has passed, `upcoming.js`
hides them in the browser, so old entries do not have to be removed on the day itself.

Event pattern for `termine/index.html` (paste it into `<ul class="event-list">` and add
the attribute `hidden` to the "keine Termine" card above it):

```html
<li class="event" data-start="2027-03-20T00:00:00+01:00" data-end="2027-03-20T23:59:59+01:00">
    <time class="event__date" datetime="2027-03-20">
        <span class="event__day">20</span>
        <span class="event__month">Mär</span>
    </time>
    <div>
        <h3 class="card__title">Abteilungsversammlung</h3>
        <p class="card__meta">19:00 Uhr · Vereinsheim an der Schultredde</p>
    </div>
</li>
```

**Images:** put the file below `site/assets/img/` (WebP, sensible size) and replace the
placeholder in the `src` of the `<img>`; keep `width`/`height` and the surrounding
`media` frame, and turn the alt text from "Platzhalter: …" into a real description.

**New page:** copy the folder of a similar page, change `<title>`, description,
canonical/`og:url`, breadcrumb and content, keep the relative paths matching the folder
depth, then add it to the menu (all files, if it belongs there) and to `sitemap.xml`.

## Schedules and standings

Fixtures, results and league tables come from the HVNB's nuLiga and are imported, not
edited by hand.

- `scripts/import-hvnb.mjs` reads `scripts/teams.json` and writes one file per team to
  `site/data/teams/<slug>.json`. GitHub runs it every morning and on weekend evenings
  (`.github/workflows/import-hvnb.yml`, also startable by hand under *Actions*) and commits
  changes, which then publishes the site. Locally: `node scripts/import-hvnb.mjs` (Node 20+,
  no packages).
- In the browser, `team-schedule.js` fills the section *Spielplan und Tabelle* on each team
  page (`data-team-schedule`) and `next-home-match.js` fills the stage on the home page with
  the next home match of the 1. Herren. Both only read the JSON via `team-data.js`.
- **New season / new round:** nuLiga issues new group numbers. Update the `group` (and
  `championship`, e.g. `HVNB 27/28`) per team in `scripts/teams.json` – the number is in the
  team's nuLiga link (`group=…`). A team with a preliminary and a main round lists both,
  current round first. `nuligaName` is the team's exact name in nuLiga, e.g.
  `TSG Hatten-Sandkrug II`.
- **Crests:** teams with `"crests": true` (currently the 1. Herren) also get their opponents'
  logos from nuLiga (`scripts/crests.mjs`). Each logo is downloaded once into
  `site/assets/img/crests/<club id>.png`, scaled to 160 px with ffmpeg or ImageMagick if
  available. To replace a bad logo, overwrite that file; to fetch it again, delete it.
  Crests no team plays against any more are deleted at the end of each run.
- **New team:** add it to `scripts/teams.json` and copy the `data-team-schedule` section from
  another team page, with the matching JSON path.
- **Other data source:** `scripts/sources/nuliga.mjs` is the only file that knows nuLiga.
  A replacement only needs to export `fetchLeague(league)` with the shape described at the
  top of that file; then change the import in `import-hvnb.mjs`.
- **Strato:** the import commits to the repository, so the JSON files on Strato are only as
  fresh as the last upload of `site/data/`.

## Conventions

English class names and comments, German page copy. Mobile-first CSS in `@layer`s
(no `!important`), BEM-like class names, values only from `tokens.css`. No inline styles,
scripts or SVG in the markup. Every page is readable without JavaScript.

## Publishing

- **Preview for the board – GitHub Pages:** every push to `main` publishes `site/`
  (`.github/workflows/pages.yml`). In the repository settings, *Pages › Source* must be
  set to *GitHub Actions*; for a private repository this needs a paid GitHub plan for the
  organisation, otherwise make the repository public. On the preview, only the 404 page
  shows without styles, because it uses paths from the domain root.
- **Production – Strato webspace:** replace the placeholder domain
  `https://handball.tsg-hatten-sandkrug.de` with the final subdomain in all files of
  `site/` (search and replace; it appears in canonical URLs, social tags, structured data,
  `sitemap.xml`, `robots.txt` and `llms.txt`). Then upload the contents of `site/`
  (including `.htaccess`) into the subdomain's folder via SFTP and enable SSL.
- **Old addresses:** see `docs/redirects-main-domain.md`.
