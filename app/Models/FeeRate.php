<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_type_id',
        'price',
        'effective_from',
        'effective_to',
        'note',
        'location_id',
    ];

    protected function casts(): array
    {
        return [
            'fee_type_id' => 'integer',
            'price' => 'decimal:2',
            'effective_from' => 'date',
            'effective_to' => 'date',
            'location_id' => 'integer',
        ];
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
