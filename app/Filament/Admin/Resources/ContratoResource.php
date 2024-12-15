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

class ContratoResource extends Resource
{
    protected static ?string $model = Contrato::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(2) // Crea un grid de 2 columnas
                    ->schema([
                        Section::make('Tercero')
                            ->compact()
                            ->columns(3)
                            ->schema([
                                // Campos de la primera sección
                                Select::make('tercero_id')
                                    ->relationship('tercero', 'nombre', function ($query) {
                                        return $query->where('user_id', auth()->id());
                                    })
                                    ->label('Tercero')
                                    ->placeholder('Seleccionar Tercero')
                                    ->columnSpanFull()
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
                                        TextInput::make('nombre')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('email')
                                            ->email()
                                            ->required(),
                                        TextInput::make('telefono')
                                            ->tel(),
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
                            ])
                            ->columnSpan(1), // Ocupa 1 columna

                        Section::make('Suministro')
                            ->compact()
                            ->schema([
                                // Campos de la segunda sección
                                Select::make('suministro_id')
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
                                    ->preload(),
                            ])
                            ->columnSpan(1), // Ocupa 1 columna
                    ]),





            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
