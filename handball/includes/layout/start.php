<?php
/**
 * Opens a page. Each page defines $page before including this file:
 *   title, description, path (relative to /handball/, e.g. 'neuigkeiten/'),
 *   nav (key of the main navigation item to highlight), breadcrumbs (optional,
 *   [[label, path], ...] without the root), schema (optional JSON-LD objects).
 *
 * @var array $page
 */
require INCLUDES_DIR . '/layout/head.php';
?>
<body>
<?php require INCLUDES_DIR . '/layout/header.php'; ?>
<main id="main" tabindex="-1">
