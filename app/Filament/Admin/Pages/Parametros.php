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
    public ?array $parametrosContacto = [];

    public function mount()
    {
        // Cargar configuraciones y organizarlas en arrays
        $this->parametrosFiscales = Parametro::getByGrupo('fiscal');
        $this->parametrosContacto = Parametro::getByGrupo('contacto');
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


            Section::make('Datos de Contacto')
                ->schema([
                    TextInput::make('parametrosContacto.telefono')
                        ->label('Teléfono')
                        ->tel()
                        ->regex('/^(?:\+34|0034)?[6-9][0-9]{8}$/')
                        ->validationMessages([
                            'regex' => 'Debe ser un número español válido (opcional +34 o 0034, seguido de 9 dígitos)',
                        ])
                        ->helperText('Ejemplos: 666777888, +34666777888, 0034666777888')
                        ->autocomplete(false)
                        ->statePath('parametrosContacto.telefono'),
                    TextInput::make('parametrosContacto.email')
                        ->label('Email')
                        ->email()
                        ->autocomplete(false)
                        ->statePath('parametrosContacto.email'),
                ])->columns(2),





            \Filament\Forms\Components\Actions::make([
                \Filament\Forms\Components\Actions\Action::make('Guardar Configuraciones')
                    ->action('saveSettings')
                    ->color('primary')
                    ->icon('heroicon-o-archive-box-arrow-down'),
            ]),
        ];
    }


    public  function getRules(): array
    {
        return [
            'parametrosContacto.email' => [
                'required',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'max:255'
            ],
            'parametrosContacto.telefono' => [
                'required',
                'regex:/^(?:\+34|0034)?[6-9][0-9]{8}$/'
            ],
            'parametrosFiscales.nombre' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'parametrosFiscales.nif' => [
                'required',
                'string',
                'regex:/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$|^([0-9]{8})([A-Z])$/'
            ],
            'parametrosFiscales.codigo_postal' => [
                'required',
                'regex:/^[0-9]{5}$/'
            ]
        ];
    }

    public function getValidationMessages(): array
    {
        return [
            // Parametros Fiscales            
            'parametrosFiscales.nombre.min' => 'El nombre debe tener al menos 3 caracteres', // Mensaje personalizado para min
            'parametrosFiscales.nif.regex' => 'El NIF/CIF debe tener un formato valido',
            'parametrosFiscales.codigo_postal.regex' => 'El código postal debe tener 5 dígitos',

            // Parametros de Contacto
            //'parametrosContacto.email.required' => 'El email es obligatorio',
            'parametrosContacto.email.regex' => 'El formato del email no es válido',
            'parametrosContacto.telefono.regex' => 'El teléfono debe ser un número español válido',
    
        ];
    }



    // Método para guardar las configuraciones
    public function saveSettings()
    {
        $this->validate(
            $this->getRules(),
            $this->getValidationMessages()
        );

        // Guardar los parámetros Fiscales
        foreach ($this->parametrosFiscales as $nombre => $valor) {
            // Actualizar o crear el parámetro
            Parametro::setParametro('fiscal', $nombre, $valor);
        }

        // Guardar los parámetros de Contacto
        foreach ($this->parametrosContacto as $nombre => $valor) {
            // Actualizar o crear el parámetro
            Parametro::setParametro('contacto', $nombre, $valor);
        }


        \Filament\Notifications\Notification::make()
            ->title('Configuraciones actualizadas correctamente.')
            ->success()
            ->send();
    }
}
