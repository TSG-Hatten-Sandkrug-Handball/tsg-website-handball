<?php
// Contact cards on /kontakt (Lastenheft KO-01). Either a person key with a
// function, or a role without a person ('title'). 'email' overrides the
// person's address, e.g. for shared mailboxes.

return [
    ['person' => 'silas-linnemann', 'function' => 'Abteilungsleiter, Jugendkoordinator'],
    ['person' => 'frank-schwarzer', 'function' => 'Stellv. Abteilungsleiter, Marketing und Sponsoring, Teammanager 1. Herren'],
    ['person' => 'bettina-stubbemann', 'function' => 'Spielwartin'],
    ['person' => 'boris-bruns', 'function' => 'Kassenwart'],
    ['person' => 'norman-gil', 'function' => 'Schiedsrichterwart'],
    ['person' => 'sven-stein', 'function' => 'Schiedsrichterobmann Jugend, Kids-Cup'],
    ['person' => 'michael-rackemann', 'function' => 'Vorsitzender Förderkreis', 'email' => SUPPORT_CLUB_EMAIL],
    ['title' => 'Tickets', 'function' => 'Dauerkarten und Fragen zum Heimspiel', 'email' => TICKET_EMAIL],
];
