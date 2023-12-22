<?php

namespace App\Http\Controllers\Production;

use App\Models\TechChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TechChartController extends Controller
{
    public function index()
    {
        $needMenuForItem = true;
        $entity = 'techcharts';

        $techcharts = TechChart::get();

        return view('production.techchart.index', compact("needMenuForItem", "entity", 'techcharts'));
    }

    public function show(Request $request, $techchart)
    {
        $needMenuForItem = true;
        $entity = 'techchart';

        $tech_chart = TechChart::with('materials', 'products')->find($techchart);
        return view('production.techchart.show', compact("needMenuForItem", "entity", 'tech_chart'));
    }
}
