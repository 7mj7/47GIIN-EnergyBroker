<?php

namespace App\Filament\Admin\Resources\TarifaAccesoResource\Pages;

use App\Filament\Admin\Resources\TarifaAccesoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTarifaAccesos extends ListRecords
{
    protected static string $resource = TarifaAccesoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
