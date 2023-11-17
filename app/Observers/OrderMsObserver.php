<?php

namespace App\Observers;

use App\Models\OrderMs;
use App\Models\StatusAmo;

class OrderMsObserver
{

    /**
     * Handle the OrderMs "updated" event.
     */
    public function updated(OrderMs $orderMs): void
    {
        if ($orderMs->isDirty('status_ms_id')){

            $statusAmoId = StatusAmo::query()->where('status_ms', $orderMs->status_ms_id)->value('id');

            if ($statusAmoId) {
                $orderMs->orderAmo()->update(['status_amo_id' => $statusAmoId]);
            }
        }
    }

}
