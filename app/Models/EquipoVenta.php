<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipoVenta extends Model
{
    use SoftDeletes;
    
    protected $table = 'equipos_venta';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];
}
