<?php

namespace Database\Seeders;

use App\Models\EquipoVenta;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EquiposVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            EquipoVenta::create([
                'nombre' => 'Equipo de Ventas ' . $i,
                'descripcion' => $faker->paragraph,
                // Otros campos del equipo de venta con datos aleatorios
            ]);
        }
    }
}
