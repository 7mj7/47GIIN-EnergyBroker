<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\PrecioHorarioMercadoDiario;


class PreciosHorariosMercadoDiarioService
{
    public function descargarYProcesarFichero($fecha = null): bool
    {
        try {
            $fechaFormateada = $this->obtenerFechaFormateada($fecha);
            $version = 1;
            $datosActualizados = false;
    
            while (true) {
                $contenido = $this->descargarPBDC($fechaFormateada, ".{$version}");
                
                if (!$contenido) {
                    // Si no hay contenido y nunca hemos descargado datos, es un error
                    if (!$datosActualizados) {
                        throw new \RuntimeException("No se pudo descargar ninguna versión para la fecha: {$fechaFormateada}");
                    }
                    // Si ya teníamos datos, simplemente terminamos el bucle
                    break;
                }
    
                // Procesamos el contenido
                $this->procesarPBDC($contenido);
                $datosActualizados = true;
                Log::info("Datos actualizados correctamente para fecha {$fechaFormateada} (versión {$version})");
                
                $version++;
            }
    
            return true;
        } catch (\Exception $e) {
            Log::error("Error al descargar y procesar fichero OMIE: " . $e->getMessage());
            throw new \RuntimeException("Error en el proceso de descarga: " . $e->getMessage());
        }
    }


    /**
     * Procesa el contenido de un fichero de precios horarios del mercado diario de OMIE.
     *
     * @param string $contenidoFichero Contenido del fichero a procesar.
     *
     * @return array Un array con los datos procesados.
     */
    function procesarPBDC($contenidoFichero)
    {

        // Dividir el contenido en líneas
        $lineas = explode("\n", $contenidoFichero);

        // Inicializar un array para almacenar los datos procesados
        $datosProcesados = [];

        // Recorrer cada línea
        foreach ($lineas as $linea) {
            // Ignorar líneas vacías o que no contienen datos válidos
            if (trim($linea) === '' || $linea === '*') {
                continue;
            }

            // Dividir la línea en campos
            $campos = explode(';', $linea);

            // Asegurarse de que la línea tiene el número correcto de campos
            if (count($campos) < 7) {
                continue;
            }

            // Extraer los campos
            $anio = (int)$campos[0];
            $mes = (int)$campos[1];
            $dia = (int)$campos[2];
            $hora = (int)$campos[3];
            $marginalPT = (float)$campos[4];
            $marginalES = (float)$campos[5];

            // Almacenar los datos procesados
            PrecioHorarioMercadoDiario::updateOrCreate(
                // Criterio de selección
                [
                    'anio' => $anio,
                    'mes' => $mes,
                    'dia' => $dia,
                    'hora' => $hora,
                ],
                // Campos a actualizar
                [
                    'marginalPT' => $marginalPT,
                    'marginalES' => $marginalES,
                ]
            );
        }

        return $datosProcesados;
    }

    private function obtenerFechaFormateada(?string $fecha): string
    {
        try {
            return $fecha
                ? Carbon::parse($fecha)->format('Ymd')
                : Carbon::tomorrow()->format('Ymd');
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("Formato de fecha inválido: {$fecha}");
        }
    }


    // PBDC :  Programa Diario Base de Casación
    private function descargarPBDC(string $fecha, string $version): ?string
    {
        $urlBase = "https://www.omie.es/es/file-download?parents%5B0%5D=marginalpdbc&filename=marginalpdbc_{$fecha}";
        $url = $urlBase . $version;

    
        try {
            $response = Http::timeout(30)
                ->retry(3, 100)
                ->get($url);

            if ($response->successful() && strlen($response->body()) > 0) {
                Log::info("Archivo OMIE versión {$version} descargado exitosamente: {$url}");
                return $response->body();
            }
        } catch (\Exception $e) {
            Log::warning("Error al intentar descargar versión {$version}: " . $e->getMessage());
            return null;
        }

        return null;
    }
}
