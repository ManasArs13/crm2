<?php

namespace App\Models;

use App\Models\SyncOrdersContacts\OrderMsOrderAmo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OrderAmo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id'
    ];
    public function contact_amo()
    {
        return $this->belongsTo(ContactAmo::class);
    }

    public function status_amo()
    {
        return $this->belongsTo(StatusAmo::class);
    }
    public function orderMs():HasOneThrough
    {

            return $this->hasOneThrough(OrderMs::class, OrderMsOrderAmo::class, 'order_amo_id', 'id', 'id', 'order_ms_id');

    }
}
