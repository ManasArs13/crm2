<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function block()
    {
        $entity = 'calculator';
        $needMenuForItem = true;

        $dekor_gray = Product::query()->where('name', '=', 'Декор (серый)')->first()?->price;
        $dekor_color = Product::query()->where('name', '=', 'Декор (красный)')->first()?->price;

        $parapet_gray = Product::query()->where('name', '=', 'Парапет 390*190*60 (серый)')->first()?->price;
        $parapet_color = Product::query()->where('name', '=', 'Парапет 390*190*60 (красный)')->first()?->price;

        $cap_gray = Product::query()->where('name', '=', 'Крышка на колонну 390*390*60 (серая)')->first()?->price;
        $cap_color = Product::query()->where('name', '=', 'Крышка на колонну 390*390*60 (красная)')->first()?->price;

        $column_gray = Product::query()->where('name', '=', 'Колонна 280*190*280 (серая)')->first()?->price;
        $column_color = Product::query()->where('name', '=', 'Колонна 280*190*280 (красная)')->first()?->price;

        $block12_gray = Product::query()->where('name', '=', 'Заборный блок  120*190*390 (серый)')->first()?->price;
        $block12_color = Product::query()->where('name', '=', 'Заборный блок 120*190*390 (красный)')->first()?->price;

        return view(
            "calculator.block",
            compact(
                "needMenuForItem",
                "entity",
                "dekor_gray",
                "dekor_color",
                "parapet_gray",
                "parapet_color",
                "cap_gray",
                "cap_color",
                "column_gray",
                "column_color",
                "block12_gray",
                "block12_color"
            )
        );
    }

    public function concrete()
    {

    }
}
