// Loads the per-team JSON written by scripts/import-hvnb.mjs. This is the only
// place the browser touches that format, so renderers stay independent of
// where the data comes from.
const cache = new Map();

export function loadTeamData(url) {
  if (!cache.has(url)) {
    cache.set(url, fetch(url).then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }

      return response.json();
    }));
  }

  return cache.get(url);
}

export function upcomingFixtures(data, now = Date.now()) {
  return data.fixtures.filter((fixture) => Date.parse(fixture.start) > now && !fixture.score);
}

export function lastResult(data) {
  return data.fixtures.filter((fixture) => fixture.score).at(-1) ?? null;
}

// Positive when the own team won, negative when it lost, 0 for a draw.
export function ownGoalDifference(fixture) {
  const [home, away] = fixture.score.split(':').map(Number);

  return fixture.isHome ? home - away : away - home;
}
