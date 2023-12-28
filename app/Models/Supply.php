<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supply extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id'];

    public function contact_ms(): HasOne
    {
        return $this->hasOne(ContactMs::class, 'id', 'contact_ms_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'supply_positions', 'supply_id', 'product_id')->withPivot('id', 'quantity', 'price');
    }
}
