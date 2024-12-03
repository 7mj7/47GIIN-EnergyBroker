<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TarifaAccesoResource\Pages;
use App\Filament\Admin\Resources\TarifaAccesoResource\RelationManagers;
use App\Models\TarifaAcceso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use App\Enums\TiposEnergia;
use Filament\Tables\Filters\SelectFilter;

class TarifaAccesoResource extends Resource
{
    protected static ?string $model = TarifaAcceso::class;

    protected static ?string $navigationIcon = 'heroicon-o-battery-100';
    protected static ?string $navigationGroup = 'Tablas';


    public static function getModelLabel(): string
    {
        return 'Tarifa de Acceso';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tarifas de Acceso';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("General")
                    ->schema([
                        Select::make('tipo_energia')
                            ->label('Tipo de Energía')
                            ->options(TiposEnergia::class)
                            ->required(),
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(15)
                            ->autocomplete(false),
                        Forms\Components\Toggle::make('activo')
                            ->required()
                            ->inline(false)
                            ->default(true),
                    ])->columns(3),
                Forms\Components\Section::make("Otros Datos")
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_inicio'),
                        Forms\Components\DatePicker::make('fecha_fin'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /*Tables\Columns\TextColumn::make('tipo_energia')
                    ->searchable(),*/
                Tables\Columns\IconColumn::make('tipo_energia')
                    ->label('Tipo de Energía'),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Tarifa de Acceso')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Fecha Inicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_fin')
                    ->label('Fecha Fin')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups([
                Tables\Grouping\Group::make('tipo_energia')
                    ->label('Tipo de Energía'),
            ])
            ->defaultGroup('tipo_energia') // Para agrupar por tipo de energía
            ->filters([
                SelectFilter::make('tipo_energia')
                    ->label('Tipo de Energía')
                    ->options(TiposEnergia::class),
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->trueLabel('Activas')
                    ->falseLabel('Inactivas')
                    ->placeholder('Todas')
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
            'index' => Pages\ListTarifaAccesos::route('/'),
            'create' => Pages\CreateTarifaAcceso::route('/create'),
            'edit' => Pages\EditTarifaAcceso::route('/{record}/edit'),
        ];
    }
}
