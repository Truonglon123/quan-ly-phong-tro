<?php

namespace App\Filament\Resources\WaterRates\Pages;

use App\Filament\Resources\WaterRates\WaterRateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWaterRate extends EditRecord
{
    protected static string $resource = WaterRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
