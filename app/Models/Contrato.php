<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Contrato extends Model
{

    use HasFilamentComments;

    protected $table = 'contratos';

    protected $fillable = [
        'tercero_id',
        'suministro_id',
        // Titular
        'nif_titular',
        'nombre_titular',
        'telefono1',
        'telefono2',
        'email',
        // Suministro
        'cups',
        'tarifa_acceso',
        'consumo_anual',
        'direccion',
        'codigo_postal',
        'poblacion',
        'provincia',
        // Tarifa
        'comercializadora_id',
        'tarifa_energia_id',
        'fecha_firma',
        'fecha_activacion',
        'fecha_baja',
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

    public function comercializadora(): BelongsTo
    {
        return $this->belongsTo(Comercializadora::class);
    }

    public function tarifaEnergia(): BelongsTo
    {
        return $this->belongsTo(TarifaEnergia::class);
    }
}
