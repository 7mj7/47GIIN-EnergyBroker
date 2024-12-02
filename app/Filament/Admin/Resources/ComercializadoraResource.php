<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ComercializadoraResource\Pages;
use App\Filament\Admin\Resources\ComercializadoraResource\RelationManagers;
use App\Models\Comercializadora;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ComercializadoraResource extends Resource
{
    protected static ?string $model = Comercializadora::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tablas';

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
                        TextInput::make('nombre')
                            ->label('Comercializadora')
                            ->required()
                            ->maxLength(15)
                            ->unique(ignoreRecord: true),
                        TextInput::make('nombre_fiscal')
                            ->label('Nombre Fiscal')
                            ->nullable(),
                        TextInput::make('cif')
                            ->label('CIF')
                            ->length(9),
                        Toggle::make('activo')
                            ->default(true)
                    ])->columns(3),
                Forms\Components\Section::make("Gestor")
                    ->schema([
                        TextInput::make('gestor_nombre')
                            ->label('Nombre del Gestor')
                            ->nullable(),
                        TextInput::make('gestor_telefono')
                            ->label('Teléfono del Gestor')
                            ->tel()
                            ->regex('/^(?:\+34|0034)?[6-9][0-9]{8}$/')
                            ->validationMessages([
                                'regex' => 'Debe ser un número español válido (opcional +34 o 0034, seguido de 9 dígitos)'
                            ])
                            ->helperText('Ejemplos: 666777888, +34666777888, 0034666777888')
                            ->nullable(),
                        TextInput::make('gestor_email')
                            ->label('Email del Gestor')
                            ->email()
                            ->nullable(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('activo')
                    ->label('Activa')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Comercializadora')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nombre_fiscal')
                    ->label('Nombre Fiscal')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cif')
                    ->label('CIF')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gestor_nombre')
                    ->label('Gestor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gestor_telefono')
                    ->label('Tel. Gestor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gestor_email')
                    ->label('Email Gestor')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
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
            'index' => Pages\ListComercializadoras::route('/'),
            'create' => Pages\CreateComercializadora::route('/create'),
            'edit' => Pages\EditComercializadora::route('/{record}/edit'),
        ];
    }
}
