import { asButton } from './link-button.js';

// Side panel for the organisation chart (Lastenheft OG-04 to OG-09).
// The detail blocks are server-rendered below the chart; this module moves
// them into a modal <dialog> and shows one area or person at a time.
export function initOrgPanel() {
  const panel = document.querySelector('[data-org-panel]');
  const details = document.querySelector('[data-org-details]');

  if (!panel || !details || typeof panel.showModal !== 'function') {
    return;
  }

  const content = panel.querySelector('[data-org-panel-content]');
  const views = new Map();
  let opener = null;
  let currentUnit = null;

  details.querySelectorAll('[data-org-view]').forEach((view) => {
    view.hidden = true;
    content.append(view);
    views.set(view.dataset.orgView, view);
  });
  details.remove();

  const show = (id) => {
    const view = views.get(id);

    if (!view) {
      return false;
    }

    views.forEach((other) => {
      other.hidden = other !== view;
    });

    if (!id.startsWith('person-')) {
      currentUnit = id;
    }

    if (!panel.open) {
      panel.showModal();
    }

    content.scrollTop = 0;
    view.querySelector('[data-org-focus]')?.focus();
    history.replaceState(null, '', `#${id}`);

    return true;
  };

  document.querySelectorAll('[data-org-open]').forEach((link) => {
    asButton(link, () => {
      opener = link;
      show(link.dataset.orgOpen);
    });
  });

  content.querySelectorAll('[data-org-person]').forEach((link) => {
    asButton(link, () => show(link.dataset.orgPerson));
  });

  // "Zur Übersicht" returns to the area the person was opened from.
  content.querySelectorAll('[data-org-back]').forEach((link) => {
    asButton(link, () => show(currentUnit ?? link.dataset.orgBack));
  });

  panel.querySelector('[data-org-close]').addEventListener('click', () => panel.close());

  // A click on the dimmed backdrop lands on the dialog element itself.
  panel.addEventListener('click', (event) => {
    if (event.target === panel) {
      panel.close();
    }
  });

  panel.addEventListener('close', () => {
    history.replaceState(null, '', window.location.pathname + window.location.search);
    opener?.focus();
    opener = null;
  });

  const openFromHash = () => {
    const id = decodeURIComponent(window.location.hash.slice(1));

    if (id && views.has(id)) {
      opener = document.querySelector(`[data-org-open="${CSS.escape(id)}"]`);
      show(id);
    }
  };

  window.addEventListener('hashchange', openFromHash);
  openFromHash();
}
