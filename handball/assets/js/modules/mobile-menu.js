import { asButton } from './link-button.js';

const DESKTOP_QUERY = '(min-width: 43.75em)';

// Opens the full-screen menu as a modal dialog: focus stays inside,
// Escape closes it and focus returns to the menu button (Lastenheft M-04).
export function initMobileMenu() {
  const menu = document.querySelector('[data-mobile-menu]');
  const openLink = document.querySelector('[data-menu-open]');
  const closeLink = menu?.querySelector('[data-menu-close]');

  if (!menu || !openLink || !closeLink || typeof menu.showModal !== 'function') {
    return;
  }

  asButton(openLink, () => {
    menu.showModal();
    openLink.setAttribute('aria-expanded', 'true');
  });

  asButton(closeLink, () => menu.close());

  menu.addEventListener('close', () => {
    openLink.setAttribute('aria-expanded', 'false');
    openLink.focus();
  });

  window.matchMedia(DESKTOP_QUERY).addEventListener('change', (event) => {
    if (event.matches && menu.open) {
      menu.close();
    }
  });

  openLink.setAttribute('aria-expanded', 'false');
}
