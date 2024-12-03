<?php

namespace App\Filament\Admin\Resources\EquipoVentaResource\Pages;

use App\Filament\Admin\Resources\EquipoVentaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipoVenta extends EditRecord
{
    protected static string $resource = EquipoVentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
