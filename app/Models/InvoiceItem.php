<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'amount',
        'item_type',
        'meter_reading_id',
        'fee_rate_id',
    ];

    protected function casts(): array
    {
        return [
            'invoice_id' => 'integer',
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'amount' => 'decimal:2',
            'meter_reading_id' => 'integer',
            'fee_rate_id' => 'integer',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function meterReading(): BelongsTo
    {
        return $this->belongsTo(MeterReading::class, 'meter_reading_id');
    }

    public function feeRate(): BelongsTo
    {
        return $this->belongsTo(FeeRate::class, 'fee_rate_id');
    }
}
