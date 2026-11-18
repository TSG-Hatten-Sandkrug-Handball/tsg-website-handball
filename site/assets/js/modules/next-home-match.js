import { loadTeamData, upcomingFixtures } from './team-data.js';
import { formatLongDate, formatTime } from './date-format.js';
import { startCountdown } from './countdown.js';
import { escapeHtml } from './escape-html.js';

// Fills the home page stage with the next home match from the imported team
// data. Without data (no JavaScript, failed request, summer break) the
// "next home match follows" note stays visible.
export function initNextHomeMatch() {
  document.querySelectorAll('[data-next-home-match]').forEach(async (stage) => {
    try {
      const data = await loadTeamData(stage.dataset.nextHomeMatch);
      const match = upcomingFixtures(data).find((fixture) => fixture.isHome);

      if (match) {
        renderMatch(stage, match, crestUrl(stage, data, match.away));
      }
    } catch {
      // The fallback note is already visible.
    }
  });
}

// Crest paths in the data are relative to the site root, which is two levels
// above data/teams/.
function crestUrl(stage, data, team) {
  const path = data.crests?.[team];

  return path ? new URL(`../../${path}`, new URL(stage.dataset.nextHomeMatch, document.baseURI)).href : null;
}

function renderMatch(stage, match, crest) {
  const kickOff = match.timeKnown
    ? `${formatLongDate(match.start)} · ${formatTime(match.start)}`
    : formatLongDate(match.start);
  const countdown = stage.querySelector('[data-match-countdown]');

  stage.querySelector('[data-match-league]').textContent = match.league;
  // Long club names like "Grüppenbühren/Bookholzberg" may wrap after the slash.
  stage.querySelector('[data-match-guest]').innerHTML = escapeHtml(match.away).replace(/\//g, '/<wbr>');
  stage.querySelector('[data-match-time]').textContent = kickOff;
  stage.querySelector('[data-match-time]').dateTime = match.start;
  stage.querySelector('[data-match-venue]').textContent = match.venue ? ` · ${match.venue}` : '';
  stage.querySelector('[data-match-kickoff-text]').textContent = `Anwurf am ${kickOff}.`;

  if (crest) {
    const image = stage.querySelector('[data-match-guest-crest]');
    image.src = crest;
    image.closest('.match-stage__crest').classList.add('match-stage__crest--logo');
  }

  countdown.dataset.target = match.start;
  startCountdown(countdown);

  stage.querySelector('[data-match]').hidden = false;
  stage.querySelector('[data-match-empty]').hidden = true;
}
