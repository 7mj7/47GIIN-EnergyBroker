<?php

namespace App\Filament\Admin\Resources\PrecioHorarioMercadoDiarioResource\Pages;

use App\Filament\Admin\Resources\PrecioHorarioMercadoDiarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrecioHorarioMercadoDiario extends EditRecord
{
    protected static string $resource = PrecioHorarioMercadoDiarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
