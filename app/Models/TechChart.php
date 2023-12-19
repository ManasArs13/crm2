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
        return $this->hasMany(TechChartMaterial::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
