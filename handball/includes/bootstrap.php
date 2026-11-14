<?php
declare(strict_types=1);

define('APP_ROOT', dirname(__DIR__));
define('INCLUDES_DIR', __DIR__);
define('DATA_DIR', APP_ROOT . '/data');

require INCLUDES_DIR . '/config.php';

date_default_timezone_set(TIMEZONE);

require INCLUDES_DIR . '/helpers.php';
require INCLUDES_DIR . '/dates.php';
require INCLUDES_DIR . '/repository.php';
require INCLUDES_DIR . '/schema.php';
