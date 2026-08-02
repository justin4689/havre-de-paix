<?php

namespace Database\Seeders;

use App\Models\PricingRule;
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
            'name'     => 'Admin Résidence Hôtel Cascades',
            'email'    => 'admin@residencehotelcascades.com',
            'password' => Hash::make('HDP@admin2024'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Réception HDP',
            'email'    => 'reception@residencehotelcascades.com',
            'password' => Hash::make('reception2024'),
            'role'     => 'receptionist',
        ]);

        // Chambres — catalogue réel « Prix des chambres lancement »
        // 4 types répartis sur 3 étages ; chaque numéro est une unité réservable.
        $types = [
            'mini-suite' => [
                'name'              => 'Mini Suite',
                'description_short' => 'Notre catégorie supérieure : un espace généreux avec coin salon et lit king size, pour allier travail et détente.',
                'description_long'  => "<div>La <strong>Mini Suite</strong> est l'hébergement le plus spacieux de la Résidence Hôtel Cascades. Son coin salon séparé et son lit king size en font le choix idéal pour les longs séjours comme pour les occasions spéciales.</div><h2>Ce qui la distingue</h2><ul><li>Coin salon avec fauteuils</li><li>Lit king size et literie hôtelière</li><li>Espace de travail confortable</li></ul>",
                'capacity_adults'   => 2,
                'capacity_children' => 1,
                'size_m2'           => 30,
                'bed_type'          => 'king',
                'amenities'         => ['WiFi haut débit', 'Climatisation', 'Télévision satellite', 'Minibar', 'Coffre-fort', 'Coin salon', 'Bureau de travail'],
                'images'            => ['images/rooms/suite-prestige-1.jpg', 'images/rooms/suite-prestige-2.jpg', 'images/rooms/suite-prestige-3.jpg'],
                'price_per_night'   => 75000,
            ],
            'standard' => [
                'name'              => 'Chambre Standard',
                'description_short' => "Tout le confort essentiel dans un cadre calme et verdoyant, au cœur de Cocody.",
                'description_long'  => "<div>La <strong>Chambre Standard</strong> offre tout le nécessaire pour un séjour réussi : lit double confortable, climatisation, télévision satellite et salle d'eau moderne — dans le calme du quartier résidentiel de Cocody.</div>",
                'capacity_adults'   => 2,
                'capacity_children' => 1,
                'size_m2'           => 20,
                'bed_type'          => 'double',
                'amenities'         => ['WiFi haut débit', 'Climatisation', 'Télévision satellite', 'Coffre-fort', 'Douche'],
                'images'            => ['images/rooms/chambre-jardin-1.jpg', 'images/rooms/chambre-jardin-2.jpg', 'images/rooms/chambre-jardin-3.jpg'],
                'price_per_night'   => 50000,
            ],
            'executive' => [
                'name'              => 'Chambre Executive',
                'description_short' => "Pensée pour les voyageurs d'affaires : espace de travail dédié et confort haut de gamme au dernier étage.",
                'description_long'  => "<div>Située au troisième étage, la <strong>Chambre Executive</strong> est conçue pour les séjours d'affaires : bureau de travail dédié, lit king size et environnement silencieux, à 30 minutes du Plateau.</div>",
                'capacity_adults'   => 2,
                'capacity_children' => 1,
                'size_m2'           => 24,
                'bed_type'          => 'king',
                'amenities'         => ['WiFi haut débit', 'Climatisation', 'Bureau de travail', 'Télévision satellite', 'Minibar', 'Coffre-fort'],
                'images'            => ['images/rooms/chambre-vue-mer-1.jpg', 'images/rooms/chambre-vue-mer-2.jpg', 'images/rooms/chambre-vue-mer-3.jpg'],
                'price_per_night'   => 50000,
            ],
            'open-space' => [
                'name'              => 'Open Space',
                'description_short' => 'Un espace ouvert et lumineux, esprit loft, au dernier étage de la résidence — notre meilleur tarif.',
                'description_long'  => "<div>L'<strong>Open Space</strong> est un hébergement au plan ouvert, lumineux et aéré, situé au troisième étage. Son agencement décloisonné, esprit loft, en fait une option originale au meilleur tarif de la résidence.</div>",
                'capacity_adults'   => 2,
                'capacity_children' => 1,
                'size_m2'           => 28,
                'bed_type'          => 'double',
                'amenities'         => ['WiFi haut débit', 'Climatisation', 'Télévision satellite', 'Coffre-fort', 'Espace ouvert'],
                'images'            => ['images/rooms/chambre-twin-piscine-1.jpg', 'images/rooms/chambre-twin-piscine-2.jpg', 'images/rooms/chambre-twin-piscine-3.jpg'],
                'price_per_night'   => 40000,
            ],
        ];

        $unites = [
            ['101', 'mini-suite', 1],
            ['102', 'standard',   1],
            ['103', 'standard',   1],
            ['201', 'mini-suite', 2],
            ['202', 'standard',   2],
            ['203', 'standard',   2],
            ['204', 'mini-suite', 2],
            ['301', 'open-space', 3],
            ['302', 'executive',  3],
            ['303', 'executive',  3],
            ['304', 'open-space', 3],
        ];

        foreach ($unites as [$numero, $typeKey, $etage]) {
            $type = $types[$typeKey];
            unset($type['name']);

            Room::create([
                ...$type,
                'slug'       => 'chambre-' . $numero,
                'name'       => 'Chambre ' . $numero,
                'floor'      => $etage,
                'category'   => $typeKey,
                'min_nights' => 1,
                'status'     => 'active',
            ]);
        }

        // Pricing rules
        PricingRule::create([
            'name'       => 'Haute saison (Noël / Nouvel An)',
            'start_date' => '2025-12-20',
            'end_date'   => '2026-01-05',
            'type'       => 'percentage',
            'adjustment' => 30,
            'min_nights' => 3,
            'active'     => true,
        ]);

        PricingRule::create([
            'name'       => 'Vacances scolaires CI',
            'start_date' => '2026-07-01',
            'end_date'   => '2026-08-31',
            'type'       => 'percentage',
            'adjustment' => 20,
            'min_nights' => 2,
            'active'     => true,
        ]);

        PricingRule::create([
            'name'       => 'Basse saison',
            'start_date' => '2026-09-01',
            'end_date'   => '2026-11-30',
            'type'       => 'percentage',
            'adjustment' => -15,
            'min_nights' => 1,
            'active'     => true,
        ]);

        // Sample reservations
        $room1 = Room::where('slug', 'chambre-101')->first();
        $room2 = Room::where('slug', 'chambre-102')->first();
        $room3 = Room::where('slug', 'chambre-302')->first();

        Reservation::create([
            'ref'              => 'RHC-2026-0001',
            'room_id'          => $room1->id,
            'guest_name'       => 'Marie Konan',
            'guest_email'      => 'marie.konan@email.com',
            'guest_phone'      => '+225 07 00 11 22 33',
            'check_in'         => now()->addDays(5)->toDateString(),
            'check_out'        => now()->addDays(8)->toDateString(),
            'nights'           => 3,
            'guests'           => 2,
            'total_price'      => 75000 * 3,
            'special_requests' => 'Lit bébé si possible',
            'status'           => 'confirmed',
            'cancel_token'     => bin2hex(random_bytes(16)),
        ]);

        Reservation::create([
            'ref'          => 'RHC-2026-0002',
            'room_id'      => $room2->id,
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

        Reservation::create([
            'ref'          => 'RHC-2026-0003',
            'room_id'      => $room3->id,
            'guest_name'   => 'Sophie Renard',
            'guest_email'  => 'sophie.renard@outlook.fr',
            'guest_phone'  => '+33 6 78 90 12 34',
            'check_in'     => now()->subDays(3)->toDateString(),
            'check_out'    => now()->subDays(1)->toDateString(),
            'nights'       => 2,
            'guests'       => 2,
            'total_price'  => 50000 * 2,
            'status'       => 'confirmed',
            'cancel_token' => bin2hex(random_bytes(16)),
        ]);
    }
}
