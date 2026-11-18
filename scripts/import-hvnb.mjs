// Imports schedules and standings of all teams listed in scripts/teams.json
// and writes one JSON file per team to site/data/teams/<slug>.json, which the
// team pages and the home page read in the browser.
//
//   node scripts/import-hvnb.mjs
//
// Runs daily via .github/workflows/import-hvnb.yml. Needs Node 20+, no packages.
// A team that fails to load keeps its previous file, so a flaky source never
// empties a page.

import { readFile, writeFile, mkdir } from 'node:fs/promises';
import { fetchLeague } from './sources/nuliga.mjs';

const ROOT = new URL('../', import.meta.url);
const OUTPUT_DIR = new URL('site/data/teams/', ROOT);
const SOURCE_NAME = 'nuLiga (HVNB)';

const { teams } = JSON.parse(await readFile(new URL('scripts/teams.json', ROOT), 'utf8'));
await mkdir(OUTPUT_DIR, { recursive: true });

let failures = 0;

for (const team of teams) {
  try {
    const leagues = [];

    for (const league of team.leagues) {
      leagues.push(await fetchLeague(league));
    }

    const changed = await writeTeam(team.slug, buildTeamData(team, leagues));
    console.log(`${changed ? 'updated  ' : 'unchanged'} ${team.slug}`);
  } catch (error) {
    failures += 1;
    console.error(`failed    ${team.slug}: ${error.message}`);
  }
}

if (failures > 0) {
  process.exitCode = 1;
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

// Writes only when the data itself changed, so the daily run does not create
// a commit just because the timestamp moved.
async function writeTeam(slug, data) {
  const file = new URL(`${slug}.json`, OUTPUT_DIR);
  const previous = await readFile(file, 'utf8').then(JSON.parse).catch(() => null);

  if (previous && JSON.stringify({ ...previous, updatedAt: null }) === JSON.stringify({ ...data, updatedAt: null })) {
    return false;
  }

  await writeFile(file, `${JSON.stringify({ ...data, updatedAt: new Date().toISOString() }, null, 2)}\n`);
  return true;
}
