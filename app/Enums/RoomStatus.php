<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RoomStatus: string implements HasLabel, HasColor
{
    case Available = 'AVAILABLE';
    case Reserved = 'RESERVED';
    case Occupied = 'OCCUPIED';
    case Maintenance = 'MAINTENANCE';
    case Inactive = 'INACTIVE';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Available => 'Còn trống',
            self::Reserved => 'Đã đặt cọc',
            self::Occupied => 'Đang thuê',
            self::Maintenance => 'Đang sửa chữa',
            self::Inactive => 'Ngừng sử dụng',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Available => 'success',
            self::Reserved => 'info',
            self::Occupied => 'primary',
            self::Maintenance => 'warning',
            self::Inactive => 'gray',
        };
    }
}
