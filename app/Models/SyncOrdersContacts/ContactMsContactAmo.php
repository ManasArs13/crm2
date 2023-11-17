<?php

namespace App\Models\SyncOrdersContacts;

use App\Models\ContactAmo;
use App\Models\ContactMs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $contact_ms_id
 * @property int $contact_amo_id
 */
class ContactMsContactAmo extends Model
{
    use HasFactory;
    public $fillable = [
        "*"
    ];

    public function contactMs():BelongsTo
    {
        return $this->belongsTo(ContactMs::class );
    }

    public function contactAmo(): BelongsTo
    {
        return $this->belongsTo(ContactAmo::class );
    }
}
