<?php

namespace App\Models;

use App\Enums\TiposTarifaEnergia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TarifaEnergia extends Model
{
     // Especificar el nombre de la tabla asociada
     protected $table = 'tarifas_energia';

     protected $fillable = [
        'nombre',
        'comercializadora_id',
        'tarifa_acceso_id',
        'tipo_tarifa',
        'valida_desde',
        'valida_hasta',
        'activo',
        // Precios de potencia (Electricidad)
        'pp_p1',
        'pp_p2',
        'pp_p3',
        'pp_p4',
        'pp_p5',
        'pp_p6',
        // Precios de energia (Electricidad)
        'pe_p1',
        'pe_p2',
        'pe_p3',
        'pe_p4',
        'pe_p5',
        'pe_p6',
    ];

    protected $casts = [
        'tipo_tarifa' => TiposTarifaEnergia::class,
    ];

    public function comercializadora(): BelongsTo
    {
        return $this->belongsTo(Comercializadora::class);
    }

    public function tarifaAcceso(): BelongsTo
    {
        return $this->belongsTo(TarifaAcceso::class);
    }
}
