import { initMobileMenu } from './modules/mobile-menu.js';
import { initCountdowns } from './modules/countdown.js';
import { initUpcoming } from './modules/upcoming.js';
import { initOrgPanel } from './modules/org-panel.js';

document.documentElement.classList.add('js');

initMobileMenu();
initCountdowns();
initUpcoming();
initOrgPanel();
