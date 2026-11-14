<?php
// Organisation chart on /abteilung (Lastenheft OG-01 to OG-10).
// 'slug' is the URL anchor (/handball/abteilung#finanzen). People are keys
// from data/people.php with their function in this area; a person can sit in
// several areas and is still maintained only once.
//
// TO CONFIRM (Lastenheft open item 3): the people in the areas below were
// derived from their known functions (e.g. Kassenwart -> Finanzen). The design
// shows more members for Organisation and Sportliches than are known.

return [
    'leadership' => [
        'slug' => 'abteilungsleitung',
        'icon' => 'crown',
        'title' => 'Abteilungsleitung',
        'summary' => 'Leitet die Handballabteilung und ist erste Anlaufstelle',
        'team_name' => 'Die Abteilungsleitung',
        'intro' => 'Die Abteilungsleitung führt die Handballabteilung, vertritt sie im Gesamtverein und ist erste Anlaufstelle für alle Fragen rund um den Handball in Hatten.',
        'tasks' => [
            ['title' => 'Leitung der Abteilung', 'description' => 'Ziele setzen, Bereiche koordinieren, Entscheidungen vorbereiten.'],
            ['title' => 'Vertretung im Gesamtverein', 'description' => null],
            ['title' => 'Erste Anlaufstelle', 'description' => 'Für Mitglieder, Eltern, Partner und Presse.'],
        ],
        'people' => [
            ['silas-linnemann', 'Abteilungsleiter'],
            ['frank-schwarzer', 'Stellv. Abteilungsleiter'],
        ],
    ],
    'areas' => [
        [
            'slug' => 'organisation',
            'icon' => 'layers',
            'title' => 'Organisation',
            'keywords' => 'E-Mail, Saisonmappen, Trainingsmaterialien, Trikots',
            'team_name' => 'Team Organisation',
            'intro' => 'Sorgt dafür, dass im Hintergrund alles läuft: von der Post über die Saisonmappen bis zu Material und Trikots.',
            'tasks' => [
                ['title' => 'E-Mail und Post der Abteilung', 'description' => null],
                ['title' => 'Saisonmappen', 'description' => 'Unterlagen für Trainerinnen und Trainer zum Saisonstart.'],
                ['title' => 'Trainingsmaterialien', 'description' => null],
                ['title' => 'Trikots und Ausstattung', 'description' => null],
            ],
            'people' => [],
        ],
        [
            'slug' => 'finanzen',
            'icon' => 'coins',
            'title' => 'Finanzen',
            'keywords' => 'Budget, Abrechnung, Fördermittel',
            'team_name' => 'Team Finanzen',
            'intro' => 'Behält Einnahmen und Ausgaben der Abteilung im Blick und kümmert sich um Abrechnungen und Fördermittel.',
            'tasks' => [
                ['title' => 'Budget der Abteilung', 'description' => null],
                ['title' => 'Abrechnungen', 'description' => 'Übungsleiter-, Fahrt- und Schiedsrichterkosten.'],
                ['title' => 'Fördermittel', 'description' => null],
            ],
            'people' => [['boris-bruns', 'Kassenwart']],
        ],
        [
            'slug' => 'begeisterung-handball',
            'icon' => 'users',
            'title' => 'Begeisterung Handball',
            'keywords' => 'Nachwuchsgewinnung, Mitgliederentwicklung',
            'team_name' => 'Team Begeisterung Handball',
            'intro' => 'Bringt Kinder und Jugendliche zum Handball und sorgt dafür, dass sie dabei bleiben.',
            'tasks' => [
                ['title' => 'Nachwuchsgewinnung', 'description' => 'Aktionen in Kitas und Schulen, Probetrainings, Minispielfeste.'],
                ['title' => 'Mitgliederentwicklung', 'description' => null],
            ],
            'people' => [['silas-linnemann', 'Jugendkoordinator']],
        ],
        [
            'slug' => 'sportliches',
            'icon' => 'whistle',
            'title' => 'Sportliches',
            'keywords' => 'Spielbetrieb, Spielansetzung, Passwesen, Schiedsrichter',
            'team_name' => 'Team Sportliches',
            'intro' => 'Organisiert den Spielbetrieb aller Mannschaften, von der Ansetzung bis zum Schiedsrichter.',
            'tasks' => [
                ['title' => 'Spielbetrieb und Spielansetzung', 'description' => null],
                ['title' => 'Passwesen', 'description' => 'Spielberechtigungen und Gastspielrechte.'],
                ['title' => 'Schiedsrichterwesen', 'description' => null],
            ],
            'people' => [
                ['bettina-stubbemann', 'Spielwartin'],
                ['norman-gil', 'Schiedsrichterwart'],
                ['sven-stein', 'Schiedsrichterobmann Jugend'],
            ],
        ],
        [
            'slug' => 'kommunikation',
            'icon' => 'megaphone',
            'title' => 'Kommunikation / Medien / Presse',
            'keywords' => 'Öffentlichkeitsarbeit, Social Media, Presse',
            'team_name' => 'Team Kommunikation',
            'intro' => 'Erzählt, was in der Abteilung passiert: auf der Website, in den sozialen Medien und in der Presse.',
            'tasks' => [
                ['title' => 'Öffentlichkeitsarbeit', 'description' => null],
                ['title' => 'Social Media', 'description' => null],
                ['title' => 'Pressearbeit', 'description' => null],
            ],
            'people' => [['frank-schwarzer', 'Marketing und Sponsoring']],
        ],
        [
            'slug' => 'begeisterung-tsg',
            'icon' => 'heart',
            'title' => 'Begeisterung TSG',
            'keywords' => 'Vereinsleben stärken, Identifikation fördern',
            'team_name' => 'Team Begeisterung TSG',
            'intro' => 'Stärkt das Vereinsleben und das Wir-Gefühl in der Abteilung.',
            'tasks' => [
                ['title' => 'Vereinsleben stärken', 'description' => null],
                ['title' => 'Identifikation fördern', 'description' => null],
            ],
            'people' => [],
        ],
        [
            'slug' => 'soziales-engagement',
            'icon' => 'handshake',
            'title' => 'Soziales Engagement',
            'keywords' => 'Projekte, gesellschaftliches Engagement',
            'team_name' => 'Team Soziales Engagement',
            'intro' => 'Kümmert sich um Projekte, mit denen die Abteilung etwas für die Gemeinschaft tut.',
            'tasks' => [
                ['title' => 'Soziale Projekte', 'description' => null],
                ['title' => 'Gesellschaftliches Engagement', 'description' => null],
            ],
            'people' => [],
        ],
        [
            'slug' => 'vertrauensrat',
            'icon' => 'shield',
            'title' => 'Vertrauensrat',
            'keywords' => 'Ansprechpartner bei Konflikten, Vertrauensarbeit',
            'team_name' => 'Der Vertrauensrat',
            'intro' => 'Ist vertraulich ansprechbar, wenn es Konflikte oder Sorgen gibt.',
            'tasks' => [
                ['title' => 'Ansprechpartner bei Konflikten', 'description' => null],
                ['title' => 'Vertrauensarbeit', 'description' => null],
            ],
            'people' => [],
        ],
        [
            'slug' => 'innovationsteam',
            'icon' => 'lightbulb',
            'title' => 'Innovationsteam',
            'keywords' => 'Weiterentwicklung, neue Ideen, Projekte',
            'team_name' => 'Das Innovationsteam',
            'intro' => 'Entwickelt die Abteilung weiter und probiert neue Ideen aus.',
            'tasks' => [
                ['title' => 'Weiterentwicklung der Abteilung', 'description' => null],
                ['title' => 'Neue Ideen und Projekte', 'description' => null],
            ],
            'people' => [],
        ],
    ],
];
