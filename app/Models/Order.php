<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = false;

    protected $fillable = [
        'sum',
        'name',
        'phone',
        'delivery_id',
        'vehicle_type_id',
        'fence_length',
        'number_of_columns',
        'fence_type_id',
        'wall_id',
        'column_id',
        'weight',
        'delivery_price'
    ];

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'id', 'delivery_id');
    }

    public function vehicle_type()
    {
        return $this->hasOne(VehicleType::class, 'id', 'vehicle_type_id');
    }

    public function fence_type()
    {
        return $this->hasOne(FenceType::class, 'id', 'fence_type_id');
    }

    public function wall()
    {
        return $this->hasOne(Wall::class, 'id', 'wall_id');
    }

    public function column()
    {
        return $this->hasOne(Column::class, 'id', 'column_id');
    }

    public function positions() {
        return $this->hasMany(OrdersPosition::class);
    }
}
