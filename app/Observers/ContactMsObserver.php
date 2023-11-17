<?php

namespace App\Observers;

use App\Models\ContactMs;
use Illuminate\Support\Facades\Artisan;

class ContactMsObserver
{
    /**
     * Handle the ContactMs "created" event.
     */
    public function created(ContactMs $contactMs): void
    {
        Artisan::call('app:update-counterparty');
    }


}
