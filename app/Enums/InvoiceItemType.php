<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum InvoiceItemType: string implements HasLabel
{
    case Rent = 'RENT';
    case Electricity = 'ELECTRICITY';
    case Water = 'WATER';
    case Internet = 'INTERNET';
    case Trash = 'TRASH';
    case Parking = 'PARKING';
    case Other = 'OTHER';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Rent => 'Tiền phòng',
            self::Electricity => 'Tiền điện',
            self::Water => 'Tiền nước',
            self::Internet => 'Internet',
            self::Trash => 'Rác',
            self::Parking => 'Gửi xe',
            self::Other => 'Khác',
        };
    }
}
