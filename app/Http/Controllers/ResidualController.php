<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductsCategory;

class ResidualController extends Controller
{
    public function all()
    {
        $needMenuForItem = true;

        $products = Product::where('type', Product::PRODUCTS)
            ->orWhere('type', Product::MATERIAL)
            ->get();
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", 'products'));
    }


    public function blocksMaterials()
    {
        $needMenuForItem = true;

        $products = Product::query()
            ->where('type', Product::MATERIAL)
            ->where('building_material', Product::BLOCK)->get()->sortBy('sort');
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }

    public function blocksCategories()
    {
        $needMenuForItem = true;

        $products = ProductsCategory::query()->where('building_material', ProductsCategory::BLOCK)->get();
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }

    public function blocksProducts()
    {
        $needMenuForItem = true;

        $products = Product::query()
            ->where('type', Product::PRODUCTS)
            ->where('building_material', Product::BLOCK)->get()->sortBy('sort');
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }



    public function concretesMaterials()
    {
        $needMenuForItem = true;

        $products = Product::query()->where('building_material',Product::CONCRETE)->get()->sortBy('sort');
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }
}
