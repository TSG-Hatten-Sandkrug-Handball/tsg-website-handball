<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

$page = [
    'title' => 'Kontakt und Ansprechpartner | TSG Handball Hatten-Sandkrug',
    'description' => 'Ansprechpartner der Handballabteilung der TSG Hatten-Sandkrug: Abteilungsleitung, Spielwartin, Kasse, Schiedsrichter, Förderkreis und Tickets, dazu die allgemeine Abteilungsadresse.',
    'path' => 'kontakt/',
    'nav' => 'contact',
    'breadcrumbs' => [['Kontakt', 'kontakt/']],
];

require INCLUDES_DIR . '/layout/start.php';

partial('page-hero', ['page' => $page, 'hero' => [
    'title' => 'Ansprechpartner der Abteilung',
    'intro' => 'Allgemeine Fragen gehen an die Abteilungsadresse. Für Trainingsfragen steht das Trainerteam bei den Mannschaften.',
    'aside' => '<a class="button button--primary" href="' . href(mailto(DEPARTMENT_EMAIL)) . '">' . obfuscate(DEPARTMENT_EMAIL) . '</a>',
]]);
?>
<section class="section" aria-labelledby="contacts-title">
    <div class="container">
        <h2 class="visually-hidden" id="contacts-title">Ansprechpartner</h2>
        <ul class="grid grid--4" role="list">
<?php foreach (data('contacts') as $contact):
    $person = isset($contact['person']) ? person($contact['person']) : ['name' => $contact['title'], 'email' => null];
?>
            <li><?php partial('person-card', [
                'person' => $person,
                'function' => $contact['function'],
                'email' => $contact['email'] ?? null,
                'variant' => 'display',
            ]); ?></li>
<?php endforeach; ?>
        </ul>
    </div>
</section>
<section class="section section--surface" aria-labelledby="office-title">
    <div class="container stack">
        <h2 class="section-title-sm" id="office-title">Geschäftsstelle der TSG</h2>
        <p class="muted">An der Schultredde in Hatten. Öffnungszeiten und Telefon stehen auf der Vereinsseite.</p>
        <p><a class="text-link" href="<?= e(link_url('club_contact')) ?>" <?= external_attributes() ?>>Zur Kontaktseite des Vereins<span class="visually-hidden"> (öffnet in neuem Tab)</span></a></p>
    </div>
</section>
<?php
require INCLUDES_DIR . '/layout/end.php';
