<?php

/*
|--------------------------------------------------------------------------
| Le Havre de Paix — paramètres de l'établissement
|--------------------------------------------------------------------------
| Coordonnées et calendrier tarifaire (document « Tarifs chambres
| Assinie 2026 »). Les saisons se répètent chaque année (mois-jour).
*/

return [
    'name'    => 'Havre de Paix',
    'tagline' => 'Résidence-Hôtel · Assinie',
    'address' => [
        'street'  => 'Assinie Kilomètre 18,75',
        'city'    => 'Assinie',
        'country' => 'CI',
    ],
    'phone'         => env('HOTEL_PHONE', '+225 07 00 00 00 00'),
    'whatsapp'      => env('HOTEL_WHATSAPP', '2250700000000'),
    'email'         => env('HOTEL_EMAIL', 'contact@havredepaix-assinie.com'),

    /*
    | Haute saison : Décembre – Mars et Juillet – Août (mois-jour, bornes incluses).
    | Tout le reste de l'année est en basse saison.
    */
    'high_season_ranges' => [
        ['12-01', '03-31'], // chevauche le passage d'année
        ['07-01', '08-31'],
    ],

    /*
    | Nuits « week-end » : vendredi (5) et samedi (6) — ISO-8601.
    | Elles utilisent les tarifs week-end de la chambre (+10 % environ).
    */
    'weekend_nights' => [5, 6],

    'check_in_time'  => '13:00',
    'check_out_time' => '12:00',
];
