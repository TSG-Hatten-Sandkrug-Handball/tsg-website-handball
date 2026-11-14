<?php
// Generated as 404.html. GitHub Pages serves it automatically, on Strato the
// .htaccess points ErrorDocument 404 to it.
$page = [
    'title' => 'Seite nicht gefunden | TSG Handball Hatten-Sandkrug',
    'description' => 'Diese Seite gibt es nicht mehr oder noch nicht. Von der Übersicht aus findest du alle Bereiche der Handballabteilung.',
    'path' => '404.html',
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
