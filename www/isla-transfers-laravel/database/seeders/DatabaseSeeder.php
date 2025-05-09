<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // Llama aquí a todos los seeders necesarios, en el orden que desees ejecutar.
        $this->call([
            RolesSeeder::class,
            transfer_hotel::class,       
            transfer_precios::class,    
            transfer_vehiculo::class,
            transfer_zona::class, 
            AdminUserSeeder::class,      
        ]);
    }
}
=======
        $this->call([
            AdminUserSeeder::class,
        ]);
    }

}
>>>>>>> origin/PaulaC2
