<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::firstOrCreate(
            ['email' => 'admin@islatransfers.com'],
            [
                'nombre'   => 'Administrador',
                'password' => Hash::make('admin123'),
                'rol'      => 'admin',
            ]
        );
    }
}
