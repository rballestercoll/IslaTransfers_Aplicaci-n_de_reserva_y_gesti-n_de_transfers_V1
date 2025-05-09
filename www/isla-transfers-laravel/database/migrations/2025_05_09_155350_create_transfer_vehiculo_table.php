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
        Schema::create('transfer_vehiculo', function (Blueprint $table) {
            $table->string('id_vehiculo', 50)->primary();
            $table->string('descripcion', 100);
            $table->string('email_conductor', 100);
            $table->string('password', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_vehiculo');
    }
};
