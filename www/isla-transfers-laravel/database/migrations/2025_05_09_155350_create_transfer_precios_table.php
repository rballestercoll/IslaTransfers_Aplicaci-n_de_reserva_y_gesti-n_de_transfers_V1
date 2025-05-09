<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfer_precios', function (Blueprint $table) {
            $table->integer('id_precios', true);
            $table->string('id_vehiculo', 50)->index('fk_precios_vehiculo');
            $table->string('id_hotel', 50)->index('fk_precios_hotel');
            $table->integer('Precio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_precios');
    }
};
