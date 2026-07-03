<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description_short');
            $table->text('description_long')->nullable();
            $table->unsignedTinyInteger('capacity_adults')->default(2);
            $table->unsignedTinyInteger('capacity_children')->default(0);
            $table->unsignedSmallInteger('size_m2')->nullable();
            $table->string('bed_type')->default('double'); // single|double|twin|king
            $table->unsignedTinyInteger('floor')->default(1);
            $table->string('view')->default('garden'); // sea|lagoon|garden|pool
            $table->json('amenities')->nullable(); // ['wifi','ac','tv',...]
            $table->json('images')->nullable(); // array of paths
            $table->unsignedInteger('price_per_night'); // FCFA entier
            $table->unsignedSmallInteger('min_nights')->default(1);
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
