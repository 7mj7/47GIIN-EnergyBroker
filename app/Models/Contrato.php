<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contrato extends Model
{

    protected $table = 'contratos';

    protected $fillable = [
        'tercero_id',
        'suministro_id',
        'nif_titular',
        'nombre_titular',
        'telefono1',
        'telefono2',
        'email',
    ];

    // Relaciones
    public function tercero(): BelongsTo
    {
        return $this->belongsTo(Tercero::class);
    }

    public function suministro(): BelongsTo
    {
        return $this->belongsTo(Suministro::class);
    }
}
