<?php

namespace App\Models;

use App\Models\SyncOrdersContacts\ContactMsContactAmo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @method static firstOrNew(array $array)
 * @method static create(array|string|null $post)
 */
class ContactAmo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id'
    ];
    public function contactMs(): HasOneThrough
    {
        return $this->hasOneThrough(ContactAmo::class, ContactMsContactAmo::class, 'contact_amo_id', 'id', 'id', 'contact_ms_id');
    }
}
