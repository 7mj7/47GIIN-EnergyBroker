<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// En este artchivo van los eventos programados
// Añadir el Comando para Laravel: Dentro del editor, añade la siguiente línea para que el cron job 
// ejecute el scheduler de Laravel cada minuto:
// * * * * * cd /ruta/a/tu/proyecto && php artisan schedule:run >> /dev/null 2>&1

// Programar el comando para que se ejecute todos los días a las 14:40
Schedule::command('omie:descargar-precios-horarios')
    ->dailyAt('14:40')
    ->description('Descarga precios horarios todos los días a las 14:40');
