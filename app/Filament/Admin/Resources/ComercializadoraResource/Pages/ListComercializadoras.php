<?php

namespace App\Filament\Admin\Resources\ComercializadoraResource\Pages;

use App\Filament\Admin\Resources\ComercializadoraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComercializadoras extends ListRecords
{
    protected static string $resource = ComercializadoraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
