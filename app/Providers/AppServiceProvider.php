<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Validator;
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

        // Validar CUPS
        Validator::extend('cups_valido', function ($attribute, $value, $parameters, $validator) {
            return validarCUPS($value);
        }, 'El CUPS no es válido.');

        // Validar IBAN
        Validator::extend('iban_valido', function ($attribute, $value, $parameters, $validator) {
            return validarIBAN($value);
        }, 'El IBAN no es válido.');
    }
}
