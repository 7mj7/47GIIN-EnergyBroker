<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use App\Models\Parametro;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;


use Filament\Pages\Page;

class Parametros extends Page
{
    use InteractsWithForms;
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $title = 'Parámetros';

    protected static string $view = 'filament.admin.pages.parametros';

    // Definir una propiedad para almacenar los datos del formulario
    public ?array $parametrosFiscales = [];
    //public ?array $parametrosCorreo = [];

    public function mount()
    {
        // Cargar configuraciones y organizarlas en arrays
        $this->parametrosFiscales = Parametro::getByGrupo('fiscal');

        //$this->parametrosCorreo = Parametro::getByGrupo('correo');

    }

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Actions::make([
                \Filament\Forms\Components\Actions\Action::make('Guardar Configuraciones')
                    ->action('saveSettings')
                    ->color('primary')
                    ->icon('heroicon-o-archive-box-arrow-down'),
            ]),
            Section::make('Datos Fiscales')
                ->schema([
                    TextInput::make('parametrosFiscales.nombre')
                        ->label('Nombre de la Empresa')
                        ->statePath('parametrosFiscales.nombre')
                        ->columnSpan(2),
                    TextInput::make('parametrosFiscales.nif')
                        ->label('NIF')
                        ->statePath('parametrosFiscales.nif'),
                    TextInput::make('parametrosFiscales.direccion')
                        ->label('Dirección')
                        ->statePath('parametrosFiscales.direccion')
                        ->columnSpan(3),
                    TextInput::make('parametrosFiscales.codigo_postal')
                        ->label('Codigo Postal')
                        ->statePath('parametrosFiscales.codigo_postal'),
                    TextInput::make('parametrosFiscales.poblacion')
                        ->label('Poblacion')
                        ->statePath('parametrosFiscales.poblacion'),
                    TextInput::make('parametrosFiscales.provincia')
                        ->label('Provincia')
                        ->statePath('parametrosFiscales.provincia'),
                ])->columns(3),

            /*
            Section::make('Configuraciones de Correo')
                ->schema([
                    TextInput::make('parametrosCorreo.correo_envio')
                        ->label('Correo Electrónico de Envío')
                        ->statePath('parametrosCorreo.correo_envio'),

                    TextInput::make('parametrosCorreo.smtp_servidor')
                        ->label('Servidor SMTP')
                        ->statePath('parametrosCorreo.smtp_servidor'),

                    TextInput::make('parametrosCorreo.smtp_puerto')
                        ->label('Puerto SMTP')
                        ->statePath('parametrosCorreo.smtp_puerto'),
                ]),
            */

            \Filament\Forms\Components\Actions::make([
                \Filament\Forms\Components\Actions\Action::make('Guardar Configuraciones')
                    ->action('saveSettings')
                    ->color('primary')
                    ->icon('heroicon-o-archive-box-arrow-down'),
            ]),
        ];
    }

    // Método para guardar las configuraciones
    public function saveSettings()
    {
        foreach ($this->parametrosFiscales as $nombre => $valor) {
            // Actualizar o crear el parámetro
            Parametro::setParametro('fiscal', $nombre, $valor);
        }

        /*
        foreach ($this->parametrosCorreo as $nombre => $valor) {
                // Actualizar o crear el parámetro
            Parametro::setParametro('correo', $nombre, $valor);
        }
        */

        \Filament\Notifications\Notification::make()
            ->title('Configuraciones actualizadas correctamente.')
            ->success()
            ->send();
    }
}
