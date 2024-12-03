<?php

namespace App\Filament\Admin\Resources\EquipoVentaResource\Pages;

use App\Filament\Admin\Resources\EquipoVentaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipoVentas extends ListRecords
{
    protected static string $resource = EquipoVentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
