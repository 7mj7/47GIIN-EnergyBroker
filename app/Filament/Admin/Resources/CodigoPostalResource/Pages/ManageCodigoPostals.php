<?php

namespace App\Filament\Admin\Resources\CodigoPostalResource\Pages;

use App\Filament\Admin\Resources\CodigoPostalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCodigoPostals extends ManageRecords
{
    protected static string $resource = CodigoPostalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
