<?php

namespace App\Http\Controllers;

use App\Models\Processing;

class TechOperationController extends Controller
{
    public function index()
    {
        $needMenuForItem = true;
        $entity = 'processings';

        $processings = Processing::with('products', 'materials', 'tech_chart')->orderBy('moment', 'desc')->paginate(100);

        return view('production.operations', compact("needMenuForItem", "entity", 'processings'));
    }
}
