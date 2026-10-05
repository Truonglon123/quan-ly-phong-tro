<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'default_rent',
        'max_occupants',
        'status',
        'description',
        'location_id',
    ];

    protected function casts(): array
    {
        return [
            'default_rent' => 'decimal:2',
            'max_occupants' => 'integer',
            'location_id' => 'integer',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'room_id');
    }

    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReading::class, 'room_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'room_id');
    }
}
