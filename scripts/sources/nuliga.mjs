// Data source: nuLiga, the HVNB federation's results system. It offers no API
// or feed, only server-rendered HTML, so this file reads the two pages of a
// league ("group"): the standings page and the full schedule.
//
// Every source exports fetchLeague(league) and resolves to the same shape:
//   { name, url, table: [Standing], fixtures: [Fixture] }
//   Standing: { rank, team, games, wins, draws, losses, goals, goalDifference, points }
//   Fixture:  { number, start, timeKnown, venue, home, away, score }
// Optionally it exports fetchCrest(league, team), resolving to
//   { id, data: Uint8Array, extension } or null when the club has no logo.
// To switch to another source, add a file with the same exports and point
// scripts/import-hvnb.mjs at it. Nothing else depends on nuLiga.

const ORIGIN = 'https://hvnb-handball.liga.nu';
const BASE_URL = `${ORIGIN}/cgi-bin/WebObjects/nuLigaHBDE.woa/wa`;
const ATTEMPTS = 3;
const TIMEOUT_MS = 15_000;
const IMAGE_EXTENSIONS = { 'image/jpeg': 'jpg', 'image/png': 'png', 'image/gif': 'gif', 'image/webp': 'webp' };
// One run looks up several crests per league; the standings page is read once.
const standingsPages = new Map();

// Team row in the standings → team portrait → club page, which shows the logo.
// The logo address is only valid for the session of that club page request,
// so the image is fetched right away with the page's cookies.
export async function fetchCrest({ championship, group }, team) {
  const query = `championship=${encodeURIComponent(championship)}&group=${encodeURIComponent(group)}`;
  if (!standingsPages.has(query)) {
    standingsPages.set(query, fetchHtml(`${BASE_URL}/groupPage?${query}`));
  }

  const standingsHtml = await standingsPages.get(query);
  const portraitLink = [...standingsHtml.matchAll(/<a[^>]*href="([^"]*teamPortrait[^"]*)"[^>]*>([\s\S]*?)<\/a>/g)]
    .find((match) => cellText(match[2]) === team)?.[1];

  if (!portraitLink) {
    return null;
  }

  const portraitHtml = await fetchHtml(ORIGIN + decodeEntities(portraitLink));
  const clubId = portraitHtml.match(/clubInfoDisplay\?club=(\d+)/)?.[1];

  if (!clubId) {
    return null;
  }

  for (let attempt = 1; attempt <= ATTEMPTS; attempt += 1) {
    const page = await fetch(`${BASE_URL}/clubInfoDisplay?club=${clubId}`, { signal: AbortSignal.timeout(TIMEOUT_MS) });
    const logoPath = (await page.text()).match(/<img[^>]*src="(\/cgi-bin\/WebObjects\/nuLigaHBDE\.woa\/wr\?wodata=[^"]+)"/)?.[1];

    if (!logoPath) {
      return null;
    }

    const cookie = page.headers.getSetCookie().map((header) => header.split(';')[0]).join('; ');
    const image = await fetch(ORIGIN + decodeEntities(logoPath), {
      headers: cookie ? { cookie } : {},
      signal: AbortSignal.timeout(TIMEOUT_MS),
    });
    const extension = IMAGE_EXTENSIONS[image.headers.get('content-type')];
    const data = new Uint8Array(await image.arrayBuffer());

    if (image.ok && extension && data.length > 0) {
      return { id: clubId, data, extension };
    }
  }

  throw new Error(`logo of club ${clubId} could not be downloaded`);
}

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
