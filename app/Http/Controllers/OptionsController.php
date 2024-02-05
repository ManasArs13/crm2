<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=Option::query()->paginate(50);
        $columns = Schema::getColumnListing('options'); // users table
        $needMenuForItem=true;
        $urlEdit="options.edit";
        $urlShow="options.show";
        $urlDelete="options.destroy";
        $urlCreate="options.create";
        $urlFilter ='options.filter';
        $entity='options';

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
        $entityItem = new Option();
        $columns = Schema::getColumnListing('options'); // users table


        $entity='options';
        $action="options.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        Option::create($request->post());
        return redirect()->route("options.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=Option::findOrFail($id);
        $columns = Schema::getColumnListing('options'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=Option::find($id);
        $columns = Schema::getColumnListing('options'); // users table
        $entity='options';
        $action="options.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        $entityItem=Option::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('options.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=Option::find($id);
        $entityItem->delete();

        return redirect()->route('options.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = Option::query();
        $columns = Schema::getColumnListing('options');

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
            $entityItems = Option::query()->select($requestColumns);
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

        $needMenuForItem=true;
        $urlEdit="options.edit";
        $urlShow="options.show";
        $urlDelete="options.destroy";
        $urlCreate="options.create";
        $urlFilter ='options.filter';
        $urlReset = 'options.index';
        $entity='options';

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

        return view("own.index", compact('entityItems',"resColumns", "resColumnsAll", 'selectColumn', "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter','urlReset','orderBy'));
    }
}
