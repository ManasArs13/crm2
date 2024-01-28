<?php

namespace App\Console\Commands;

use App\Models\ContactAmo;
use App\Models\ContactMs;
use App\Models\Option;
use App\Models\SyncOrdersContacts\ContactMsContactAmo;
use App\Services\Api\MoySkladService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncContactMsAmo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-contact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $contactAmos = ContactAmo::get();

        foreach($contactAmos as $contactAmo) {
            $contactMS = ContactMs::query()->where('phone_norm', $contactAmo->phone_norm);

            if ($contactMS) {
                $contactAmo->update([
                        'contact_ms_id' => $contactMS->id,
                        'contact_ms_link' => 'https://api.moysklad.ru/#company/edit?id='.$contactMS->id
                ]);
            }

        }
    }
}
