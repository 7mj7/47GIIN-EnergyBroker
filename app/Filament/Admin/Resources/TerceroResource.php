<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Tercero;
use Filament\Forms\Form;
use App\Models\Provincia;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\TerceroResource\Pages;
use App\Filament\Admin\Resources\TerceroResource\RelationManagers;

class TerceroResource extends Resource
{
    protected static ?string $model = Tercero::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';


    // Solo contamos los terceros del usuario actual
    public static function getNavigationBadge(): ?string
    {
        // return static::getModel()::count();
        return static::getModel()::where('user_id', Auth::id())->count();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();


        $user = Auth::user();

        // Verificar si el usuario tiene el rol de Administrador
        if (!$user->hasRole('Administrador')) {

            // Si no es un administrador, solo mostrar sus terceros
            $query->where('user_id', $user->id);

            /*
            if ($user->hasRole('...')) {
                //$vendedoresIds = $user->getAllSubordinatesIds(); // Método que debes implementar
                //$vendedoresIds[] = $user->id; // Incluir al propio gerente
                //$query->whereIn('vendedor_id', $vendedoresIds);
            } else {
                // Si es un vendedor, solo mostrar sus terceros
                $query->where('user_id', $user->id);                
            }*/
        }

        return $query;
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('nif')
                                    ->label('NIF/CIF')
                                    ->maxLength(15)
                                    ->autocomplete(false),
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->autocomplete(false),
                                Forms\Components\TextInput::make('contacto')
                                    ->label('Persona de Contacto')
                                    ->maxLength(255)
                                    ->autocomplete(false),
                                Forms\Components\TextInput::make('telefono1')
                                    ->tel()
                                    ->maxLength(255)
                                    ->autocomplete(false),
                                Forms\Components\TextInput::make('telefono2')
                                    ->tel()
                                    ->maxLength(255)
                                    ->autocomplete(false),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(255)
                                    ->autocomplete(false),
                                Forms\Components\Textarea::make('notas')
                                    ->columnSpanFull()
                                    ->autocomplete(false),
                            ])->columns(3),
                        Tabs\Tab::make('Dirección Fiscal')
                            ->schema([
                                Forms\Components\TextInput::make('direccion')
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
                                    ->maxLength(50)
                                    ->autocomplete(false),
                                Forms\Components\Select::make('provincia')
                                    ->label('Provincia')
                                    ->options(Provincia::all()->pluck('nombre', 'nombre'))
                                    ->searchable(),
                            ])->columns(3),
                    ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nif')
                    ->label('NIF/CIF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('suministros_count')
                    ->label('Suministros')
                    //->sortable()
                    ->badge()
                    ->getStateUsing(function (Tercero $record) {
                        return $record->suministros()->count();
                    }),
                Tables\Columns\TextColumn::make('direccion')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('codigo_postal')
                    ->label('C.P.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('poblacion')
                    ->sortable(),
                Tables\Columns\TextColumn::make('provincia')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('telefono1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono2')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contacto')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\SuministrosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTerceros::route('/'),
            'create' => Pages\CreateTercero::route('/create'),
            'edit' => Pages\EditTercero::route('/{record}/edit'),
        ];
    }
}
