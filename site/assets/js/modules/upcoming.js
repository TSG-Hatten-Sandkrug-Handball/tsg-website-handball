const RECHECK_INTERVAL = 60 * 1000;

// Pages are generated ahead of time, so a list can contain matches or events
// that have passed since the build. Lists marked with data-upcoming show only
// items whose data-end (or data-start) lies in the future, at most data-limit.
// Without JavaScript the state of the last build stays visible.
export function initUpcoming() {
  const lists = document.querySelectorAll('[data-upcoming]');

  if (lists.length === 0) {
    return;
  }

  const update = () => lists.forEach(updateList);

  update();
  window.setInterval(update, RECHECK_INTERVAL);
}

function updateList(list) {
  const limit = Number(list.dataset.limit) || Infinity;
  const now = Date.now();
  let shown = 0;

  list.querySelectorAll('[data-start]').forEach((item) => {
    const end = Date.parse(item.dataset.end || item.dataset.start);
    const visible = end > now && shown < limit;

    item.hidden = !visible;
    shown += visible ? 1 : 0;
  });

  const empty = list.querySelector('[data-upcoming-empty]');

  if (empty) {
    empty.hidden = shown > 0;
  }
}
