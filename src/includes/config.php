<?php
// Site-wide settings. Change values here, never inside templates.

// Where the generated site is published. build.php can override these per
// target (--origin, --base, --noindex), e.g. for the GitHub Pages preview.
// TO CONFIRM: the final subdomain is not decided yet.
defined('SITE_ORIGIN') || define('SITE_ORIGIN', 'https://handball.tsg-hatten-sandkrug.de');
defined('BASE_PATH') || define('BASE_PATH', '');
defined('SITE_NOINDEX') || define('SITE_NOINDEX', false);

const SITE_LANG = 'de';
const SITE_LOCALE = 'de_DE';
const SITE_NAME = 'TSG Handball';
const CLUB_NAME = 'TSG Hatten-Sandkrug e.V.';
const CLUB_ORIGIN = 'https://www.tsg-hatten-sandkrug.de';
const DEPARTMENT_NAME = 'Handballabteilung der TSG Hatten-Sandkrug e.V.';
const DEPARTMENT_EMAIL = 'handball@tsg-hatten-sandkrug.de';
const TICKET_EMAIL = 'ticket@tsghatten.de';
const SUPPORT_CLUB_EMAIL = 'foerderverein-hb@tsg-hatten-sandkrug.de';
const TIMEZONE = 'Europe/Berlin';
const SEASON_LABEL = '2026/27';
const THEME_COLOR = '#303881';

const NEWS_PER_PAGE = 10;
