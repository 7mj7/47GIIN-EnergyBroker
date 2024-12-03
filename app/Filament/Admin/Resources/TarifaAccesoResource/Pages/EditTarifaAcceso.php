<?php

namespace App\Filament\Admin\Resources\TarifaAccesoResource\Pages;

use App\Filament\Admin\Resources\TarifaAccesoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTarifaAcceso extends EditRecord
{
    protected static string $resource = TarifaAccesoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
