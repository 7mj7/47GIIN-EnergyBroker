<?php

namespace App\Filament\Admin\Resources\TerceroResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Provincia;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SuministrosRelationManager extends RelationManager
{
    protected static string $relationship = 'suministros';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Suministro')
                    ->schema([
                        Forms\Components\TextInput::make('cups')
                            ->label('CUPS')
                            ->required()
                            ->minLength(20)
                            ->maxLength(20)
                            ->rules(['cups_valido']) // Validar CUPS
                            ->helperText('Ejemplo: ES0021000010364454ZF')
                            ->autocomplete(false),
                        Select::make('tarifa_acceso_id')
                            ->relationship(name: 'tarifaAcceso', titleAttribute: 'nombre')
                            ->required(),
                        Forms\Components\TextInput::make('consumo_anual')
                            ->label('Consumo Anual (kWh)')
                            ->maxLength(255)
                            ->numeric()
                            ->integer(),
                    ])->columns(3),
                Section::make('Dirección del Suministro')
                    ->schema([
                        Forms\Components\TextInput::make('direccion')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete(false)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('codigo_postal')
                            ->label('C.P.')
                            ->regex('/^[0-9]{5}$/')
                            ->validationMessages([
                                'regex' => 'El código postal debe contener exactamente 5 números',
                            ])
                            ->autocomplete(false),
                        Forms\Components\TextInput::make('poblacion')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('provincia')
                            ->label('Provincia')
                            ->options(Provincia::all()->pluck('nombre', 'nombre'))
                            ->required()
                            ->searchable()
                            ->validationMessages([
                                'required' => 'La provincia es obligatoria.',
                            ]),
                    ])->columns(3),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('cups')
            ->columns([
                Tables\Columns\TextColumn::make('cups')
                    ->label('CUPS')
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => substr($state, -6)),
                Tables\Columns\TextColumn::make('tarifaAcceso.nombre')
                    ->label('Tarifa de Acceso')
                    ->sortable(),
                Tables\Columns\TextColumn::make('consumo_anual')
                    ->label('Consumo Anual (kWh)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('direccion')
                    ->label('Dirección'),
                Tables\Columns\TextColumn::make('codigo_postal')
                    ->label('C.P.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('poblacion')
                    ->label('Población')
                    ->sortable(),
                Tables\Columns\TextColumn::make('provincia')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tarifa_acceso_id')
                    ->label('Tarifa de Acceso')
                    ->relationship('tarifaAcceso', 'nombre')
                    ->preload()
                    ->multiple(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
