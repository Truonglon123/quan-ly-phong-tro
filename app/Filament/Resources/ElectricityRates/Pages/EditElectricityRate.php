<?php

namespace App\Filament\Resources\ElectricityRates\Pages;

use App\Filament\Resources\ElectricityRates\ElectricityRateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditElectricityRate extends EditRecord
{
    protected static string $resource = ElectricityRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
