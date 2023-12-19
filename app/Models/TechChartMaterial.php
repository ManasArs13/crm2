<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechChartMaterial extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id'];

    public function tech_chart(): BelongsTo
    {
        return $this->belongsTo(TechChart::class, 'tech_cart_id');
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
