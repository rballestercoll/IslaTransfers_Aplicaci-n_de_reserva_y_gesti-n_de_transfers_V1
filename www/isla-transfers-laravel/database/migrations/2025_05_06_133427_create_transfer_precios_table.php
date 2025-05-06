<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transfer_precios', function (Blueprint $table) {
            $table->integer('id_precios')->autoIncrement();
            $table->integer('id_vehiculo');
            $table->integer('id_hotel');
            $table->integer('Precio');
            $table->foreign('id_vehiculo')
                  ->references('id_vehiculo')
                  ->on('transfer_vehiculo')
                  ->onDelete('cascade');
            $table->foreign('id_hotel')
                  ->references('id_hotel')
                  ->on('transfer_hotel')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_precios');
    }
};
