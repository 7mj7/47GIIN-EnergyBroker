<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoContrato;

class EstadosContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoContrato::create([
            'nombre' => 'BORRADOR',
            'descripcion' => 'Estado de contrato borrador',
            'activo' => true,
        ]);

        EstadoContrato::create([
            'nombre' => 'TRAMITADO',
            'descripcion' => 'Estado de contrato tramitado',
            'activo' => true,
        ]);

        EstadoContrato::create([
            'nombre' => 'INCIDENCIA',
            'descripcion' => 'Estado de contrato con incidencia',
            'activo' => true,
        ]);

        EstadoContrato::create([
            'nombre' => 'ACEPTADO',
            'descripcion' => 'Estado de contrato aceptado',
            'activo' => true,
        ]);

        EstadoContrato::create([
            'nombre' => 'CANCELADO',
            'descripcion' => 'Estado de contrato cancelado',
            'activo' => true,
        ]);

    }
}
