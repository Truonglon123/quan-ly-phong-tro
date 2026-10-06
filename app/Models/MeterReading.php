<?php

namespace App\Models;

use App\Enums\MeterType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'meter_type',
        'reading_date',
        'previous_reading',
        'current_reading',
        'consumption',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'room_id' => 'integer',
            'reading_date' => 'date',
            'previous_reading' => 'decimal:3',
            'current_reading' => 'decimal:3',
            'consumption' => 'decimal:3',
            'meter_type' => MeterType::class,
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (MeterReading $reading) {
            $reading->consumption = round(
                (float) $reading->current_reading - (float) $reading->previous_reading,
                3
            );
        });
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
