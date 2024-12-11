<?php

namespace App\Filament\Admin\Resources\TerceroResource\Pages;

use App\Filament\Admin\Resources\TerceroResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTercero extends CreateRecord
{
    protected static string $resource = TerceroResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Establece el usuario que creo el tercero
        $data['user_id'] = auth()->id();

        return $data;
    }
}
