<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;


enum TiposTarifaEnergia: string implements HasColor, HasIcon, HasLabel
{
    case INDEXADA  = 'I';
    case FIJA = 'F';


    // Etiquetas
    public function getLabel(): string
    {
        return match ($this) {
            self::INDEXADA => 'INDEX.',
            self::FIJA => 'FIJA',
        };
    }

    // Colores
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::INDEXADA => 'success',
            self::FIJA => 'danger',
        };
    }

    // Iconos
    public function getIcon(): ?string
    {
        return match ($this) {
            self::INDEXADA => 'heroicon-m-scale',
            self::FIJA => 'heroicon-m-lock-closed',
        };
    }
}
