<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ContractStatus: string implements HasLabel, HasColor
{
    case Draft = 'DRAFT';
    case Active = 'ACTIVE';
    case Expired = 'EXPIRED';
    case Terminated = 'TERMINATED';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Nháp',
            self::Active => 'Đang hiệu lực',
            self::Expired => 'Hết hạn',
            self::Terminated => 'Đã chấm dứt',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Active => 'success',
            self::Expired => 'warning',
            self::Terminated => 'danger',
        };
    }
}
