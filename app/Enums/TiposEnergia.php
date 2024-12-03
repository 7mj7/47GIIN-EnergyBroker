<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;


enum TiposEnergia: string implements HasColor, HasIcon, HasLabel
{
    case ELECTRICIDAD  = 'E';
    case GAS = 'G';


    // Etiquetas
    public function getLabel(): string
    {
        return match ($this) {
            self::ELECTRICIDAD => 'ELECTRICIDAD',
            self::GAS => 'GAS',
        };
    }

    // Colores
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ELECTRICIDAD => 'info',
            self::GAS => 'warning',
        };
    }

    // Iconos
    public function getIcon(): ?string
    {
        return match ($this) {
            self::ELECTRICIDAD => 'heroicon-m-bolt',
            self::GAS => 'heroicon-m-fire',
        };
    }
}
