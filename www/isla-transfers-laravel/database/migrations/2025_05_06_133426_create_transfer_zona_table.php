<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transfer_zona', function (Blueprint $table) {
            $table->integer('id_zona')->autoIncrement();
            $table->string('descripcion', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_zona');
    }
};
