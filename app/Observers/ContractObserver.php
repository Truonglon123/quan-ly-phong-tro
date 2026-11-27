<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\Room;

class ContractObserver
{
    public function saved(Contract $contract): void
    {
        $contract->room?->syncStatus();

        if ($contract->wasChanged('room_id')) {
            Room::find($contract->getOriginal('room_id'))?->syncStatus();
        }
    }

    public function deleted(Contract $contract): void
    {
        $contract->room?->syncStatus();
    }

    public function restored(Contract $contract): void
    {
        $contract->room?->syncStatus();
    }
}
