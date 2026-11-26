<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InvoiceStatus: string implements HasLabel, HasColor
{
    case Draft = 'DRAFT';
    case Issued = 'ISSUED';
    case Partial = 'PARTIAL';
    case Paid = 'PAID';
    case Overdue = 'OVERDUE';
    case Cancelled = 'CANCELLED';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Nháp',
            self::Issued => 'Đã phát hành',
            self::Partial => 'Trả một phần',
            self::Paid => 'Đã thanh toán',
            self::Overdue => 'Quá hạn',
            self::Cancelled => 'Đã hủy',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Issued => 'info',
            self::Partial => 'warning',
            self::Paid => 'success',
            self::Overdue => 'danger',
            self::Cancelled => 'gray',
        };
    }
}
