<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractOccupant extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'tenant_id',
        'start_date',
        'end_date',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'contract_id' => 'integer',
            'tenant_id' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
