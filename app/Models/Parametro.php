<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parametro extends Model
{
    use HasFactory;

    protected $table = 'parametros'; // Nombre de la tabla
    protected $fillable = ['grupo', 'nombre', 'valor',]; // 'bloqueado'

    /**
     * Obtiene los parámetros por grupo y los devuelve como array
     * @param string $grupo
     * @return array
     */
    public static function getByGrupo(string $grupo): array
    {
        return self::where('grupo', $grupo)
            ->pluck('valor', 'nombre')
            ->toArray();
    }

    /**
     * Obtiene el valor de un parámetro específico según su grupo y nombre
     * 
     * @param string $grupo      El grupo al que pertenece el parámetro
     * @param string $nombre     El nombre del parámetro a buscar
     * @param string|null $defaultValue Valor por defecto si el parámetro no existe (opcional)
     * 
     * @return string|null Retorna el valor del parámetro si existe, 
     *                     el valor por defecto si se especificó, 
     *                     o null si no existe y no se especificó valor por defecto
     * 
     * @example
     * // Obtener un valor con valor por defecto
     * $titulo = Parametro::getValorParametro('general', 'titulo_sitio', 'Mi Sitio Web');
     * 
     * // Obtener un valor sin valor por defecto
     * $valor = Parametro::getValorParametro('general', 'configuracion');
     */
    public static function getParametro(string $grupo, string $nombre, string $defaultValue = null): ?string
    {
        $parametro = self::where('grupo', $grupo)
            ->where('nombre', $nombre)
            ->first();

        return $parametro ? $parametro->valor : $defaultValue;
    }

    /**
     * Actualiza o crea un parámetro con los valores especificados
     * 
     * @param string $grupo      Grupo al que pertenece el parámetro
     * @param string $nombre     Nombre del parámetro
     * @param string $valor      Valor del parámetro
     * 
     * @return \App\Models\Parametro Retorna la instancia del parámetro actualizado o creado
     * 
     * @example
     * // Actualizar o crear un parámetro individual
     * Parametro::setParametro('titulo_sitio', 'Mi Sitio Web');
     * 
     * // Actualizar o crear un parámetro en un grupo específico
     * Parametro::setParametro('max_usuarios', '100', 'limites');
     */
    public static function setParametro(string $grupo, string $nombre, string $valor): self
    {
        return self::updateOrCreate(
            ['grupo' => $grupo, 'nombre' => $nombre],
            ['valor' => $valor]
        );
    }
}
