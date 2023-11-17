<?php

namespace App\Models;

use App\Models\SyncOrdersContacts\ContactMsContactAmo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ContactMs extends Model
{
    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    protected $table = 'contact_ms';
    protected $guarded = false;

    public function contactAmo(): HasOneThrough
    {
        return $this->hasOneThrough(ContactAmo::class, ContactMsContactAmo::class, 'contact_ms_id', 'id', 'id', 'contact_amo_id');
    }
}
