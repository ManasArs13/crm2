<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductsCategory;

class ResidualController extends Controller
{
    public function all()
    {
        $needMenuForItem = true;

        $products = Product::where('residual_norm', '<>', null)
            ->where('type', Product::PRODUCTS)
            ->orWhere('type', Product::MATERIAL)
            ->get();
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", 'products'));
    }


    public function blocksMaterials()
    {
        $needMenuForItem = true;

        $products = Product::query()
            ->where('residual_norm', '<>', null)
            ->where('type', Product::MATERIAL)
            ->where('building_material', Product::BLOCK)->get()->sortBy('sort');
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }

    public function blocksCategories()
    {
        $needMenuForItem = true;

        $products = ProductsCategory::query()
            ->where('building_material', ProductsCategory::BLOCK)->get();



        foreach ($products as $product) {
            $product->residual =  Product::query()->where('type', Product::PRODUCTS)->where('category_id', $product->id)->get()->sum('residual');
            $product->residual_norm = Product::query()->where('type', Product::PRODUCTS)->where('category_id', $product->id)->get()->sum('residual_norm');
            $product->making_day = 0;

            $goods = Product::query()->where('type', Product::PRODUCTS)->where('category_id', $product->id)->get();


            foreach ($goods as $good) {
                if ($good->residual && $good->residual_norm && $good->release) {
                    if ($good->residual - $good->residual_norm < 0) {
                        $product->making_day += abs(($good->residual - $good->residual_norm) / $good->release);
                    }
                }
            }

            $product->maging_day += round($product->making_day);

            // if ($residual_norm !== 0) {
            //     $product->residual = $residual;
            //     $product->residual_norm = $residual_norm;
            // $product->release = $release;
            // $product->making_day = 0;

            // if ($product->residual && $product->residual_norm && $product->release) {
            //     if ($product->residual - $product->residual_norm < 0) {
            //         $product->making_day += abs(($product->residual - $product->residual_norm) / $product->release);
            //     }
            // }

        }

        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }

    public function blocksProducts()
    {
        $needMenuForItem = true;

        $products = Product::query()
            ->where('residual_norm', '<>', null)
            ->where('type', Product::PRODUCTS)
            ->where('building_material', Product::BLOCK)->get()->sortBy('sort');
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }



    public function concretesMaterials()
    {
        $needMenuForItem = true;

        $products = Product::query()
            ->where('residual_norm', '<>', null)
            ->where('building_material', Product::CONCRETE)->get()->sortBy('sort');
        $entity = 'residuals';

        return view("residual.index", compact("needMenuForItem", "entity", "products"));
    }
}
