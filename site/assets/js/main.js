import { initMobileMenu } from './modules/mobile-menu.js';
import { initCountdowns } from './modules/countdown.js';
import { initUpcoming } from './modules/upcoming.js';
import { initOrgPanel } from './modules/org-panel.js';
import { initVideos } from './modules/video.js';
import { initTeamSchedules } from './modules/team-schedule.js';
import { initNextHomeMatch } from './modules/next-home-match.js';
import { initRouteLinks } from './modules/route-links.js';

document.documentElement.classList.add('js');

initMobileMenu();
initCountdowns();
initUpcoming();
initOrgPanel();
initVideos();
initTeamSchedules();
initNextHomeMatch();
initRouteLinks();
