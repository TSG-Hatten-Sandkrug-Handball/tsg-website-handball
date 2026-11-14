<?php
// Kids-Cup (Lastenheft KC-01 to KC-04). Leave a date null while it is not
// confirmed: the page then says "wird noch bekanntgegeben" instead of
// publishing a placeholder value (CM-07).

return [
    'next_year' => 2027,
    'date' => null,
    'registration_deadline' => null,
    'contact' => 'sven-stein',
    'schedule' => [
        ['group' => 'Minis und Maxis', 'time' => 'Samstag, 11–13 Uhr'],
        ['group' => 'E- und D-Jugend', 'time' => 'Samstag, 10–17 Uhr'],
        ['group' => 'C- und B-Jugend', 'time' => 'Sonntag, 9–16 Uhr'],
    ],
    'fees' => [
        ['label' => 'Meldegeld', 'amount' => 35],
        ['label' => 'Teilnahmekaution', 'amount' => 20],
        ['label' => 'Schiedsrichterkaution', 'amount' => 25],
    ],
];
