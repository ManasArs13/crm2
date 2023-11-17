<?php

namespace App\Models;

use App\Models\SyncOrdersContacts\OrderMsOrderAmo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OrderMs extends Model
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
    protected $table = 'order_ms';
    protected $guarded = false;


    /**
     * @return HasOne
     */
    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class, 'id', 'delivery_id');
    }

    /**
     * @return HasOne
     */
    public function vehicle_type(): HasOne
    {
        return $this->hasOne(VehicleType::class, 'id', 'vehicle_type_id');
    }

    /**
     * @return HasOne
     */
    public function transport(): HasOne
    {
        return $this->hasOne(Transport::class, 'id', 'transport_id');
    }

    /**
     * @return BelongsTo
     */
    public function status_ms(): BelongsTo
    {
        return $this->belongsTo(StatusMs::class);
    }

    /**
     * @return HasOne
     */
    public function contact_ms(): HasOne
    {
        return $this->hasOne(ContactMs::class, 'id', 'contact_ms_id');
    }

    /**
     * @return HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(OrderPositionMs::class);
    }

    /**
     * @return HasOneThrough
     */
    public function orderAmo(): HasOneThrough
    {
        return $this->hasOneThrough(OrderAmo::class, OrderMsOrderAmo::class, 'order_ms_id', 'id', 'id', 'order_amo_id');
    }
}
