<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaterRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_method',
        'price_per_unit',
        'effective_from',
        'effective_to',
        'note',
        'location_id',
    ];

    protected function casts(): array
    {
        return [
            'price_per_unit' => 'decimal:2',
            'effective_from' => 'date',
            'effective_to' => 'date',
            'location_id' => 'integer',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
