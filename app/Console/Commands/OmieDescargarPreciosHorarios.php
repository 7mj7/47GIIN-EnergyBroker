<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class OmieDescargarPreciosHorarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omie:descargar-precios-horarios {fecha?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Descarga los precios horarios del mercado diario desde OMIE';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener la fecha proporcionada
        $fecha = $this->argument('fecha');

        // Validar la fecha proporcionada
        if ($fecha) {
            try {
                $fecha = Carbon::parse($fecha)->toDateString();
            } catch (\Exception $e) {
                // Si hay un error al formatear la fecha, mostrar mensaje y terminar la ejecución
                $this->error("La fecha proporcionada no es válida. Terminando la ejecución.");
                exit; // Termina la ejecución
            }
        } else {
            // Si la fecha es nula, usar la fecha de mañana
            $fecha = Carbon::tomorrow()->toDateString();
        }

        // Llamar al servicio con la fecha proporcionada o con la fecha de mañana
        $servicio = app(\App\Services\PreciosHorariosMercadoDiarioService::class);
        $servicio->descargarYProcesarFichero($fecha);

        $this->info("Precios horarios descargados para la fecha: " . $fecha);
    }
}
