<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WaterBillingMethod: string implements HasLabel
{
    case Meter = 'METER';
    case PerPerson = 'PER_PERSON';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Meter => 'Theo đồng hồ (m³)',
            self::PerPerson => 'Theo đầu người',
        };
    }
}
