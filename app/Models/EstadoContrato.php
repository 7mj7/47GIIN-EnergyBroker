<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoContrato extends Model
{
    //
    protected $table = 'estados_contrato';

    protected $fillable = [      
        'nombre',
        'activo',
        'descripcion',
    ];
}
