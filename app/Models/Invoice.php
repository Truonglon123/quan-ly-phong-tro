<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Enums\InvoiceStatus;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'billing_period',
        'issued_at',
        'due_date',
        'subtotal',
        'discount',
        'total_amount',
        'status',
        'note',
        'contract_id',
    ];

    protected function casts(): array
    {
        return [
            'billing_period' => 'date',
            'issued_at' => 'date',
            'due_date' => 'date',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'contract_id' => 'integer',
            'status' => InvoiceStatus::class,
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    protected $attributes = [
        'subtotal' => 0,
        'discount' => 0,
        'total_amount' => 0,
    ];

    protected static function booted(): void
    {
        static::saving(function (Invoice $invoice) {
            $invoice->total_amount = max(
                0,
                (float) $invoice->subtotal - (float) $invoice->discount
            );
        });
    }

    public function recalculateSubtotal(): void
    {
        $this->subtotal = $this->invoiceItems()->sum('amount');
        $this->save();
    }
}
