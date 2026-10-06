<?php

namespace App\Filament\Resources\WaterRates\Pages;

use App\Filament\Resources\WaterRates\WaterRateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWaterRates extends ListRecords
{
    protected static string $resource = WaterRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
