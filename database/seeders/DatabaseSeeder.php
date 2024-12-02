<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Primero ejecutamos ShieldSeeder para generar los roles y permisos
            ShieldSeeder::class,
            // Luego creamos el usuario admin y le asignamos el rol
            CreateAdminUserSeeder::class,
            // Creamos las comercializadoras
            ComercializadorasSeeder::class,
        ]);

    }
}
