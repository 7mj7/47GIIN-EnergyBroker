<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipoVenta extends Model
{
    use SoftDeletes;
    
    protected $table = 'equipos_venta';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
