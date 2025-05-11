<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transfer_reservas', function (Blueprint $table) {
        // si ya existe hora_vuelo_salida, no la añadimos de nuevo
        if (! Schema::hasColumn('transfer_reservas', 'fecha_vuelo_salida')) {
            $table->date('fecha_vuelo_salida')
                  ->nullable()
                  ->after('origen_vuelo_entrada');
        }
        if (! Schema::hasColumn('transfer_reservas', 'hora_recogida_salida')) {
            $table->time('hora_recogida_salida')
                  ->nullable()
                  ->after('hora_vuelo_salida');
        }
    });
}

};
