<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersPosition extends Model
{
    protected $table = 'orders_positions';
    protected $guarded = false;
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price',
        'weight'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
