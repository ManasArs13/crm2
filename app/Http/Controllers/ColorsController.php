<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=Color::query()->paginate(50);
        $columns = Schema::getColumnListing('colors'); // users table
        $entity='colors';
        $needMenuForItem=true;
        $urlEdit="colors.edit";
        $urlShow="colors.show";
        $urlDelete="colors.destroy";
        $urlCreate="colors.create";
        $urlFilter ='colors.filter';

        $resColumns=[];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumns[$column]=trans("column.".$column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        $resColumnsAll = $resColumns;

        return view("own.index", compact('entityItems',"resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
       public function create()
    {
        $entityItem = new Color();
        $columns = Schema::getColumnListing('colors'); // users table


        $entity='colors';
        $action="colors.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        Color::create($request->post());
        return redirect()->route("colors.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=Color::findOrFail($id);
        $columns = Schema::getColumnListing('colors');
        return view("own.show", compact('entityItem', "columns"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=Color::find($id);
        $columns = Schema::getColumnListing('colors'); // users table
        $entity='colors';
        $action="colors.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        $entityItem=Color::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('colors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=Color::find($id);
        $entityItem->delete();

        return redirect()->route('colors.index');
    }
    public function filter(FilterRequest $request)
    {

        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = Color::query();
        $columns = Schema::getColumnListing('colors');

        $resColumns = [];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumnsAll[$column] = trans("column." . $column);
        }

        uasort($resColumnsAll, function ($a, $b) {
            return ($a > $b);
        }); 

        if (isset($request->columns)){
            $requestColumns = $request->columns;
            $requestColumns[]="id";
            $columns =$requestColumns;
            $entityItems = Color::query()->select($requestColumns);
        }
        if (isset($request->orderBy)  && $request->orderBy == 'asc') {
            $entityItems = $entityItems->orderBy($request->getColumn())->paginate(50);
            $orderBy = 'desc';
        }elseif (isset($request->orderBy)  && $request->orderBy == 'desc') {
            $entityItems = $entityItems->orderByDesc($request->getColumn())->paginate(50);
            $orderBy = 'asc';
        } else{
            $entityItems =   $entityItems->paginate(50);
        }

        $entity='colors';
        $needMenuForItem=true;
        $urlEdit="colors.edit";
        $urlShow="colors.show";
        $urlDelete="colors.destroy";
        $urlCreate="colors.create";
        $urlFilter ='colors.filter';
        $urlReset = 'colors.index';
 
        if(isset($request->resColumns)){
            $resColumns = $request->resColumns;
        }else{
            foreach ($columns as $column) {
                $resColumns[$column] = trans("column." . $column);
            }
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        return view("own.index", compact('entityItems',"resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter','urlReset','orderBy','selectColumn'));
    }
}
