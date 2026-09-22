<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chambre mise en avant sur la carte d'accueil de la catégorie.
     * Nullable : sans choix, la moins chère de la catégorie est affichée.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('featured_room_id')->nullable()->constrained('rooms')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('featured_room_id');
        });
    }
};
