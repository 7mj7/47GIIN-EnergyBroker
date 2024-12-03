<?php

namespace Database\Seeders;

use App\Models\TarifaAcceso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarifasAccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TarifaAcceso::create(
            [
                'tipo_energia' => 'E', // ID del tipo de energía asociado
                'nombre' => '2.0TD',
                'fecha_inicio' => '2021-06-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        TarifaAcceso::create(
            [
                'tipo_energia' => 'E', // ID del tipo de energía asociado
                'nombre' => '3.0TD',
                'fecha_inicio' => '2021-06-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        TarifaAcceso::create(
            [
                'tipo_energia' => 'E', // ID del tipo de energía asociado
                'nombre' => '6.1TD',
                'fecha_inicio' => '2021-06-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        TarifaAcceso::create(
            [
                'tipo_energia' => 'E', // ID del tipo de energía asociado
                'nombre' => '6.2TD',
                'fecha_inicio' => '2021-06-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        TarifaAcceso::create(
            [
                'tipo_energia' => 'G', // ID del tipo de energía asociado
                'nombre' => 'RL.1',
                'fecha_inicio' => '2021-10-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        TarifaAcceso::create(
            [
                'tipo_energia' => 'G', // ID del tipo de energía asociado
                'nombre' => 'RL.2',
                'fecha_inicio' => '2021-10-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        TarifaAcceso::create(
            [
                'tipo_energia' => 'G', // ID del tipo de energía asociado
                'nombre' => 'RL.3',
                'fecha_inicio' => '2021-10-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        TarifaAcceso::create(
            [
                'tipo_energia' => 'G', // ID del tipo de energía asociado
                'nombre' => 'RL.4',
                'fecha_inicio' => '2021-10-01',
                'fecha_fin' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
