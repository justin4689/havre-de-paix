<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Grille « Tarifs Assinie 2026 » : 4 tarifs par chambre.
     * price_per_night reste le tarif basse saison en semaine
     * (et le prix « à partir de » affiché sur le catalogue).
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedInteger('price_high_season')->nullable()->after('price_per_night');
            $table->unsignedInteger('price_weekend_low')->nullable()->after('price_high_season');
            $table->unsignedInteger('price_weekend_high')->nullable()->after('price_weekend_low');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['price_high_season', 'price_weekend_low', 'price_weekend_high']);
        });
    }
};
