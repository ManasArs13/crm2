<?php

namespace App\Models\SyncOrdersContacts;

use App\Models\OrderAmo;
use App\Models\OrderMs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $order_amo_id
 * @property mixed $order_ms_id
 * @property bool $is_unique
 * @property mixed $budget_amo
 */
class OrderMsOrderAmo extends Model
{
    use HasFactory;
    public $fillable = [
        "*"
    ];

    public function orderMs()
    {
        return $this->belongsTo(OrderMs::class );
    }

    public function orderAmo()
    {
        return $this->belongsTo(OrderAmo::class );
    }
}
