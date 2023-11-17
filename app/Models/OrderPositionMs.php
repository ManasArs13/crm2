<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPositionMs extends Model
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
    protected $table = 'order_position_ms';
    protected $guarded = false;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function order_ms()
    {
        return $this->hasOne(OrderMs::class, 'id', 'order_ms_id');
    }
}
