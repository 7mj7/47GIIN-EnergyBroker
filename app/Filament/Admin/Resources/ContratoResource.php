<?php

namespace App\Filament\Admin\Resources;

use DateTime;
use Filament\Forms;
use Filament\Tables;
use App\Models\Tercero;
use App\Models\Contrato;
use Filament\Forms\Form;
use App\Models\Suministro;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\CreateAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ContratoResource\Pages;
use App\Filament\Admin\Resources\ContratoResource\RelationManagers;

class ContratoResource extends Resource
{
    protected static ?string $model = Contrato::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Titular
                Section::make('Tercero')
                    ->compact()
                    ->columnSpanFull()
                    ->columns(6)
                    ->schema(static::getTerceroSchema()),
                // Suministgro
                Section::make('Suministro')
                    ->compact()
                    ->columnSpanFull()
                    ->columns(6)
                    ->schema(static::getSuministroSchema()),
                // Contrato
                Section::make('Contrato')
                    ->compact()
                    ->columnSpanFull()
                    ->columns(4)
                    ->schema(static::getContratoSchema()),

            ]);
    }

    protected static function getTerceroSchema(): array
    {
        return [
            // Campos de la primera sección
            Select::make('tercero_id')
                ->relationship('tercero', 'nombre', function ($query) {
                    return $query->where('user_id', auth()->id());
                })
                ->label('Tercero')
                ->placeholder('Seleccionar Tercero')
                ->columnSpan(2)
                ->searchable()
                ->live() // Importante para la reactividad
                ->afterStateUpdated(function (callable $set, $state) {
                    if ($state) {
                        $tercero = Tercero::find($state);
                        if ($tercero) {
                            $set('nif_titular', $tercero->nif);
                            $set('nombre_titular', $tercero->nombre);
                        }
                    } else {
                        // Limpiar todos los campos cuando no hay tercero seleccionado
                        $set('suministro_id', null);
                        $set('nif_titular', null);
                        $set('nombre_titular', null);
                    }
                })
                ->required()
                ->createOptionForm([
                    Section::make()
                        ->columns(3)
                        ->schema([
                            TextInput::make('nif')
                                ->label('NIF/CIF')
                                ->required()
                                ->maxLength(9),
                            TextInput::make('nombre')
                                ->label('Nombre')
                                ->columnSpan(2)
                                ->required()
                                ->maxLength(255),
                            TextInput::make('telefono')
                                ->tel(),
                            TextInput::make('email')
                                ->columnSpan(2)
                                ->email(),
                        ]),

                    Hidden::make('user_id')
                        ->default(fn() => auth()->id()),
                ])
                ->createOptionAction(function (Action $action) {
                    $action
                        ->modalHeading('Crear Nuevo Tercero')
                        ->label('Crear Tercero')
                        ->modalSubmitActionLabel('Crear Tercero')
                        ->successNotificationTitle('Tercero creado correctamente');
                }),
            TextInput::make('nif_titular')
                ->label('NIF del Titular')
                ->readOnly()
                ->required()
                ->maxLength(9),
            Textinput::make('nombre_titular')
                ->required()
                ->readOnly()
                ->columnSpan(2)
                ->maxLength(255),

        ];
    }

    protected static function getSuministroSchema(): array
    {
        return [
            // Campos de la segunda sección
            //static::getSuministroSchema()
            Select::make('suministro_id')
                ->columnSpan(3)
                ->label('Suministro')
                ->options(function (callable $get) {
                    $terceroId = $get('tercero_id');

                    if (!$terceroId) {
                        return [];
                    }

                    return Suministro::query()
                        ->with('tarifaAcceso') // Eager loading de la relación
                        ->where('tercero_id', $terceroId)
                        ->get()
                        ->mapWithKeys(function ($suministro) {
                            $cups_final = substr($suministro->cups, -6);
                            return [
                                $suministro->id => "{$cups_final} - {$suministro->tarifaAcceso->nombre} - {$suministro->direccion}"
                            ];
                        });
                })
                ->searchable()
                ->required()
                ->preload()
                ->live()
                ->afterStateUpdated(function (callable $set, $state) {
                    if ($state) {
                        $suministro = Suministro::find($state);
                        if ($suministro) {
                            $set('cups', $suministro->cups);
                            $set('tarifa_acceso', $suministro->tarifaAcceso->nombre);
                            $set('consumo_anual', $suministro->consumo_anual);
                            $set('direccion', $suministro->direccion);
                            $set('codigo_postal', $suministro->codigo_postal);
                            $set('poblacion', $suministro->poblacion);
                            $set('provincia', $suministro->provincia);
                        }
                    } else {
                        // Limpiar todos los campos cuando no hay tercero seleccionado
                        $set('cups', null);
                        $set('tarifa_acceso', null);
                        $set('consumo_anual', null);
                        $set('direccion', null);
                        $set('codigo_postal', null);
                        $set('poblacion', null);
                        $set('provincia', null);
                    }
                })
                ->createOptionForm([
                    Section::make()
                        ->columns(3)
                        ->schema([
                            // Schema del suministro
                        ]),

                    Hidden::make('user_id')
                        ->default(fn() => auth()->id()),
                ])
                ->createOptionAction(function (Action $action) {
                    $action
                        ->modalHeading('Crear Nuevo Suministro')
                        ->label('Crear Suministro')
                        ->modalSubmitActionLabel('Crear Suministro')
                        ->successNotificationTitle('Suministro creado correctamente');
                }),

            Grid::make(3) // Crea un grid de 3 columnas
                ->schema([
                    TextInput::make('cups')
                        ->label('CUPS')
                        ->required()
                        ->readOnly()
                        ->maxLength(20),
                    TextInput::make('tarifa_acceso')
                        ->label('Tarifa de Acceso')
                        ->required()
                        ->readOnly()
                        ->maxLength(15),
                    TextInput::make('consumo_anual')
                        ->label('Consumo Anual')
                        //->required()
                        ->readOnly()
                        ->numeric(),
                ]),
            Grid::make(3) // Crea un grid de 3 columnas
                ->schema([
                    TextInput::make('direccion')
                        ->columnSpan(3)
                        ->label('Dirección')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('codigo_postal')
                        ->label('C.P.')
                        ->required()
                        ->maxLength(5),
                    TextInput::make('poblacion')
                        ->label('Población')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('provincia')
                        ->label('Provincia')
                        ->required()
                        ->maxLength(255),
                ]),
        ];
    }

    protected static function getContratoSchema(): array
    {
        return [
            Select::make('comercializadora_id')
                ->label('Comercialidad')
                //->relationship(name: 'comercializadora', titleAttribute: 'nombre')
                ->relationship('comercializadora', 'nombre', function ($query) {
                    $query->where('activo', 1);
                })
                ->required()
                ->preload()
                ->searchable()
                ->reactive() // Hace que el campo sea reactivo
                ->afterStateUpdated(function (callable $set) {
                    $set('tarifa_energia_id', null); // Limpia tarifa_energia_id al cambiar comercializadora_id
                })
                ->getOptionLabelUsing(function ($value) {
                    // Verifica si el valor proporcionado es nulo.
                    // Si es nulo, retorna null para que no se muestre ninguna etiqueta.
                    if (is_null($value)) {
                        return null;
                    }
                    // Busca la comercializadora en la base de datos utilizando el ID proporcionado.
                    // Esta búsqueda no filtra por el estado 'activo', lo que permite obtener
                    // la comercializadora incluso si no está activa.
                    $comercializadora = \App\Models\Comercializadora::find($value);

                    // Si se encuentra la comercializadora, retorna su nombre.
                    // Si no se encuentra (puede que el ID no exista), retorna null.
                    return $comercializadora ? $comercializadora->nombre : null;
                }),
            Select::make('tarifa_energia_id')
                ->columnSpan(2)
                ->label('Tarifa de Energía')
                //->relationship('tarifaEnergia', 'nombre', function ($query) {
                //    $query->where('activo', 1);
                //})
                ->relationship('tarifaEnergia', 'nombre', function ($query, callable $get) {
                    $comercializadoraId = $get('comercializadora_id');
                    if ($comercializadoraId) {
                        $query->where('activo', 1)
                            ->where('comercializadora_id', $comercializadoraId);
                    } else {
                        // Si no hay comercializadora seleccionada, no devolver resultados
                        $query->whereRaw('0 = 1');
                    }
                })
                ->disabled(function (callable $get) {
                    // Deshabilita el select si no hay tarifas disponibles
                    $comercializadoraId = $get('comercializadora_id');
                    if (!$comercializadoraId) {
                        return true;
                    }

                    // Verifica si existen tarifas activas para la comercializadora seleccionada
                    return !\App\Models\TarifaEnergia::where('activo', 1)
                        ->where('comercializadora_id', $comercializadoraId)
                        ->exists();
                })
                ->getOptionLabelUsing(function ($value) {
                    if (is_null($value)) {
                        return null;
                    }
                    $tarifaEnergia = \App\Models\TarifaEnergia::find($value);
                    return $tarifaEnergia ? $tarifaEnergia->nombre : null;
                })
                ->required()
                ->preload()
                ->searchable(),
            DatePicker::make('fecha_firma')
                ->label('Fecha de Firma')
                ->default(now())
                ->required(),
            TextInput::make('iban')
                ->label('IBAN')
                ->columnSpan(2)
                ->placeholder('ES00XXXXXX12345678901234') // Placeholder ejemplo
                ->helperText('Introduce un IBAN válido. Ejemplo: ES9121000418450200051332')
                ->maxLength(24) // Longitud máxima del IBAN español    
                ->autocomplete(false)
                ->rules([
                    'regex:/^ES\d{22}$/', // Regex para validar IBAN español
                    'iban_valido'
                ])
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    // Limpia espacios y convierte a mayúsculas
                    $cleaned = strtoupper(str_replace(' ', '', $state));
                    $set('iban', $cleaned); // Asegúrate de pasar el nombre del campo y el valor
                }),
            DatePicker::make('fecha_activacion')
                ->label('Fecha de Activación'),
            DatePicker::make('fecha_baja')
                ->label('Fecha de Baja'),

        ];
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('nombre_titular')
                    ->label('Titular')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('cups')
                    ->label('CUPS')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => substr($state, -6)),
                TextColumn::make('tarifa_acceso')
                    ->label('Tarifa de Acceso')
                    ->sortable(),
                TextColumn::make('consumo_anual')
                    ->label('Consumo Anual (kWh)')
                    ->sortable(),
                TextColumn::make('comercializadora.nombre')
                    ->label('Comercializadora')
                    ->sortable(),
                TextColumn::make('tarifaEnergia.nombre')
                    ->label('Tarifa de Energía')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tarifa_acceso')
                    ->label('Tarifa de Acceso')
                    ->multiple()
                    ->options(function () {
                        return Contrato::query()
                            ->select('tarifa_acceso')
                            ->distinct()
                            ->orderBy('tarifa_acceso')
                            ->pluck('tarifa_acceso', 'tarifa_acceso')
                            ->toArray();
                    })
                    ->placeholder('Seleccione una Tarifa'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('printRecord')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-printer')
                    ->tooltip('Imprimir Contrato')
                    ->action(function (Contrato $record) {

                        // Obtener los comentarios relacionados
                        $comments = $record->filamentComments()->with('user')->get();


                        $pdf = Pdf::loadView('pdf.contrato-show', [
                            'record' => $record,
                            'comments' => $comments
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, "contrato-{$record->id}.pdf");
                    }),

            ])
            ->headerActions([
                Tables\Actions\Action::make('exportPDF')
                    ->label('PDF')
                    ->icon('heroicon-o-printer')
                    ->action(function ($livewire) {
                        // Obtener los registros filtrados
                        $records = $livewire->getFilteredTableQuery()->get();

                        $pdf = Pdf::loadView('pdf.contratos-list', [
                            'records' => $records
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'contratos.pdf');
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    BulkAction::make('exportPDF')
                        ->label('Exportar a PDF')
                        ->icon('heroicon-o-printer')
                        ->action(function ($records) {
                            $pdf = Pdf::loadView('pdf.contratos-list', [
                                'records' => $records
                            ]);

                            return response()->streamDownload(function () use ($pdf) {
                                echo $pdf->output();
                            }, 'registros.pdf');
                        })
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContratos::route('/'),
            'create' => Pages\CreateContrato::route('/create'),
            'edit' => Pages\EditContrato::route('/{record}/edit'),
        ];
    }
}
