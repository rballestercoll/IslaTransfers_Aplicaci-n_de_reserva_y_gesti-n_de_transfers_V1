<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
=======
use Illuminate\Database\Seeder;
use App\Models\Usuario;
>>>>>>> origin/PaulaC2
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
<<<<<<< HEAD
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin'),
            ]
        )->assignRole('admin');
=======
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
>>>>>>> origin/PaulaC2
    }
}
