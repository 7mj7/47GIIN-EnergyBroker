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

    protected function beforeSave(): void
    {

        $data = $this->data;

        if ($data['tipo_tarifa'] === 'F') {
            $data['rem_index'] = null; // Establece rem_index a null
        }

        if ($data['tipo_tarifa'] === 'I') {
            // Términos de energía
            $data['pe_p1'] = null;
            $data['pe_p2'] = null;
            $data['pe_p3'] = null;
            $data['pe_p4'] = null;
            $data['pe_p5'] = null;
            $data['pe_p6'] = null;
            // Término variable de gas
            $data['tv'] = null;
        }

        if ($data['tipo_energia'] == 'E') {
            // Término fijo Gas
            $data['tf'] = null;
            // Término variable gas
            $data['tv'] = null;
        }

        if ($data['tipo_energia'] == 'G') {
            // Término de potencia electricidad
            $data['pp_p1'] = null;
            $data['pp_p2'] = null;
            $data['pp_p3'] = null;
            $data['pp_p4'] = null;
            $data['pp_p5'] = null;
            $data['pp_p6'] = null;
            // Término de energía electricidad
            $data['pe_p1'] = null;
            $data['pe_p2'] = null;
            $data['pe_p3'] = null;
            $data['pe_p4'] = null;
            $data['pe_p5'] = null;
            $data['pe_p6'] = null;
        }

        $this->data = $data;
    }
}
