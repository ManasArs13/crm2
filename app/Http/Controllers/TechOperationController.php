<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechOperationController extends Controller
{
    public function index()
    {
        $needMenuForItem = true;
        $entity = 'techcharts';

        // $techcharts = TechChart::with('product')->get();

        return view('production.charts', compact("needMenuForItem", "entity", 'techcharts'));
    }
}
