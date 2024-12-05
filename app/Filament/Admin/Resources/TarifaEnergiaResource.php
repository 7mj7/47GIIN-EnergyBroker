<?php

namespace App\Filament\Admin\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TarifaAcceso;
use App\Models\TarifaEnergia;
use Filament\Resources\Resource;
use App\Enums\TiposTarifaEnergia;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\TarifaEnergiaResource\Pages;
use App\Filament\Admin\Resources\TarifaEnergiaResource\RelationManagers;

class TarifaEnergiaResource extends Resource
{
    protected static ?string $model = TarifaEnergia::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup = 'Tablas';

    public static function getModelLabel(): string
    {
        return 'Tarifa de Energía';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tarifas de Energía';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos de la Tarifa de Energía')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('ID')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete(false)
                            ->columnSpan(2),
                        Forms\Components\Select::make('comercializadora_id')
                            ->label('Comercializadora')
                            ->relationship('comercializadora', 'nombre') // name, titleAttribute
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('tarifa_acceso_id')
                            ->relationship(name: 'tarifaAcceso', titleAttribute: 'nombre')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $tarifaAcceso = TarifaAcceso::find($state);
                                    //dd($tarifaAcceso->tipo_energia->value); // Mostrar alerta con el valor de tipo_energia
                                    $set('tipo_energia', $tarifaAcceso->tipo_energia->value);
                                }
                            })
                            ->afterStateHydrated(function (callable $set, $state) {
                                if ($state) {
                                    $tarifaAcceso = TarifaAcceso::find($state);
                                    $set('tipo_energia', $tarifaAcceso->tipo_energia->value);
                                }
                            }),
                        Forms\Components\Hidden::make('tipo_energia'),
                        Select::make('tipo_tarifa')
                            ->label('Tipo de Tarifa')
                            ->options(TiposTarifaEnergia::class)
                            ->required(),
                        Forms\Components\DatePicker::make('valida_desde')
                            ->label('Válida Desde')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('valida_hasta')
                            ->label('Válida Hasta'),
                        Forms\Components\Toggle::make('activo')
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true)
                            ->required(),
                    ])->columns(5),
                Section::make('Precios de Electricidad')
                    ->visible(fn(callable $get) => $get('tipo_energia') === 'E')
                    ->schema([
                        Fieldset::make('Potencia €/kW/dia')
                            ->columns(6)
                            ->schema([
                                Forms\Components\TextInput::make('pp_p1')
                                    ->label('P1')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pp_p2')
                                    ->label('P2')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pp_p3')
                                    ->label('P3')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pp_p4')
                                    ->label('P4')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pp_p5')
                                    ->label('P5')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pp_p6')
                                    ->label('P6')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                            ]),
                        Fieldset::make('Energia: cent(€)/kWh')
                            ->columns(6)
                            ->schema([
                                Forms\Components\TextInput::make('pe_p1')
                                    ->label('P1')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pe_p2')
                                    ->label('P2')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pe_p3')
                                    ->label('P3')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pe_p4')
                                    ->label('P4')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pe_p5')
                                    ->label('P5')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                                Forms\Components\TextInput::make('pe_p6')
                                    ->label('P6')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->step(0.000001)  // Define 6 decimales
                                    ->rules('numeric|min:0'),
                            ]),
                    ])->columns(6),
                Section::make('Precios de Gas')
                    ->visible(fn(callable $get) => $get('tipo_energia') === 'G')
                    ->schema([]),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('comercializadora.nombre')
                    ->label('Comercializadora')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tarifaAcceso.tipo_energia')
                    ->label('Energía')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tarifaAcceso.nombre')
                    ->label('TAR.')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_tarifa')
                    ->label('Tipo'),
                Tables\Columns\TextColumn::make('valida_desde')
                    ->label('Valida Desde')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('valida_hasta')
                    ->label('Valida Hasta')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('activo')
                    ->label('Activa')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('F. Creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('F. Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

                // Filtro por comercializadora
                Tables\Filters\SelectFilter::make('comercializadora_id')
                    ->label('Comercializadora')
                    ->options(
                        \App\Models\TarifaEnergia::query()
                            ->join('comercializadoras', 'tarifas_energia.comercializadora_id', '=', 'comercializadoras.id')
                            ->distinct()
                            ->pluck('comercializadoras.nombre', 'tarifas_energia.comercializadora_id')
                            ->toArray()

                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id', 'desc')
        ;
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
            'index' => Pages\ListTarifaEnergias::route('/'),
            'create' => Pages\CreateTarifaEnergia::route('/create'),
            'edit' => Pages\EditTarifaEnergia::route('/{record}/edit'),
        ];
    }
}
