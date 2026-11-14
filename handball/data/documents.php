<?php
// Downloads and external forms. Club files keep their existing addresses
// under /fileadmin (Lastenheft R-06). 'size' in bytes is optional (SE-03).
// 'source' is shown instead of the format for external targets.

$fileadmin = '/fileadmin/user_upload/cloudspeicher/';

return [
    'service' => [
        [
            'title' => 'Für Trainer und Kampfgericht',
            'items' => [
                ['label' => 'Quittung Schiedsrichterkosten', 'url' => $fileadmin . 'sportarten/Handball/Service/Quittung-Schiedsrichterkosten.pdf', 'format' => 'PDF', 'size' => 419444],
                ['label' => 'Quittung Schiedsrichterkosten', 'url' => $fileadmin . 'sportarten/Handball/Service/Quittung-Schiedsrichterkosten.xlsx', 'format' => 'XLSX', 'size' => 20947],
                ['label' => 'Fahrtkostenabrechnung', 'url' => $fileadmin . 'sportarten/Handball/Service/Vorlage-Fahrtkostenabrechnung.xlsx', 'format' => 'XLSX', 'size' => 33224],
                ['label' => 'Zeitstrafenvordruck', 'url' => $fileadmin . 'sportarten/Handball/Service/Zeitstrafenvordruck.pdf', 'format' => 'PDF', 'size' => 65780],
                ['label' => 'Mannschaftsliste Minis', 'url' => $fileadmin . 'sportarten/Handball/Service/Vorlage-Musterliste_229-___Minis_Handball__04_2022.xlsx', 'format' => 'XLSX', 'size' => 14018],
                ['label' => 'Übungsleiterabrechnung', 'url' => $fileadmin . 'sportarten/Handball/Service/UEbungsleiterabrechnung.xlsx', 'format' => 'XLSX', 'size' => 17358],
                ['label' => 'Übungsleiterfragebogen', 'url' => $fileadmin . 'verein/Dokumente/UEbungsleiterfragebogen.docx', 'format' => 'DOCX', 'size' => 75022],
            ],
        ],
        [
            'title' => 'Für Spieler und Eltern',
            'items' => [
                ['label' => 'TSG-Mitgliedsantrag', 'url' => 'https://www.tsg-hatten-sandkrug.de/verein/mitgliedschaft/', 'source' => 'Vereinsseite', 'external' => true],
                // The previous HVNB address returns 404; link to the current form once known.
                ['label' => 'Antrag Spielberechtigung', 'url' => 'https://hvnb-online.de/wp-content/uploads/2022/11/Antrag_auf_Erteilung_der_Spielberechtigung_2022_10.pdf', 'source' => 'HVNB', 'format' => 'PDF', 'external' => true],
                ['label' => 'Ärztliche Unbedenklichkeit', 'url' => 'https://hvnb-online.de/wp-content/uploads/2022/09/aerztliche-unbedenklichkeit-2.pdf', 'source' => 'HVNB', 'format' => 'PDF', 'size' => 149718, 'external' => true],
                ['label' => 'Antrag Gastspielrecht', 'url' => 'https://hvnb-online.de/wp-content/uploads/2022/10/Antrag_auf_Gastspielrecht-1.pdf', 'source' => 'HVNB', 'format' => 'PDF', 'size' => 514251, 'external' => true],
                ['label' => 'Spielerliste nuScore', 'url' => 'https://hvnb-online.de/wp-content/uploads/2022/10/Spielerliste_nuscore.pdf', 'source' => 'HVNB', 'format' => 'PDF', 'external' => true],
                ['label' => 'Zeitstrafenvordruck', 'url' => 'https://hvnb-online.de/wp-content/uploads/2022/09/Zeitstrafenvordruck_HVNB_nur_Nummer.pdf', 'source' => 'HVNB', 'format' => 'PDF', 'size' => 419554, 'external' => true],
            ],
        ],
        [
            'title' => 'Abteilung',
            'items' => [
                ['label' => 'Abteilungsordnung vom 14.07.2020', 'url' => $fileadmin . 'sportarten/Handball/2020_07_14_Abteilungsordnung_Handball.pdf', 'format' => 'PDF', 'size' => 323189],
                ['label' => 'Fanshop', 'url' => 'https://teamsportausstatter.de/collections/tsg-hatten-sandkrug', 'source' => 'teamsportausstatter.de', 'external' => true],
                ['label' => 'Beiträge des Vereins', 'url' => 'https://www.tsg-hatten-sandkrug.de/verein/mitgliedschaft/', 'source' => 'Vereinsseite', 'external' => true],
            ],
        ],
    ],
    'department_rules' => ['label' => 'Abteilungsordnung', 'url' => $fileadmin . 'sportarten/Handball/2020_07_14_Abteilungsordnung_Handball.pdf', 'format' => 'PDF', 'size' => 323189],
    'kids_cup' => [
        ['label' => 'Turniereinladung 2026', 'url' => $fileadmin . 'sportarten/Handball/Turnier/2026/Turniereinladung_2026-1.pdf', 'format' => 'PDF', 'size' => 333893],
        ['label' => 'Anmeldung 2026', 'registration_form' => true, 'url' => $fileadmin . 'sportarten/Handball/Turnier/2026/Anmeldung_2026.pdf', 'format' => 'PDF', 'size' => 275626],
        ['label' => 'Turnierbestimmungen', 'url' => $fileadmin . 'sportarten/Handball/Turnier/2026/Turnierbestimmungen_Neuversion.pdf', 'format' => 'PDF', 'size' => 432886],
        ['label' => 'Vollmacht Kautionen', 'url' => $fileadmin . 'sportarten/Handball/Turnier/2025/Vollmacht-Teilnahme-und-Schiedsrichterkaution.pdf', 'format' => 'PDF', 'size' => 102891],
    ],
    'programmes' => [
        [
            'season' => 'Saison 2024/25',
            'items' => [
                ['opponent' => 'Haren', 'date' => '2025-05-10', 'url' => $fileadmin . 'sportarten/Handball/Saison_2024_2025/hallenheft_saison_2024-2025_2025-05-10_haren_web.pdf', 'size' => 1596558],
                ['opponent' => 'Hunte-Aue', 'date' => '2024-11-17', 'url' => $fileadmin . 'sportarten/Handball/Saison_2024_2025/hallenheft_saison_2024-2025_2024-11-17_hunte-aue_web.pdf', 'size' => 1559796],
                ['opponent' => 'Wilhelmshaven', 'date' => '2024-10-26', 'url' => $fileadmin . 'sportarten/Handball/Saison_2024_2025/hallenheft_saison_2024-2025_2024-10-26_wilhelmshaven_web.pdf', 'size' => 1559235],
                ['opponent' => 'Rotenburg', 'date' => '2024-09-25', 'url' => $fileadmin . 'sportarten/Handball/Saison_2024_2025/hallenheft_saison_2024-2025_2024-09-25_rotenburg_web.pdf', 'size' => 1702136],
                ['opponent' => 'Grüppenbühren-Bookholzberg', 'date' => '2024-09-14', 'url' => $fileadmin . 'sportarten/Handball/Saison_2024_2025/hallenheft_saison_2024-2025_2024-09-14_grueppenbuehren-bookholzberg.pdf', 'size' => 1752367],
            ],
        ],
    ],
];
