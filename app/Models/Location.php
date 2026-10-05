<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'description',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'location_id');
    }

    public function electricityRates(): HasMany
    {
        return $this->hasMany(ElectricityRate::class, 'location_id');
    }

    public function waterRates(): HasMany
    {
        return $this->hasMany(WaterRate::class, 'location_id');
    }

    public function feeRates(): HasMany
    {
        return $this->hasMany(FeeRate::class, 'location_id');
    }
}
