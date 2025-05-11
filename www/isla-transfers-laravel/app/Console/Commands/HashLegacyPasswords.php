<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HashLegacyPasswords extends Command
{
    protected $signature = 'passwords:hash-legacy';
    protected $description = 'Actualiza contraseñas en texto plano a hash en todas las tablas';

    public function handle()
    {
        // Tabla transfer_hotel
        $this->hashTable('transfer_hotel', 'id_hotel', 'password');

        // Tabla transfer_admin
        $this->hashTable('transfer_admin', 'id_admin', 'password');

        // Tabla transfer_vehiculo
        $this->hashTable('transfer_vehiculo', 'id_vehiculo', 'password');

        // Tabla transfer_viajeros (solo IDs específicos)
        DB::table('transfer_viajeros')
            ->whereIn('id_viajero', [1, 2, 3, 4, 5])
            ->get()
            ->each(function ($user) {
                $this->updatePassword('transfer_viajeros', 'id_viajero', $user->id_viajero, $user->password, 'password');
            });

        $this->info('¡Contraseñas actualizadas con éxito!');
    }

    private function hashTable(string $table, string $idColumn, string $passwordColumn)
    {
        DB::table($table)->get()->each(function ($user) use ($table, $idColumn, $passwordColumn) {
            $this->updatePassword($table, $idColumn, $user->{$idColumn}, $user->{$passwordColumn}, $passwordColumn);
        });
    }

    private function updatePassword(string $table, string $idColumn, $id, string $password, string $passwordColumn)
    {
        // Verifica si la contraseña ya está hasheada con bcrypt
        if (!preg_match('/^\$2[aby]\$.{56}$/', $password)) {
            DB::table($table)
                ->where($idColumn, $id)
                ->update([$passwordColumn => bcrypt($password)]);
        }
    }
}