<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CodigoPostalResource\Pages;
use App\Filament\Admin\Resources\CodigoPostalResource\RelationManagers;
use App\Models\CodigoPostal;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Provincia;

class CodigoPostalResource extends Resource
{
    protected static ?string $model = CodigoPostal::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $modelLabel = 'Código Postal';
    protected static ?string $pluralModelLabel = 'Códigos Postales';
    protected static ?string $navigationGroup = 'Tablas';



    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo_postal')
                    ->label('C.P.')
                    ->regex('/^[0-9]{5}$/')
                    ->maxLength(5)
                    ->minLength(5)
                    ->validationMessages([
                        'regex' => 'El código postal debe contener exactamente 5 números',
                        'required' => 'El código postal es obligatorio'
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if (strlen($state) === 5) {
                            // Extraer los dos primeros dígitos del CP
                            $codigoProvincia = substr($state, 0, 2);

                            // Buscar la provincia correspondiente
                            $provincia = Provincia::where('id', $codigoProvincia)->first();

                            if ($provincia) {
                                $set('provincia_id', $provincia->id);
                            }
                        }
                    }),
                Forms\Components\TextInput::make('poblacion')
                    ->label('Población')
                    ->minLength(2)
                    ->validationMessages([
                        'required' => 'La población es obligatoria',
                    ])
                    ->required(),
                Forms\Components\Select::make('provincia_id')
                    ->label('Provincia')
                    ->searchable()
                    ->relationship('provincia', 'nombre')
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'La provincia es obligatoria'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //TextColumn::make('id')->sortable(),
                TextColumn::make('codigo_postal')
                    ->label('C.P.')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('poblacion')
                    ->label('Población')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('provincia.nombre')
                    ->label('Provincia')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCodigoPostals::route('/'),
        ];
    }
}
