// Data source: nuLiga, the HVNB federation's results system. It offers no API
// or feed, only server-rendered HTML, so this file reads the two pages of a
// league ("group"): the standings page and the full schedule.
//
// Every source exports fetchLeague(league) and resolves to the same shape:
//   { name, url, table: [Standing], fixtures: [Fixture] }
//   Standing: { rank, team, games, wins, draws, losses, goals, goalDifference, points }
//   Fixture:  { number, start, timeKnown, venue, home, away, score }
// To switch to another source, add a file with the same export and point
// scripts/import-hvnb.mjs at it. Nothing else depends on nuLiga.

const BASE_URL = 'https://hvnb-handball.liga.nu/cgi-bin/WebObjects/nuLigaHBDE.woa/wa';
const ATTEMPTS = 3;
const TIMEOUT_MS = 15_000;

export async function fetchLeague({ championship, group }) {
  const query = `championship=${encodeURIComponent(championship)}&group=${encodeURIComponent(group)}`;
  const url = `${BASE_URL}/groupPage?${query}`;
  const standingsHtml = await fetchHtml(url);
  const scheduleHtml = await fetchHtml(`${url}&displayTyp=gesamt&displayDetail=meetings`);

  return {
    name: parseLeagueName(standingsHtml),
    url,
    table: parseStandings(standingsHtml),
    fixtures: parseFixtures(scheduleHtml),
  };
}

async function fetchHtml(url) {
  let lastError;

  for (let attempt = 1; attempt <= ATTEMPTS; attempt += 1) {
    try {
      const response = await fetch(url, {
        headers: { accept: 'text/html' },
        signal: AbortSignal.timeout(TIMEOUT_MS),
      });

      if (response.ok) {
        return await response.text();
      }

      lastError = new Error(`HTTP ${response.status} for ${url}`);
    } catch (error) {
      lastError = error;
    }

    await new Promise((resolve) => setTimeout(resolve, 1000 * attempt));
  }

  throw lastError;
}

// The page heading reads "HVNB 2026/27 <br> Oberliga Männer Nord <br> Tabelle und Spielplan".
function parseLeagueName(html) {
  const heading = html.match(/<h1>([\s\S]*?)<\/h1>/);
  const lines = heading ? heading[1].split(/<br\s*\/?>/).map(cellText) : [];

  return lines[1] || lines[0] || '';
}

function parseStandings(html) {
  return parseTable(html).map((cells) => ({
    rank: toNumber(cells.Rang),
    team: cells.Mannschaft,
    games: toNumber(cells.Begegnungen),
    wins: toNumber(cells.S),
    draws: toNumber(cells.U),
    losses: toNumber(cells.N),
    goals: cells.Tore || null,
    goalDifference: cells['+/-'] || null,
    points: cells.Punkte || null,
  })).filter((standing) => standing.team);
}

function parseFixtures(html) {
  const fixtures = [];
  // Follow-up matches on the same day leave the date cell empty.
  let lastDate = '';

  for (const { cells, raw } of parseTable(html, { withRaw: true })) {
    lastDate = cells.Datum || lastDate;
    const time = (cells.Zeit || '').match(/\d{1,2}:\d{2}/)?.[0] ?? null;
    const score = (cells[''] || '').match(/^\d+:\d+$/)?.[0] ?? null;

    if (!lastDate || !cells.Heimmannschaft || !cells.Gastmannschaft) {
      continue;
    }

    fixtures.push({
      number: cells['Nr.'] || null,
      start: toBerlinIso(lastDate, time ?? '00:00'),
      timeKnown: time !== null,
      // The venue cell shows an internal code; the hall name is in its title.
      venue: cellText(raw.Ort?.match(/title="([^"]*)"/)?.[1] ?? '') || null,
      home: cells.Heimmannschaft,
      away: cells.Gastmannschaft,
      score,
    });
  }

  return fixtures;
}

// Reads the first result table into objects keyed by column heading. The
// result column of the schedule has no heading, so it ends up under ''.
function parseTable(html, { withRaw = false } = {}) {
  const start = html.indexOf('<table class="result-set"');
  const end = html.indexOf('</table>', start);

  if (start === -1 || end === -1) {
    return [];
  }

  const rows = [...html.slice(start, end).matchAll(/<tr[^>]*>([\s\S]*?)<\/tr>/g)].map((match) => match[1]);
  const headings = [...(rows.shift() ?? '').matchAll(/<th[^>]*>([\s\S]*?)<\/th>/g)].map((match) => cellText(match[1]));

  return rows.map((row) => {
    const cells = [...row.matchAll(/<td[^>]*>([\s\S]*?)<\/td>/g)].map((match) => match[1]);
    const text = {};
    const raw = {};

    headings.forEach((heading, index) => {
      if (heading in text || cells[index] === undefined) {
        return;
      }

      text[heading] = cellText(cells[index]);
      raw[heading] = cells[index];
    });

    return withRaw ? { cells: text, raw } : text;
  });
}

function cellText(html) {
  return decodeEntities(html.replace(/<[^>]*>/g, ' ')).replace(/\s+/g, ' ').trim();
}

function decodeEntities(text) {
  return text
    .replace(/&nbsp;/g, ' ')
    .replace(/&auml;/g, 'ä').replace(/&ouml;/g, 'ö').replace(/&uuml;/g, 'ü')
    .replace(/&Auml;/g, 'Ä').replace(/&Ouml;/g, 'Ö').replace(/&Uuml;/g, 'Ü')
    .replace(/&szlig;/g, 'ß')
    .replace(/&quot;/g, '"').replace(/&#39;/g, "'")
    .replace(/&amp;/g, '&');
}

function toNumber(value) {
  const number = Number.parseInt(value, 10);

  return Number.isNaN(number) ? null : number;
}

// nuLiga gives German local time. The offset follows the EU rule: summer time
// from the last Sunday in March to the last Sunday in October, 01:00 UTC.
function toBerlinIso(date, time) {
  const [day, month, year] = date.split('.').map(Number);
  const [hour, minute] = time.split(':').map(Number);
  const summerStart = lastSundayUtc(year, 2);
  const summerEnd = lastSundayUtc(year, 9);
  const asWinterTime = Date.UTC(year, month - 1, day, hour - 1, minute);
  const offset = asWinterTime >= summerStart && asWinterTime < summerEnd ? 2 : 1;
  const pad = (value) => String(value).padStart(2, '0');

  return `${year}-${pad(month)}-${pad(day)}T${pad(hour)}:${pad(minute)}:00+0${offset}:00`;
}

function lastSundayUtc(year, monthIndex) {
  const date = new Date(Date.UTC(year, monthIndex + 1, 0, 1));
  date.setUTCDate(date.getUTCDate() - date.getUTCDay());

  return date.getTime();
}
