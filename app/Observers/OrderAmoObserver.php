<?php

namespace App\Observers;

use App\Models\OrderAmo;
use App\Models\OrderMs;
use App\Models\StatusAmo;
class OrderAmoObserver
{

      /**
     * Handle the OrderAmo "updated" event.
     */
    public function updated(OrderAmo $orderAmo): void
    {
         $orderMs= $orderAmo->orderMs;

        $statusMsId = StatusAmo::query()->where('id',$orderAmo->status_amo_id)->value('status_ms');
        if (
            $orderAmo->isDirty('status_amo_id')
            && $orderAmo->status_amo_id !== $statusMsId
        ){
            OrderMs::query()->where('id',$orderAmo->contact_amo_id);
            if ($statusMsId && $orderMs ) {
                $orderMs->update(['status_ms_id' => $statusMsId]);
            }
        }
    }

}
