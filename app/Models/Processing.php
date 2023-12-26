<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processing extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'processing_products', 'processing_id', 'product_id')->withPivot('id', 'quantity');
    }

    public function materials()
    {
        return $this->belongsToMany(Product::class, 'processing_materials', 'processing_id', 'product_id')->withPivot('id', 'quantity', 'quantity_norm');
    }

    public function tech_chart()
    {
        return $this->belongsTo(TechChart::class, 'tech_chart_id');
    }
}
