<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EquipoVentaResource\Pages;
use App\Filament\Admin\Resources\EquipoVentaResource\RelationManagers;
use App\Models\EquipoVenta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipoVentaResource extends Resource
{
    protected static ?string $model = EquipoVenta::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Tablas';
    //protected static ?string $navigationLabel = 'Equipos de Venta';


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    //Devuelve el nombre del recurso en singular
    public static function getModelLabel(): string
    {
        return 'Equipo de Venta';
    }

    // Nombre del recurso en plural
    public static function getPluralModelLabel(): string
    {
        return 'Equipos de Venta';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("General")
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Equipo de Venta')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->autocomplete(false)
                            ->validationMessages([
                                'unique' => 'Ya existe un equipo de venta con el mismo nombre. Por favor, elige otro.',
                            ]),
                        Forms\Components\Toggle::make('activo')
                            ->required()
                            ->inline(false)
                            ->default(true),
                        Forms\Components\TextArea::make('descripcion')
                            ->label('Descripción')
                            ->columnSpan(2)
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Equipo de Venta')
                    ->searchable()
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
            'index' => Pages\ListEquipoVentas::route('/'),
            'create' => Pages\CreateEquipoVenta::route('/create'),
            'edit' => Pages\EditEquipoVenta::route('/{record}/edit'),
        ];
    }
}
