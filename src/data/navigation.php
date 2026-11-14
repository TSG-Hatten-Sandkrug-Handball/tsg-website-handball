<?php
// 'main' feeds the desktop header (Lastenheft G-03), 'mobile' the full-screen menu (M-02).

return [
    'main' => [
        ['key' => 'news', 'label' => 'Neuigkeiten', 'path' => 'neuigkeiten/'],
        ['key' => 'teams', 'label' => 'Mannschaften', 'path' => 'mannschaften/'],
        ['key' => 'first-team', 'label' => '1. Herren', 'path' => '1-herren/'],
        ['key' => 'home-games', 'label' => 'Heimspiele', 'path' => 'heimspiele/'],
        ['key' => 'kids-cup', 'label' => 'Kids-Cup', 'path' => 'kids-cup/'],
        ['key' => 'support-club', 'label' => 'Förderkreis', 'path' => 'foerderkreis/'],
        ['key' => 'department', 'label' => 'Abteilung', 'path' => 'abteilung/'],
        ['key' => 'service', 'label' => 'Service', 'path' => 'service/'],
        ['key' => 'contact', 'label' => 'Kontakt', 'path' => 'kontakt/'],
    ],
    'mobile' => [
        ['label' => 'Übersicht', 'path' => ''],
        ['label' => 'Neuigkeiten', 'path' => 'neuigkeiten/'],
        ['label' => 'Termine', 'path' => 'termine/'],
        ['label' => 'Mannschaften', 'path' => 'mannschaften/'],
        ['label' => '1. Herren', 'path' => '1-herren/'],
        ['label' => 'Heimspiele', 'path' => 'heimspiele/'],
        ['label' => 'Kids-Cup', 'path' => 'kids-cup/'],
        ['label' => 'Förderkreis', 'path' => 'foerderkreis/'],
        ['label' => 'Abteilung', 'path' => 'abteilung/'],
        ['label' => 'Service', 'path' => 'service/'],
        ['label' => 'Kontakt', 'path' => 'kontakt/'],
    ],
    'footer_sitemap' => [
        [
            ['label' => 'Neuigkeiten', 'path' => 'neuigkeiten/'],
            ['label' => 'Termine', 'path' => 'termine/'],
            ['label' => 'Mannschaften', 'path' => 'mannschaften/'],
            ['label' => '1. Herren', 'path' => '1-herren/'],
            ['label' => 'Heimspiele', 'path' => 'heimspiele/'],
        ],
        [
            ['label' => 'Abteilung', 'path' => 'abteilung/'],
            ['label' => 'Übungsleiter', 'path' => 'uebungsleiter/'],
            ['label' => 'Schiedsrichter', 'path' => 'schiedsrichter/'],
            ['label' => 'Förderkreis', 'path' => 'foerderkreis/'],
            ['label' => 'Mitmachen', 'path' => 'mitmachen/'],
        ],
    ],
];
