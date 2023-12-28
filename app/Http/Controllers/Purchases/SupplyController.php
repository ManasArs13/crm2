<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use App\Models\SupplyPositions;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $needMenuForItem = true;
        $entity = 'supplies';

        $supplies = Supply::with('contact_ms')->orderBy('moment', 'desc')->paginate(100);

        return view('supply.index', compact("needMenuForItem", "entity", 'supplies'));
    }

    public function show(Request $request, $processing)
    {
        $needMenuForItem = true;
        $entity = 'supply';

        $supply = Supply::with('contact_ms', 'products')->find($processing);

        return view('supply.show', compact("needMenuForItem", "entity", 'supply'));
    }

    public function products(Request $request)
    {
        $needMenuForItem = true;
        $entity = 'supplies';

        $supply_products = SupplyPositions::with('supply', 'products')->orderBy('created_at', 'desc')->paginate(100);
//dd($supply_products);
        return view('supply.products', compact("needMenuForItem", "entity", 'supply_products'));
    }
}
