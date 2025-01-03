<?php

namespace App\Filament\Admin\Widgets;

use NumberFormatter;
use App\Models\Contrato;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ContratoStatsWidget extends BaseWidget
{
    //protected static ?string $heading = 'zzzzz';
    protected static ?int $sort = 1;  // Prioridad en el dashboard
    protected int $refreshInterval = 60;  // Actualizar cada minuto

    protected function getStats(): array
    {
        return [
            Stat::make('Contratos', Contrato::count())
                ->description('Total de contratos')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success'),

            Stat::make('Consumo anual', function () {
                $formatter = new NumberFormatter('es_ES', NumberFormatter::DECIMAL);
                $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
                return $formatter->format(Contrato::sum('consumo_anual')) . ' kWh';
            })
                ->description('De todos los contratos')
                ->descriptionIcon('heroicon-o-bolt')
                ->color('primary'),

            Stat::make('Número de CUPS', function () {
                $formatter = new NumberFormatter('es_ES', NumberFormatter::DECIMAL);
                $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
                return $formatter->format(Contrato::distinct('cups')->count()) . ' CUPS';
            })
                ->description('Puntos de suministro únicos')
                ->descriptionIcon('heroicon-o-map-pin')
                ->color('primary'),
        ];
    }
}
