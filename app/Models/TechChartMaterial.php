<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TechChartMaterial extends Pivot
{
    use HasFactory, HasUuids;

    protected $fillable = ['id'];

    protected $table = 'tech_chart_materials';

    public function tech_chart(): BelongsTo
    {
        return $this->belongsTo(TechChart::class, 'tech_cart_id');
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
