<?php
// Förderkreis TSG 2000 (Lastenheft FK-01 to FK-04).

return [
    'email' => SUPPORT_CLUB_EMAIL,
    'options' => [
        ['title' => 'Mitglied werden', 'amount' => '24 €', 'note' => 'im Jahr'],
        ['title' => 'Feld pachten', 'amount' => '25 €', 'note' => 'je Feld und Jahr'],
        ['title' => 'Spenden', 'amount' => 'jeder Betrag', 'note' => 'geht an den Jugendhandball'],
    ],
    'funding' => [
        'Trikots für die Jugend',
        'Zuschüsse für Jugendfreizeiten',
        'Unterstützung bei Turnieren',
        'Förderung des Jugendtrainings',
        'Hilfe bei Rehamaßnahmen',
    ],
    'application_steps' => [
        'Welche Mannschaft, wie viele Personen',
        'Was gefördert werden soll',
        'Gesamtkosten und gewünschter Zuschuss',
        'Wann die Maßnahme stattfindet',
    ],
    'board' => [
        ['michael-rackemann', '1. Vorsitzender'],
        ['robert-langner', 'Stellv. Vorsitzender'],
        // TO CONFIRM (Lastenheft open item 2): the old overview page names Jan-Peter Steffens.
        ['erik-stubbemann', 'Schatzmeister'],
    ],
];
