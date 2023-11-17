<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipments extends Model
{
    use HasFactory,HasUuids;
    public $incrementing = false;

    public const PAID = 'Оплачен';
    public const NOT_PAID = 'Не оплачен';
    public const APPOINTED = 'Назначен';

    protected $fillable =[
        'id',
        'order_id',

    ];
    protected $guarded = false;

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(OrderMs::class);
    }

}
