<?php

namespace App\Filament\Admin\Resources\TerceroResource\Pages;

use App\Filament\Admin\Resources\TerceroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTerceros extends ListRecords
{
    protected static string $resource = TerceroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
