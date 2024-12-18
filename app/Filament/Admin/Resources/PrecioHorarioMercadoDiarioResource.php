<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PrecioHorarioMercadoDiarioResource\Pages;
use App\Filament\Admin\Resources\PrecioHorarioMercadoDiarioResource\RelationManagers;
use App\Models\PrecioHorarioMercadoDiario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrecioHorarioMercadoDiarioResource extends Resource
{
    protected static ?string $model = PrecioHorarioMercadoDiario::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel = 'PBDC'; // PBDC: Programa Diario Base de Casación
    protected static ?string $navigationGroup = 'Tablas';
    protected static ?int $navigationSort = 99; // Lo coloco al final

    protected static ?string $modelLabel = 'Precio Horario Mercado Diario';
    protected static ?string $pluralModelLabel = 'Precios Horarios Mercado Diario';

    


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('anio')
                    ->label('Año')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('mes')
                    ->label('Mes')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('dia')
                    ->label('Día')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('hora')
                    ->label('Hora')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('marginalPT')
                    ->label('Marginal PT')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('marginalES')
                    ->label('Marginal ES')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->heading('PBDC: Programa Diario Base de Casación')
            ->columns([
                Tables\Columns\TextColumn::make('anio')
                    ->label('Año')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mes')
                    ->label('Mes')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dia')
                    ->label('Día')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hora')
                    ->label('Hora')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('marginalPT')
                    ->label('Marginal PT')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('marginalES')
                    ->label('Marginal ES')                    
                    ->numeric()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                //]),
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
            'index' => Pages\ListPrecioHorarioMercadoDiarios::route('/'),
            //'create' => Pages\CreatePrecioHorarioMercadoDiario::route('/create'),
            //'edit' => Pages\EditPrecioHorarioMercadoDiario::route('/{record}/edit'),
        ];
    }
}
