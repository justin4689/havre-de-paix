<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'name'     => 'Admin Havre de Paix',
            'email'    => 'admin@havredepaix-assinie.com',
            'password' => Hash::make('HDP@admin2026'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Réception Havre de Paix',
            'email'    => 'reception@havredepaix-assinie.com',
            'password' => Hash::make('reception2026'),
            'role'     => 'receptionist',
        ]);

        // Équipements communs à toutes les chambres (document Tarifs Assinie 2026 :
        // petit-déjeuner, wifi et climatisation inclus ; piscine commune sans surcoût).
        $inclus = ['Petit-déjeuner inclus', 'WiFi', 'Climatisation', 'Télévision', 'Piscine à débordement (commune)', 'Accès lagune'];

        // Catalogue réel — grille « Le Havre de Paix, Tarifs chambres Assinie 2026 ».
        // Prix : [basse saison, haute saison, week-end BS, week-end HS] (FCFA / nuit).
        $rooms = [
            [
                'slug'   => 'chambre-standard-1',
                'name'   => 'Chambre Standard 1',
                'category' => 'standard',
                'description_short' => 'Une chambre lumineuse et apaisante, literie aux tons verts et jardin à quelques pas.',
                'description_long'  => "<div>La <strong>Chambre Standard</strong> offre tout l'essentiel d'un séjour réussi à Assinie : grand lit confortable, climatisation, télévision et salle d'eau moderne avec douche à l'italienne — à quelques pas de la piscine à débordement et de la lagune.</div><h2>Inclus dans votre séjour</h2><ul><li>Petit-déjeuner servi au pavillon</li><li>WiFi et climatisation</li><li>Accès libre à la piscine commune</li></ul>",
                'capacity_adults' => 2, 'capacity_children' => 0,
                'size_m2' => 20, 'bed_type' => 'double', 'floor' => 0,
                'amenities' => [...$inclus, 'Douche à l\'italienne'],
                'images'    => ['images/rooms/standard-1-1.jpg', 'images/rooms/standard-1-2.jpg', 'images/rooms/standard-1-3.jpg', 'images/rooms/standard-1-4.jpg'],
                'prices'    => [50000, 65000, 55000, 70000],
            ],
            [
                'slug'   => 'chambre-standard-2',
                'name'   => 'Chambre Standard 2',
                'category' => 'standard',
                'description_short' => 'Le confort de la Standard dans une palette bleu lagune, côté jardin.',
                'description_long'  => "<div>Jumelle de la Chambre Standard 1, cette chambre décline les mêmes prestations dans une palette <strong>bleu lagune</strong> : grand lit, dressing, télévision et salle d'eau attenante.</div><h2>Inclus dans votre séjour</h2><ul><li>Petit-déjeuner servi au pavillon</li><li>WiFi et climatisation</li><li>Accès libre à la piscine commune</li></ul>",
                'capacity_adults' => 2, 'capacity_children' => 0,
                'size_m2' => 20, 'bed_type' => 'double', 'floor' => 0,
                'amenities' => [...$inclus, 'Dressing'],
                'images'    => ['images/rooms/standard-2-1.jpg', 'images/rooms/standard-2-2.jpg', 'images/rooms/standard-2-3.jpg', 'images/rooms/standard-2-4.jpg'],
                'prices'    => [50000, 65000, 55000, 70000],
            ],
            [
                'slug'   => 'chambre-premium-1',
                'name'   => 'Chambre Premium 1',
                'category' => 'premium',
                'description_short' => 'Lit king size, textiles wax et salle de bain contemporaine : la Standard en plus spacieux et plus raffiné.',
                'description_long'  => "<div>La <strong>Chambre Premium</strong> monte en gamme : lit king size habillé de tissus wax, espace bureau, et salle de bain contemporaine avec douche à effet pluie. Une valeur sûre pour un week-end à deux au bord de la lagune.</div><h2>Ce qui la distingue</h2><ul><li>Lit king size et literie hôtelière</li><li>Salle de bain moderne, douche à effet pluie</li><li>Espace bureau</li></ul>",
                'capacity_adults' => 2, 'capacity_children' => 0,
                'size_m2' => 24, 'bed_type' => 'king', 'floor' => 0,
                'amenities' => [...$inclus, 'Lit king size', 'Douche à effet pluie', 'Bureau'],
                'images'    => ['images/rooms/premium-1-1.jpg', 'images/rooms/premium-1-2.jpg', 'images/rooms/premium-1-3.jpg', 'images/rooms/premium-1-4.jpg', 'images/rooms/premium-1-5.jpg'],
                'prices'    => [60000, 75000, 66000, 85000],
            ],
            [
                'slug'   => 'chambre-premium-2',
                'name'   => 'Chambre Premium 2',
                'category' => 'premium',
                'description_short' => 'La Premium en palette turquoise, avec coin salon et lumière traversante.',
                'description_long'  => "<div>Cette <strong>Chambre Premium</strong> décline la catégorie dans une palette turquoise apaisante : lit king size, coin salon et salle de bain contemporaine. La lumière traversante en fait l'une des chambres les plus agréables de la résidence.</div><h2>Ce qui la distingue</h2><ul><li>Lit king size</li><li>Coin salon</li><li>Salle de bain contemporaine</li></ul>",
                'capacity_adults' => 2, 'capacity_children' => 0,
                'size_m2' => 24, 'bed_type' => 'king', 'floor' => 0,
                'amenities' => [...$inclus, 'Lit king size', 'Coin salon'],
                'images'    => ['images/rooms/premium-2-1.jpg', 'images/rooms/premium-2-2.jpg', 'images/rooms/premium-2-3.jpg', 'images/rooms/premium-2-4.jpg', 'images/rooms/premium-2-5.jpg'],
                'prices'    => [60000, 75000, 66000, 85000],
            ],
            [
                'slug'   => 'suite',
                'name'   => 'Suite',
                'category' => 'suite',
                'description_short' => 'Un grand volume avec baignoire, plafond lumineux et coin détente — jusqu\'à 3 personnes.',
                'description_long'  => "<div>La <strong>Suite</strong> offre un vrai volume de vie : grande chambre au plafond lumineux, coin détente et salle de bain avec <strong>baignoire</strong>. Elle accueille confortablement 2 à 3 personnes.</div><h2>Ce qui la distingue</h2><ul><li>Salle de bain avec baignoire</li><li>Coin détente</li><li>Capacité 2–3 personnes</li></ul>",
                'capacity_adults' => 3, 'capacity_children' => 0,
                'size_m2' => 32, 'bed_type' => 'king', 'floor' => 0,
                'amenities' => [...$inclus, 'Baignoire', 'Coin détente'],
                'images'    => ['images/rooms/suite-1.jpg', 'images/rooms/suite-2.jpg', 'images/rooms/suite-3.jpg', 'images/rooms/suite-4.jpg', 'images/rooms/suite-5.jpg'],
                'prices'    => [80000, 100000, 88000, 115000],
            ],
            [
                'slug'   => 'suite-premium',
                'name'   => 'Suite Premium',
                'category' => 'suite-premium',
                'description_short' => 'Notre plus bel hébergement : salon séparé, comptoir bar et baignoire — jusqu\'à 4 personnes.',
                'description_long'  => "<div>La <strong>Suite Premium</strong> est l'hébergement le plus spacieux du Havre de Paix : salon séparé, comptoir bar, chambre king size et salle de bain avec baignoire. Idéale en famille ou pour une occasion spéciale, jusqu'à 4 personnes.</div><h2>Ce qui la distingue</h2><ul><li>Salon séparé et comptoir bar</li><li>Salle de bain avec baignoire</li><li>Capacité 2–4 personnes</li></ul>",
                'capacity_adults' => 4, 'capacity_children' => 0,
                'size_m2' => 45, 'bed_type' => 'king', 'floor' => 0,
                'amenities' => [...$inclus, 'Salon séparé', 'Comptoir bar', 'Baignoire'],
                'images'    => ['images/rooms/suite-premium-1.jpg', 'images/rooms/suite-premium-2.jpg', 'images/rooms/suite-premium-3.jpg', 'images/rooms/suite-premium-4.jpg', 'images/rooms/suite-premium-5.jpg'],
                'prices'    => [110000, 140000, 120000, 160000],
            ],
            [
                'slug'   => 'duplex',
                'name'   => 'Duplex',
                'category' => 'duplex',
                'description_short' => 'Deux chambres standard réunies avec salon : la formule idéale pour 4 personnes.',
                'description_long'  => "<div>Le <strong>Duplex</strong> réunit deux chambres standard et un salon commun : chacun son espace, un seul toit. La formule idéale entre amis ou en famille, pour 4 personnes.</div><h2>Ce qui le distingue</h2><ul><li>2 chambres standard</li><li>Salon commun</li><li>Capacité 4 personnes</li></ul>",
                'capacity_adults' => 4, 'capacity_children' => 0,
                'size_m2' => 50, 'bed_type' => 'double', 'floor' => 0,
                'amenities' => [...$inclus, '2 chambres', 'Salon commun'],
                'images'    => ['images/rooms/duplex-1.jpg', 'images/rooms/duplex-2.jpg', 'images/rooms/duplex-3.jpg', 'images/rooms/duplex-4.jpg', 'images/rooms/duplex-5.jpg', 'images/rooms/duplex-6.jpg'],
                'prices'    => [90000, 120000, 100000, 140000],
            ],
        ];

        foreach ($rooms as $data) {
            [$low, $high, $weLow, $weHigh] = $data['prices'];
            unset($data['prices']);

            Room::create([
                ...$data,
                'price_per_night'    => $low,
                'price_high_season'  => $high,
                'price_weekend_low'  => $weLow,
                'price_weekend_high' => $weHigh,
                'min_nights'         => 1,
                'status'             => 'active',
            ]);
        }

        // Réservations d'exemple
        $standard = Room::where('slug', 'chambre-standard-1')->first();
        $suite    = Room::where('slug', 'suite')->first();

        Reservation::create([
            'ref'              => 'HDP-2026-0001',
            'room_id'          => $suite->id,
            'guest_name'       => 'Marie Konan',
            'guest_email'      => 'marie.konan@email.com',
            'guest_phone'      => '+225 07 00 11 22 33',
            'check_in'         => now()->addDays(5)->toDateString(),
            'check_out'        => now()->addDays(8)->toDateString(),
            'nights'           => 3,
            'guests'           => 2,
            'total_price'      => 80000 * 3,
            'special_requests' => 'Arrivée en fin de journée',
            'status'           => 'confirmed',
            'cancel_token'     => bin2hex(random_bytes(16)),
        ]);

        Reservation::create([
            'ref'          => 'HDP-2026-0002',
            'room_id'      => $standard->id,
            'guest_name'   => 'Jean-Baptiste Diallo',
            'guest_email'  => 'jb.diallo@gmail.com',
            'guest_phone'  => '+225 05 12 34 56 78',
            'check_in'     => now()->addDays(10)->toDateString(),
            'check_out'    => now()->addDays(12)->toDateString(),
            'nights'       => 2,
            'guests'       => 2,
            'total_price'  => 50000 * 2,
            'status'       => 'confirmed',
            'cancel_token' => bin2hex(random_bytes(16)),
        ]);
    }
}
