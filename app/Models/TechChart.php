<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechChart extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id'];

    public function materials()
    {
        return $this->belongsToMany(Product::class, 'tech_chart_materials', 'tech_chart_id', 'product_id')->withPivot('id', 'quantity');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'tech_chart_products', 'tech_chart_id', 'product_id')->withPivot('id', 'quantity');
    }
}
