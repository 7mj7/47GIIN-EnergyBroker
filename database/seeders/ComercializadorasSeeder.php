<?php

namespace Database\Seeders;

use App\Models\Comercializadora;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComercializadorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $comercializadoras = [
            ['id' => 1, 'nombre' => 'ACCIONA', 'nombre_fiscal' => 'ACCIONA GREEN ENERGY DEVELOPMENTS SL', 'activo' => true],
            ['id' => 2, 'nombre' => 'ALDRO', 'nombre_fiscal' => 'ENI PLENITUDE IBERIA, S.L.', 'activo' => true],
            ['id' => 3, 'nombre' => 'AUDAX', 'nombre_fiscal' => 'AUDAX RENOVABLES, S.A', 'activo' => true],
            ['id' => 4, 'nombre' => 'AXPO', 'nombre_fiscal' => 'AXPO IBERIA S.L.', 'activo' => true],
            ['id' => 5, 'nombre' => 'ELEIA', 'nombre_fiscal' => 'ELECTRICIDAD ELEIA S.L.', 'activo' => true],
            ['id' => 6, 'nombre' => 'ENDESA', 'nombre_fiscal' => 'ENDESA ENERGÍA S.A.U.', 'activo' => true],
            ['id' => 7, 'nombre' => 'FOX', 'nombre_fiscal' => 'FOX ENERGÍA S.A', 'activo' => true],
            ['id' => 8, 'nombre' => 'GANA', 'nombre_fiscal' => 'GAOLANIA SERVICIOS SL', 'activo' => true],
            [
                'id' => 9,
                'nombre' => 'IBERDROLA',
                'nombre_fiscal' => 'IBERDROLA CLIENTES, S.A.U.',
                'cif' => 'A99999999',
                'gestor_nombre' => 'Juan Pérez',
                'gestor_telefono' => '666666666',
                'gestor_email' => 'juan.perez@example.com',
                'activo' => true,
            ],
            ['id' => 10, 'nombre' => 'IRIS', 'nombre_fiscal' => 'IRIS ENERGIA EFICIENTE, S.A.', 'activo' => true],
            ['id' => 11, 'nombre' => 'LOGOS', 'nombre_fiscal' => 'BIROU GAS S.L.', 'activo' => true],
            ['id' => 12, 'nombre' => 'NATURGY', 'nombre_fiscal' => 'NATURGY CLIENTES, S.A.U.', 'activo' => true],
            ['id' => 13, 'nombre' => 'NEON', 'nombre_fiscal' => 'NEÓN ENERGÍA EFICIENTE, S.L', 'activo' => true],
            ['id' => 14, 'nombre' => 'REPSOL', 'nombre_fiscal' => 'REPSOL COMERCIALIZADORA DE ELECTRICIDAD Y GAS, S.L.U', 'activo' => true],
            ['id' => 15, 'nombre' => 'TOTAL ENERGIES', 'nombre_fiscal' => 'TOTALENERGIES CLIENTES S.A.U.', 'activo' => true],
            // Añade más comercializadoras aquí
        ];

        foreach ($comercializadoras as $comercializadora) {
            Comercializadora::create($comercializadora);
        }
    }
}
