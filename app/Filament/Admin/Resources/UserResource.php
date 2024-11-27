<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $modelLabel = 'usuario';
    protected static ?string $pluralModelLabel = 'usuarios';
    protected static ?string $navigationGroup = 'Seguridad';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("")
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->autocomplete(false)
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->autocomplete(false)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateUser)
                            ->autocomplete(false)
                            ->maxLength(255)
                            ->rules([
                                'min:8',
                                'regex:/^(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).*$/',
                            ])
                            ->validationAttribute('contraseña')
                            ->validationMessages([
                                'min' => 'La :attribute debe tener al menos :min caracteres.',
                                'regex' => 'La :attribute debe incluir al menos un número y un carácter especial.',
                            ]),
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')->preload()
                            ->preload()
                            ->multiple()
                            ->required()
                            ->validationMessages([
                                'required' => 'El usuario debe tener al menos un rol.',
                            ]),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Usuario Activo')
                            ->default(true)
                            ->visible(function ($get, $record) {
                                // Si estamos editando un registro y el id es 1 (administrador), ocultamos el campo
                                if ($record && $record->id === 1) {
                                    return false;
                                }
                                return true;
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make("Datos de contacto")
                    ->schema([
                        Forms\Components\TextInput::make('phone1')
                            ->tel()
                            ->label('Teléfono principal')
                            ->regex('/^(?:\+34|0034)?[6-9][0-9]{8}$/')
                            ->validationMessages([
                                'regex' => 'Debe ser un número español válido (opcional +34 o 0034, seguido de 9 dígitos)',
                            ])
                            ->helperText('Ejemplos: 666777888, +34666777888, 0034666777888')
                            //->placeholder('+34666777888'),
                            ->autocomplete(false),
                    ])->columns(2),



                //Forms\Components\DateTimePicker::make('email_verified_at'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone1')
                    ->label('Teléfono')
                    ->searchable(),
                /*Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),*/
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
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
                SelectFilter::make('roles')
                ->relationship('roles', 'name')
                ->label('Filtrar por Rol')
                ->multiple()
                ->preload()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Collection $records, Tables\Actions\DeleteBulkAction $action) {
                            // Verificar si alguno de los registros seleccionados es el ID 1
                            if ($records->contains('id', 1)) {
                                Notification::make()
                                    ->danger()
                                    ->title('No se puede eliminar el usuario administrador')
                                    ->send();

                                $action->cancel();
                            }
                        }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
