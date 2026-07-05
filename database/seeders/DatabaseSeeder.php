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
            'name'     => 'Admin Havre de Paix',
            'email'    => 'admin@havredepaix-assinie.com',
            'password' => Hash::make('HDP@admin2024'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Réception HDP',
            'email'    => 'reception@havredepaix-assinie.com',
            'password' => Hash::make('reception2024'),
            'role'     => 'receptionist',
        ]);

        // Chambres
        $rooms = [
            [
                'slug'              => 'bungalow-lagune',
                'name'              => 'Bungalow Lagune',
                'description_short' => 'Bungalow en bois flotté sur pilotis, vue directe sur la lagune. Le matin, le soleil se lève face à vous.',
                'description_long'  => "Plongez dans un cadre unique avec ce bungalow sur pilotis offrant une vue panoramique sur la lagune d'Assinie. Décoré avec des matériaux naturels — bois flotté, rotin, lin — cet espace de 32 m² invite au calme absolu.\n\nLa terrasse privée avec chaises longues est l'endroit idéal pour siroter un cocktail au coucher du soleil.",
                'capacity_adults'   => 2,
                'capacity_children' => 1,
                'size_m2'           => 32,
                'bed_type'          => 'king',
                'floor'             => 0,
                'view'              => 'lagoon',
                'amenities'         => ['WiFi haut débit', 'Climatisation inverter', 'Ventilateur de plafond', 'Minibar', 'Télévision satellite', 'Coffre-fort', 'Douche extérieure', 'Terrasse privée', 'Chaises longues'],
                'images'            => ['images/rooms/bungalow-lagune-1.jpg'],
                'price_per_night'   => 75000,
                'min_nights'        => 2,
                'status'            => 'active',
            ],
            [
                'slug'              => 'chambre-vue-mer',
                'name'              => 'Chambre Vue Mer',
                'description_short' => "Chambre élégante avec balcon face à l'océan Atlantique. Le bruit des vagues vous berce chaque nuit.",
                'description_long'  => "Depuis le balcon privé de cette chambre de 28 m², vous contemplez l'horizon infini de l'Atlantique. La décoration mêle blancs immaculés et touches navales pour un intérieur lumineux et apaisant.\n\nLit king size avec literie hôtelière haut de gamme, salle de bain en marbre avec double vasque.",
                'capacity_adults'   => 2,
                'capacity_children' => 0,
                'size_m2'           => 28,
                'bed_type'          => 'king',
                'floor'             => 1,
                'view'              => 'sea',
                'amenities'         => ['WiFi haut débit', 'Climatisation inverter', 'Balcon privé', 'Minibar', 'Télévision satellite', 'Coffre-fort', 'Salle de bain en marbre', 'Double vasque', "Douche à l'italienne"],
                'images'            => ['images/rooms/chambre-vue-mer-1.jpg'],
                'price_per_night'   => 65000,
                'min_nights'        => 1,
                'status'            => 'active',
            ],
            [
                'slug'              => 'suite-prestige',
                'name'              => 'Suite Prestige',
                'description_short' => 'Notre suite la plus spacieuse — salon séparé, jacuzzi sur terrasse et vue à 180° sur lagune et mer.',
                'description_long'  => "La Suite Prestige est l'hébergement le plus exclusif du Havre de Paix. Avec ses 55 m², elle comprend une chambre avec lit king size, un salon séparé, et une large terrasse panoramique où trône un jacuzzi privatif.\n\nParfaite pour une lune de miel ou une occasion spéciale.",
                'capacity_adults'   => 2,
                'capacity_children' => 2,
                'size_m2'           => 55,
                'bed_type'          => 'king',
                'floor'             => 2,
                'view'              => 'sea',
                'amenities'         => ['WiFi haut débit', 'Climatisation inverter', 'Jacuzzi privatif', 'Salon séparé', 'Grande terrasse', 'Minibar premium', 'Télévision 55"', 'Système audio Bluetooth', 'Coffre-fort', 'Peignoirs & pantoufles', 'Machine Nespresso'],
                'images'            => ['images/rooms/suite-prestige-1.jpg'],
                'price_per_night'   => 120000,
                'min_nights'        => 2,
                'status'            => 'active',
            ],
            [
                'slug'              => 'chambre-jardin',
                'name'              => 'Chambre Jardin',
                'description_short' => 'Chambre cosy face aux jardins tropicaux. Idéale pour les amoureux de nature et de calme.',
                'description_long'  => "Nichée au cœur des jardins tropicaux du Havre de Paix, cette chambre de 24 m² offre un cadre verdoyant et serein. La végétation luxuriante visible depuis la terrasse privée en fait un véritable havre de paix.",
                'capacity_adults'   => 2,
                'capacity_children' => 1,
                'size_m2'           => 24,
                'bed_type'          => 'double',
                'floor'             => 0,
                'view'              => 'garden',
                'amenities'         => ['WiFi haut débit', 'Climatisation', 'Ventilateur', 'Télévision', 'Terrasse privée', 'Douche & baignoire', 'Coffre-fort'],
                'images'            => ['images/rooms/chambre-jardin-1.jpg'],
                'price_per_night'   => 45000,
                'min_nights'        => 1,
                'status'            => 'active',
            ],
            [
                'slug'              => 'chambre-twin-piscine',
                'name'              => 'Chambre Twin Piscine',
                'description_short' => 'Chambre avec deux lits simples et accès direct à la piscine. Idéale pour amis ou collègues.',
                'description_long'  => "Conçue pour deux personnes voyageant ensemble, cette chambre twin de 26 m² dispose d'un accès direct à la piscine principale via une terrasse privée.\n\nDeux lits simples haut de gamme, grande salle de bain, bureau de travail.",
                'capacity_adults'   => 2,
                'capacity_children' => 0,
                'size_m2'           => 26,
                'bed_type'          => 'twin',
                'floor'             => 0,
                'view'              => 'pool',
                'amenities'         => ['WiFi haut débit', 'Climatisation', 'Accès direct piscine', 'Télévision satellite', 'Bureau de travail', 'Minibar', 'Coffre-fort', 'Douche'],
                'images'            => ['images/rooms/chambre-twin-piscine-1.jpg'],
                'price_per_night'   => 55000,
                'min_nights'        => 1,
                'status'            => 'active',
            ],
        ];

        foreach ($rooms as $data) {
            Room::create($data);
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
        $room1 = Room::where('slug', 'bungalow-lagune')->first();
        $room2 = Room::where('slug', 'chambre-vue-mer')->first();
        $room3 = Room::where('slug', 'suite-prestige')->first();

        Reservation::create([
            'ref'              => 'HDP-2026-0001',
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
            'ref'          => 'HDP-2026-0002',
            'room_id'      => $room2->id,
            'guest_name'   => 'Jean-Baptiste Diallo',
            'guest_email'  => 'jb.diallo@gmail.com',
            'guest_phone'  => '+225 05 12 34 56 78',
            'check_in'     => now()->addDays(10)->toDateString(),
            'check_out'    => now()->addDays(12)->toDateString(),
            'nights'       => 2,
            'guests'       => 2,
            'total_price'  => 65000 * 2,
            'status'       => 'confirmed',
            'cancel_token' => bin2hex(random_bytes(16)),
        ]);

        Reservation::create([
            'ref'          => 'HDP-2026-0003',
            'room_id'      => $room3->id,
            'guest_name'   => 'Sophie Renard',
            'guest_email'  => 'sophie.renard@outlook.fr',
            'guest_phone'  => '+33 6 78 90 12 34',
            'check_in'     => now()->subDays(3)->toDateString(),
            'check_out'    => now()->subDays(1)->toDateString(),
            'nights'       => 2,
            'guests'       => 2,
            'total_price'  => 120000 * 2,
            'status'       => 'confirmed',
            'cancel_token' => bin2hex(random_bytes(16)),
        ]);
    }
}
