<?php

namespace App\Http\Controllers\Production;

use App\Models\TechChart;
use App\Http\Controllers\Controller;

class TechChartController extends Controller
{
    public function index()
    {
        $needMenuForItem = true;
        $entity = 'techcharts';

        $techcharts = TechChart::with('product', 'materials')->get();

        return view('production.techchart.index', compact("needMenuForItem", "entity", 'techcharts'));
    }
}
