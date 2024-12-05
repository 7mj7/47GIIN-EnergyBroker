<?php

namespace App\Filament\Admin\Resources\TarifaEnergiaResource\Pages;

use App\Filament\Admin\Resources\TarifaEnergiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTarifaEnergias extends ListRecords
{
    protected static string $resource = TarifaEnergiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
