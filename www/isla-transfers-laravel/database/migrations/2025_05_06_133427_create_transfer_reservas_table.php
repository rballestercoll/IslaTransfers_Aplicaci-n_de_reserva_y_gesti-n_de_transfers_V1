<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transfer_reservas', function (Blueprint $table) {
            $table->integer('id_reserva')->autoIncrement();
            $table->integer('id_usuario');
            $table->string('localizador', 100);
            $table->integer('id_hotel')->nullable()->comment('Hotel que realiza la reserva');
            $table->integer('id_tipo_reserva');
            $table->string('email_cliente', 100);
            $table->dateTime('fecha_reserva');
            $table->dateTime('fecha_modificacion');
            $table->integer('id_destino');
            $table->date('fecha_entrada');
            $table->time('hora_entrada');
            $table->string('numero_vuelo_entrada', 50);
            $table->string('origen_vuelo_entrada', 50);
            $table->time('hora_vuelo_salida');
            $table->date('fecha_vuelo_salida');
            $table->string('numero_vuelo_salida', 50)->nullable();
            $table->time('hora_recogida')->nullable();
            $table->integer('num_viajeros');
            $table->integer('id_vehiculo');
            $table->enum('creado_por',['admin','usuario'])->default('usuario');
            // FKs
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('cascade');
            $table->foreign('id_hotel')
                  ->references('id_hotel')
                  ->on('transfer_hotel')
                  ->onDelete('set null');
            $table->foreign('id_tipo_reserva')
                  ->references('id_tipo_reserva')
                  ->on('transfer_tipo_reserva')
                  ->onDelete('cascade');
            $table->foreign('id_destino')
                  ->references('id_hotel')
                  ->on('transfer_hotel')
                  ->onDelete('cascade');
            $table->foreign('id_vehiculo')
                  ->references('id_vehiculo')
                  ->on('transfer_vehiculo')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_reservas');
    }
};
