import { loadTeamData, upcomingFixtures, lastResult, ownGoalDifference } from './team-data.js';
import { formatDayMonth, formatTime, formatDate } from './date-format.js';
import { escapeHtml } from './escape-html.js';

const DEFAULT_LIMIT = 5;

// Fills a [data-team-schedule] section on a team page with the next matches,
// the last result and the standings. Until the data arrives the section shows
// a loading note; if it fails, the note points to the federation's pages,
// which every team page links in its header anyway.
export function initTeamSchedules() {
  document.querySelectorAll('[data-team-schedule]').forEach(async (section) => {
    const status = section.querySelector('[data-team-status]');

    try {
      const data = await loadTeamData(section.dataset.teamSchedule);
      renderSchedule(section, data);
      status.hidden = true;
      section.querySelector('[data-team-content]').hidden = false;
    } catch {
      status.textContent = 'Spielplan und Tabelle konnten gerade nicht geladen werden. Du findest sie über den Link „Spielplan“ oben auf dieser Seite.';
    }
  });
}

function renderSchedule(section, data) {
  const limit = Number(section.dataset.limit) || DEFAULT_LIMIT;
  const fixtures = upcomingFixtures(data).slice(0, limit);
  const last = lastResult(data);

  section.querySelector('[data-team-fixtures]').innerHTML = fixtures.map((fixture) => fixtureItem(fixture, data.team)).join('');
  section.querySelector('[data-team-fixtures-empty]').hidden = fixtures.length > 0;
  section.querySelector('[data-team-tables]').innerHTML = data.leagues
    .filter((league) => league.table.length > 0)
    .map(leagueTable)
    .join('');
  section.querySelector('[data-team-updated]').textContent = `Stand ${formatDate(data.updatedAt)} · Quelle: ${data.source}`;

  const lastResultElement = section.querySelector('[data-team-last-result]');
  lastResultElement.hidden = !last;

  if (last) {
    lastResultElement.innerHTML = lastResultContent(last);
  }
}

function fixtureItem(fixture, ownTeam) {
  const team = (name) => `<span class="${name === ownTeam ? 'fixture__own' : ''}">${escapeHtml(name)}</span>`;
  const time = fixture.timeKnown ? `<span class="fixture__time">${formatTime(fixture.start)}</span>` : '';
  const tag = fixture.isHome
    ? '<span class="tag tag--uppercase">Heim</span>'
    : '<span class="tag tag--uppercase tag--away">Auswärts</span>';

  return `<li><article class="fixture">
    <p class="fixture__date"><time datetime="${fixture.start}"><span class="fixture__day">${formatDayMonth(fixture.start)}</span>${time}</time></p>
    <p class="fixture__teams">${team(fixture.home)}<span class="visually-hidden"> gegen </span>${team(fixture.away)}</p>
    ${tag}
  </article></li>`;
}

function lastResultContent(fixture) {
  const difference = ownGoalDifference(fixture);
  const outcome = difference > 0
    ? '<span class="tag tag--win">Sieg</span>'
    : difference < 0 ? '<span class="tag tag--loss">Niederlage</span>' : '<span class="tag tag--soft">Unentschieden</span>';

  return `<span>Letztes Spiel, ${formatDayMonth(fixture.start)}: ${escapeHtml(fixture.home)} – ${escapeHtml(fixture.away)}</span>
    <span class="last-result__score">${escapeHtml(fixture.score)} ${outcome}</span>`;
}

function leagueTable(league) {
  const rows = league.table.map((standing) => `<tr${standing.own ? ' class="league-table__own"' : ''}>
      <td>${standing.rank ?? ''}</td>
      <th scope="row" class="league-table__team">${escapeHtml(standing.team)}</th>
      <td class="league-table__number">${standing.games ?? ''}</td>
      <td class="league-table__number">${escapeHtml(standing.goalDifference ?? '')}</td>
      <td class="league-table__number">${escapeHtml(standing.points ?? '')}</td>
    </tr>`).join('');

  return `<div>
    <h3 class="label-heading">${escapeHtml(league.name)}</h3>
    <div class="league-table">
      <table>
        <caption class="visually-hidden">Tabelle ${escapeHtml(league.name)}</caption>
        <thead>
          <tr>
            <th scope="col"><abbr title="Platz">#</abbr></th>
            <th scope="col">Mannschaft</th>
            <th scope="col" class="league-table__number"><abbr title="Spiele">Sp.</abbr></th>
            <th scope="col" class="league-table__number"><abbr title="Tordifferenz">+/-</abbr></th>
            <th scope="col" class="league-table__number"><abbr title="Punkte">Pkt.</abbr></th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    </div>
  </div>`;
}
