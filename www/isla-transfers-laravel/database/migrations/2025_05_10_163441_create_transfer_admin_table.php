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
        Schema::create('transfer_admin', function (Blueprint $table) {
        $table->id('id_admin');
        $table->string('nombre');
        $table->string('email_admin')->unique();
        $table->string('password');
        // ... otros campos que uses
        $table->timestamps(); // o false si no usas created_at/updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_admin');
    }
};
