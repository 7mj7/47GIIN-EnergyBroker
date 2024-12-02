<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comercializadora extends Model
{
    protected $fillable = [
        'nombre',
        'activo',
        'nombre_fiscal',
        'cif',
        'gestor_nombre',
        'gestor_telefono',
        'gestor_email',
        // otros campos que necesites
    ];
}
