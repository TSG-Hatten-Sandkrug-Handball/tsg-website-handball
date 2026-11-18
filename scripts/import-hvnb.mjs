// Imports schedules and standings of all teams listed in scripts/teams.json
// and writes one JSON file per team to site/data/teams/<slug>.json, which the
// team pages and the home page read in the browser.
//
//   node scripts/import-hvnb.mjs
//
// Runs daily via .github/workflows/import-hvnb.yml. Needs Node 20+, no packages.
// A team that fails to load keeps its previous file, so a flaky source never
// empties a page. Teams marked "crests": true also get their opponents' crests
// (see crests.mjs), used on the home page.

import { readFile, readdir, writeFile, mkdir } from 'node:fs/promises';
import * as source from './sources/nuliga.mjs';
import { updateCrests, pruneCrests } from './crests.mjs';

const ROOT = new URL('../', import.meta.url);
const SITE_DIR = new URL('site/', ROOT);
const OUTPUT_DIR = new URL('site/data/teams/', ROOT);
const SOURCE_NAME = 'nuLiga (HVNB)';

const { teams } = JSON.parse(await readFile(new URL('scripts/teams.json', ROOT), 'utf8'));
await mkdir(OUTPUT_DIR, { recursive: true });

let failures = 0;

for (const team of teams) {
  try {
    const leagues = [];

    for (const league of team.leagues) {
      leagues.push(await source.fetchLeague(league));
    }

    const file = new URL(`${team.slug}.json`, OUTPUT_DIR);
    const previous = await readFile(file, 'utf8').then(JSON.parse).catch(() => null);
    const data = buildTeamData(team, leagues);

    if (team.crests) {
      data.crests = await updateCrests({
        source,
        leagues: team.leagues,
        opponents: opponentsOf(data),
        previous: previous?.crests ?? {},
        siteDir: SITE_DIR,
      });
    }

    const changed = await writeTeam(file, previous, data);
    console.log(`${changed ? 'updated  ' : 'unchanged'} ${team.slug}`);
  } catch (error) {
    failures += 1;
    console.error(`failed    ${team.slug}: ${error.message}`);
  }
}

// Every team file counts, including those of teams that failed this run and
// kept their previous file, so a flaky run never deletes a crest still in use.
await pruneCrests({ siteDir: SITE_DIR, usedPaths: await crestsInUse() });

if (failures > 0) {
  process.exitCode = 1;
}

async function crestsInUse() {
  const used = new Set();

  for (const file of (await readdir(OUTPUT_DIR)).filter((name) => name.endsWith('.json'))) {
    const data = JSON.parse(await readFile(new URL(file, OUTPUT_DIR), 'utf8'));
    Object.values(data.crests ?? {}).forEach((path) => used.add(path));
  }

  return used;
}

function buildTeamData(team, leagues) {
  const isOwn = (name) => name === team.nuligaName;

  return {
    team: team.nuligaName,
    source: SOURCE_NAME,
    leagues: leagues.map((league) => ({
      name: league.name,
      url: league.url,
      table: league.table.map((standing) => ({ ...standing, own: isOwn(standing.team) })),
    })),
    fixtures: leagues
      .flatMap((league) => league.fixtures
        .filter((fixture) => isOwn(fixture.home) || isOwn(fixture.away))
        .map((fixture) => ({ ...fixture, league: league.name, isHome: isOwn(fixture.home) })))
      .sort((a, b) => Date.parse(a.start) - Date.parse(b.start)),
  };
}

function opponentsOf(data) {
  const names = data.fixtures.flatMap((fixture) => [fixture.home, fixture.away]);

  return [...new Set(names)].filter((name) => name !== data.team).sort();
}

// Writes only when the data itself changed, so the daily run does not create
// a commit just because the timestamp moved.
async function writeTeam(file, previous, data) {
  if (previous && JSON.stringify({ ...previous, updatedAt: null }) === JSON.stringify({ ...data, updatedAt: null })) {
    return false;
  }

  await writeFile(file, `${JSON.stringify({ ...data, updatedAt: new Date().toISOString() }, null, 2)}\n`);
  return true;
}
