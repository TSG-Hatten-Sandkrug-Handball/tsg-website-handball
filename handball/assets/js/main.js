import { initMobileMenu } from './modules/mobile-menu.js';
import { initCountdowns } from './modules/countdown.js';
import { initOrgPanel } from './modules/org-panel.js';

document.documentElement.classList.add('js');

initMobileMenu();
initCountdowns();
initOrgPanel();
