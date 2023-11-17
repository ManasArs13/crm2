<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusMs extends Model
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
    protected $table = 'status_ms';
    protected $guarded = false;

    public function status_amo()
    {
        return $this->belongsTo(StatusAmo::class);
    }
}
