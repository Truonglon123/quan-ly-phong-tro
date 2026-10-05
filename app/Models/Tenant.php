<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'identity_number',
        'date_of_birth',
        'address',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }

    public function contractOccupants(): HasMany
    {
        return $this->hasMany(ContractOccupant::class, 'tenant_id');
    }
}
