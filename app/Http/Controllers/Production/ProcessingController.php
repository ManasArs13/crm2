<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\Processing;
use Illuminate\Http\Request;

class ProcessingController extends Controller
{
    public function index()
    {
        $needMenuForItem = true;
        $entity = 'processings';

        $processings = Processing::with('tech_chart')->orderBy('moment', 'desc')->paginate(100);

        return view('production.processing.index', compact("needMenuForItem", "entity", 'processings'));
    }

    public function show(Request $request, $processing)
    {
        $needMenuForItem = true;
        $entity = 'processing';

        $processing = Processing::with('materials', 'products', 'tech_chart')->find($processing);
        return view('production.processing.show', compact("needMenuForItem", "entity", 'processing'));
    }
}
