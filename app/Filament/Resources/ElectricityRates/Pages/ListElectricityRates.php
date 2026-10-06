<?php

namespace App\Filament\Resources\ElectricityRates\Pages;

use App\Filament\Resources\ElectricityRates\ElectricityRateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListElectricityRates extends ListRecords
{
    protected static string $resource = ElectricityRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
