<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MeterType: string implements HasLabel, HasColor
{
    case Electricity = 'ELECTRICITY';
    case Water = 'WATER';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Electricity => 'Điện',
            self::Water => 'Nước',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Electricity => 'warning',
            self::Water => 'info',
        };
    }

    public function unit(): string
    {
        return match ($this) {
            self::Electricity => 'kWh',
            self::Water => 'm³',
        };
    }
}
