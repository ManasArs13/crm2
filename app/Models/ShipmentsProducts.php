<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentsProducts extends Model
{
    use HasFactory,HasUuids;

    public $incrementing = false;
    protected $fillable =[
        'shipment_id',
        'quantity',
        'product_id',
    ];

    /**
     * @return BelongsTo
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipments::class, 'shipment_id');
    }

}
