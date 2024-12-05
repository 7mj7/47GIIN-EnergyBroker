<?php

namespace App\Filament\Admin\Resources\TarifaEnergiaResource\Pages;

use App\Filament\Admin\Resources\TarifaEnergiaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTarifaEnergia extends EditRecord
{
    protected static string $resource = TarifaEnergiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
