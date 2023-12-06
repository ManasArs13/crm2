<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;
    public const PRODUCTS = "продукция";
    public const MATERIAL = "материал";
    public const NOT_SELECTED = "не выбрано";
    public const CONCRETE = "бетон";
    public const BLOCK = "блок";

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
    protected $table = 'products';
    protected $guarded = false;

    public function color()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function category()
    {
        return $this->hasOne(ProductsCategory::class, 'id', 'category_id');
    }

}
