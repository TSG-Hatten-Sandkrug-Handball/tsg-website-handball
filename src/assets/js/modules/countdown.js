const SECOND = 1000;
const MINUTE = 60 * SECOND;
const HOUR = 60 * MINUTE;
const DAY = 24 * HOUR;

// Counts down to kick-off. The digits are aria-hidden; screen readers get the
// static kick-off date instead of a value that changes every second (BF-07).
// Switching to the next match after kick-off is done by upcoming.js.
export function initCountdowns() {
  document.querySelectorAll('[data-countdown]').forEach((countdown) => {
    const target = Date.parse(countdown.dataset.target);

    if (Number.isNaN(target)) {
      return;
    }

    const fields = {
      days: countdown.querySelector('[data-unit="days"]'),
      hours: countdown.querySelector('[data-unit="hours"]'),
      minutes: countdown.querySelector('[data-unit="minutes"]'),
      seconds: countdown.querySelector('[data-unit="seconds"]'),
    };

    const render = () => {
      const remaining = Math.max(0, target - Date.now());

      fields.days.textContent = String(Math.floor(remaining / DAY));
      fields.hours.textContent = pad(Math.floor((remaining % DAY) / HOUR));
      fields.minutes.textContent = pad(Math.floor((remaining % HOUR) / MINUTE));
      fields.seconds.textContent = pad(Math.floor((remaining % MINUTE) / SECOND));

      if (remaining === 0) {
        clearInterval(timer);
      }
    };

    const timer = window.setInterval(render, SECOND);
    render();
  });
}

function pad(value) {
  return String(value).padStart(2, '0');
}
