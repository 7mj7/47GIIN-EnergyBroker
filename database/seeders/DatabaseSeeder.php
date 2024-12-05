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
            
            // Creamos las comercializadoras
            ComercializadorasSeeder::class,
            // Creamos los códigos postales
            CodigosPostalesSeeder::class,
            // Creamos las tarifas de acceso
            TarifasAccesoSeeder::class,
            // Creamos los equipos de venta
            EquiposVentaSeeder::class,
            // Inicializamos los estados de los contratos
            EstadosContratoSeeder::class,


            // Primero ejecutamos ShieldSeeder para generar los roles y permisos
            ShieldSeeder::class,
            // Luego creamos el usuario admin y le asignamos el rol
            CreateAdminUserSeeder::class,
        ]);

    }
}
