<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TiposEnergia;

class TarifaAcceso extends Model
{
    protected $table = 'tarifas_acceso';

    protected $fillable = [
        'tipo_energia',
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected $casts = [
        'tipo_energia' => TiposEnergia::class,
    ];
}
