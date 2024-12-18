<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioHorarioMercadoDiario extends Model
{
    use HasFactory;

    protected $table = 'omie_precios_horarios_mercado_diaro';

    protected $fillable = [
        'anio',
        'mes',
        'dia',
        'hora',
        'marginalPT',
        'marginalES',
    ];


}
