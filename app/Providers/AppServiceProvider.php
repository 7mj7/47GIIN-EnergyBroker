<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Tables\Table; // Para el formato de fechas

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {        
        // Formato de fechas        
        if (app()->getLocale() == 'es') {
            Table::$defaultDateTimeDisplayFormat = 'd-m-Y H:i:s';
            Table::$defaultDateDisplayFormat = 'd-m-Y';
        }
    }
}
