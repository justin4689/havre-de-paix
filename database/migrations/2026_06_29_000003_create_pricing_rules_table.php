<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->integer('adjustment'); // +20 (%) ou +5000 (FCFA), peut être négatif
            $table->unsignedSmallInteger('min_nights')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
