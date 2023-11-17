<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model
{
    protected $table = 'shipping_prices';
    protected $guarded = false;

    public function vehicle_type()
    {
        return $this->hasOne(VehicleType::class, 'id', 'vehicle_type_id');
    }
}
