<?php

namespace App\Http\Controllers;

use App\Models\TechChart;

class TechChartController extends Controller
{
    public function index()
    {
        $needMenuForItem = true;
        $entity = 'techcharts';

        $techcharts = TechChart::with('product')->get();

        return view('production.charts', compact("needMenuForItem", "entity", 'techcharts'));
    }
}
