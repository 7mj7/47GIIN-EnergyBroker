<?php

namespace App\Filament\Admin\Resources\ProvinciaResource\Pages;

use App\Filament\Admin\Resources\ProvinciaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProvincias extends ManageRecords
{
    protected static string $resource = ProvinciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
