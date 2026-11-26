<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case Cash = 'CASH';
    case BankTransfer = 'BANK_TRANSFER';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Cash => 'Tiền mặt',
            self::BankTransfer => 'Chuyển khoản',
        };
    }
}
