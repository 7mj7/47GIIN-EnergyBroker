<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProvinciaResource\Pages;
use App\Filament\Admin\Resources\ProvinciaResource\RelationManagers;
use App\Models\Provincia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProvinciaResource extends Resource
{
    protected static ?string $model = Provincia::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Tablas';

    // Oculta el botón de crear
    public static function canCreate(): bool
    {
        return false;
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Provincia')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                //]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProvincias::route('/'),
        ];
    }
}
