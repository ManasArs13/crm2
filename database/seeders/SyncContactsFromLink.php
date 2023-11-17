<?php

namespace Database\Seeders;

use App\Models\ContactAmo;
use App\Models\ContactMs;
use App\Models\SyncOrdersContacts\ContactMsContactAmo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SyncContactsFromLink extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $contactMs =ContactMs::query()->where('updated_at' ,'>',$updated)->groupBy('phone_norm')->havingRaw('COUNT(*) = 1')->where('phone_norm', '!=', null)->get();

        $contactMs = ContactMs::query()->groupBy('phone_norm')->havingRaw('COUNT(*) = 1')->whereNotNull('contact_amo_link')->where('contact_amo_link' ,'!=' ,'')->get();
        foreach ($contactMs as $contact){
            $contactAmoId =(integer) substr($contact->contact_amo_link,strrpos($contact->contact_amo_link,'/')+ 1);
            $contactAmo = ContactAmo::query()->where('id',$contactAmoId)->exists();
            if ($contactAmo){
                $syncContacts = new ContactMsContactAmo();
                $syncContacts->contact_ms_id = $contact->id;
                $syncContacts->contact_amo_id = $contactAmoId;
                $syncContacts->save();
            }
        }
    }
}
