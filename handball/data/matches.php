<?php
// Schedule, results and table of the 1. Herren, maintained by hand until the
// automatic nuLiga import exists (Lastenheft CM-04 / CM-05).
// The next home match on the overview page is derived from 'fixtures' (CM-06).

return [
    'team' => '1-herren',
    'own_name' => 'TSG Hatten-Sandkrug',
    'own_short_name' => 'TSG',
    'updated' => '2026-11-11',
    'source' => 'nuLiga',
    // Photo for the match-day stage on the overview page, e.g. 'assets/img/first-team-action.webp'.
    'stage_photo' => null,
    'fixtures' => [
        ['kickoff' => '2026-11-14 19:30', 'home' => true, 'opponent' => 'HC Bremen', 'venue' => 'Sportzentrum Sandkrug'],
        ['kickoff' => '2026-11-21 18:00', 'home' => false, 'opponent' => 'TSV Bremervörde', 'venue' => null],
        ['kickoff' => '2026-12-05 19:30', 'home' => true, 'opponent' => 'Wilhelmshavener HV II', 'venue' => 'Sportzentrum Sandkrug'],
        ['kickoff' => '2026-12-12 19:00', 'home' => false, 'opponent' => 'HSG Grüppenbühren/Bookholzberg', 'venue' => null],
    ],
    'results' => [
        ['date' => '2026-11-07', 'home' => false, 'opponent' => 'SG Achim/Baden', 'opponent_short' => 'SG Achim/Baden', 'goals_for' => 27, 'goals_against' => 29],
    ],
    'table' => [
        ['team' => 'SG Achim/Baden', 'played' => 9, 'diff' => 71, 'points' => '18:0'],
        ['team' => 'TV Dinklage', 'played' => 9, 'diff' => 29, 'points' => '14:4'],
        ['team' => 'HC Bremen', 'played' => 9, 'diff' => 54, 'points' => '13:5'],
        ['team' => 'TV Neerstedt', 'played' => 9, 'diff' => 31, 'points' => '12:6'],
        ['team' => 'SG Bremen-Ost', 'played' => 9, 'diff' => 26, 'points' => '11:7'],
        ['team' => 'TSV Bremervörde', 'played' => 9, 'diff' => -4, 'points' => '10:8'],
        ['team' => 'TuS Rotenburg', 'played' => 9, 'diff' => -10, 'points' => '10:8'],
        ['team' => 'TV Oyten', 'played' => 9, 'diff' => 7, 'points' => '9:9'],
        ['team' => 'TV Schiffdorf', 'played' => 9, 'diff' => -16, 'points' => '9:9'],
        ['team' => 'VfL Fredenbeck II', 'played' => 9, 'diff' => -6, 'points' => '8:10'],
        ['team' => 'HSG Grüppenbühren/Bookholzberg', 'played' => 9, 'diff' => -40, 'points' => '4:14'],
        ['team' => 'TSG Hatten-Sandkrug', 'played' => 9, 'diff' => -38, 'points' => '3:15'],
        ['team' => 'HSG Delmenhorst', 'played' => 9, 'diff' => -45, 'points' => '3:15'],
        ['team' => 'Wilhelmshavener HV II', 'played' => 9, 'diff' => -59, 'points' => '2:16'],
    ],
];
