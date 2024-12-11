<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suministro extends Model
{

    // Atributos
    protected $table = 'suministros';
    protected $fillable = [
        'cups',
        'tarifa_acceso_id',
        'consumo_anual',
        'direccion',
        'codigo_postal',
        'poblacion',
        'provincia',
    ];

    // Relaciones
    public function tercero(): BelongsTo
    {
        return $this->belongsTo(Tercero::class);
    }

    public function tarifaAcceso(): BelongsTo
    {
        return $this->belongsTo(TarifaAcceso::class);
    }
}
