<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Tercero;
use App\Models\Contrato;
use Filament\Forms\Form;
use App\Models\Suministro;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\CreateAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ContratoResource\Pages;
use App\Filament\Admin\Resources\ContratoResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

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
        return [];
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
                    ->sortable(),
                TextColumn::make('cups')
                    ->label('CUPS')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
