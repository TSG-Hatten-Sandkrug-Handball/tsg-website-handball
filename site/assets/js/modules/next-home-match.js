import { loadTeamData, upcomingFixtures } from './team-data.js';
import { formatLongDate, formatTime } from './date-format.js';
import { startCountdown } from './countdown.js';

// Fills the home page stage with the next home match from the imported team
// data. Without data (no JavaScript, failed request, summer break) the
// "next home match follows" note stays visible.
export function initNextHomeMatch() {
  document.querySelectorAll('[data-next-home-match]').forEach(async (stage) => {
    try {
      const data = await loadTeamData(stage.dataset.nextHomeMatch);
      const match = upcomingFixtures(data).find((fixture) => fixture.isHome);

      if (match) {
        renderMatch(stage, match);
      }
    } catch {
      // The fallback note is already visible.
    }
  });
}

function renderMatch(stage, match) {
  const kickOff = match.timeKnown
    ? `${formatLongDate(match.start)} · ${formatTime(match.start)}`
    : formatLongDate(match.start);
  const countdown = stage.querySelector('[data-match-countdown]');

  stage.querySelector('[data-match-league]').textContent = match.league;
  stage.querySelector('[data-match-guest]').textContent = match.away;
  stage.querySelector('[data-match-time]').textContent = kickOff;
  stage.querySelector('[data-match-time]').dateTime = match.start;
  stage.querySelector('[data-match-venue]').textContent = match.venue ?? '';
  stage.querySelector('[data-match-kickoff-text]').textContent = `Anwurf am ${kickOff}.`;

  countdown.dataset.target = match.start;
  startCountdown(countdown);

  stage.querySelector('[data-match]').hidden = false;
  stage.querySelector('[data-match-empty]').hidden = true;
}
