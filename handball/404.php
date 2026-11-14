<?php
// Shown for unknown addresses (ErrorDocument in .htaccess) and unknown
// articles or teams (render_not_found()).
if (!defined('APP_ROOT')) {
    require __DIR__ . '/includes/bootstrap.php';
}

http_response_code(404);

$page = [
    'title' => 'Seite nicht gefunden | TSG Handball Hatten-Sandkrug',
    'description' => 'Diese Seite gibt es nicht mehr oder noch nicht. Von der Übersicht aus findest du alle Bereiche der Handballabteilung.',
    'path' => '404.php',
    'nav' => null,
    'noindex' => true,
];

require INCLUDES_DIR . '/layout/start.php';
?>
<section class="section">
    <div class="container stack">
        <p class="kicker">Fehler 404</p>
        <h1>Diese Seite gibt es nicht</h1>
        <p class="page-hero__intro">Vielleicht wurde sie verschoben, als die Handballseiten neu aufgebaut wurden. Von der Übersicht aus findest du alle Bereiche.</p>
        <div class="button-row">
            <?= button('Zur Übersicht', url(), 'primary') ?>
            <?= button('Mannschaften', url('mannschaften/'), 'secondary') ?>
            <?= button('Kontakt', url('kontakt/'), 'secondary') ?>
        </div>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
