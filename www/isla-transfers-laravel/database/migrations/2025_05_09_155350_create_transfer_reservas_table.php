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
        Schema::create('transfer_reservas', function (Blueprint $table) {
            $table->integer('id_reserva', true);
            $table->integer('id_usuario')->index('fk_usuario_reserva');
            $table->string('localizador', 100);
            $table->string('id_hotel', 50)->nullable()->index('fk_reservas_hotel')->comment('Hotel que realiza la reserva');
            $table->integer('id_tipo_reserva')->index('fk_reservas_tipo');
            $table->string('email_cliente', 100);
            $table->dateTime('fecha_reserva');
            $table->dateTime('fecha_modificacion');
            $table->string('id_destino', 50)->index('fk_reservas_destino');
            $table->date('fecha_entrada');
            $table->time('hora_entrada');
            $table->string('numero_vuelo_entrada', 50);
            $table->string('origen_vuelo_entrada', 50);
            $table->time('hora_vuelo_salida');
            $table->date('fecha_vuelo_salida');
            $table->string('numero_vuelo_salida', 50)->nullable();
            $table->time('hora_recogida')->nullable();
            $table->integer('num_viajeros');
            $table->string('id_vehiculo', 50)->index('fk_reservas_vehiculo');
            $table->enum('creado_por', ['usuario', 'admin'])->default('usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_reservas');
    }
};
