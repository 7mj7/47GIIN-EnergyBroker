<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\PrecioHorarioMercadoDiario;

class PreciosHorariosChart extends ChartWidget
{
    protected static ?string $heading = 'Precio horario del mercado diario';
    protected static ?int $sort = 20;
    //protected int | string | array $columnSpan = 'full';
    


    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // Obtener la fecha actual
        $fechaActual = now();
        $anio = $fechaActual->year;
        $mes = $fechaActual->month;
        $dia = $fechaActual->day;

        // Consultar los datos del modelo para la fecha actual
        $datosDeHoy = PrecioHorarioMercadoDiario::where('anio', $anio)
            ->where('mes', $mes)
            ->where('dia', $dia)
            ->get();


        // Preparar los datos para el gráfico
        $labels = [];
        $data = [];

        foreach ($datosDeHoy as $registro) {
            $labels[] = $registro->hora; // Asumiendo que tienes un campo 'hora'
            $data[] = $registro->marginalES; // O cualquier otro campo que quieras graficar
        }

        return [
            'datasets' => [
                [
                    'label' => 'Precio Marginal ES - '.$fechaActual->format('d/m/Y'),
                    'data' => $data,
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
