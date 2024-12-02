<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodigoPostal extends Model
{
    use HasFactory;

    protected $table = 'codigos_postales';

    protected $fillable = [
        'id',
        'codigo_postal',
        'poblacion',
        'provincia_id',
    ];



    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }
}
