<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_number',
        'start_date',
        'end_date',
        'agreed_rent',
        'deposit_amount',
        'max_occupants',
        'water_billing_method',
        'status',
        'note',
        'room_id',
        'tenant_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'agreed_rent' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
            'max_occupants' => 'integer',
            'room_id' => 'integer',
            'tenant_id' => 'integer',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function contractOccupants(): HasMany
    {
        return $this->hasMany(ContractOccupant::class, 'contract_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'contract_id');
    }
}
