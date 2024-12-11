<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tercero extends Model
{
    //
    protected $table = 'terceros';

    protected $fillable = [
        'id',
        'user_id',
        'nif',
        'nombre',
        'direccion',
        'codigo_postal',
        'poblacion',
        'provincia',
        'telefono1',
        'telefono2',
        'email',
        'contacto',
        'notas',
    ];

    // Relaciones
    public function suministros(): HasMany
    {
        return $this->hasMany(Suministro::class);
    }
}
