<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\FenceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class FenceTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=FenceType::query()->paginate(50);
        $columns = Schema::getColumnListing('fence_types'); // users table
        $needMenuForItem=true;
        $urlEdit="fence_types.edit";
        $urlShow="fence_types.show";
        $urlDelete="fence_types.destroy";
        $urlCreate="fence_types.create";
        $urlFilter ='fence_types.filter';
        $entity='fence_types';

        $resColumns=[];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumns[$column]=trans("column.".$column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        $resColumsAll = $resColumns;

        return view("own.index", compact('entityItems',"resColumns", 'resColumnsAll', "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entityItem = new FenceType();
        $columns = Schema::getColumnListing('fence_types'); // users table


        $entity='fence_types';
        $action="fence_types.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FenceType::create($request->post());
        return redirect()->route("fence_types.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=FenceType::findOrFail($id);
        $columns = Schema::getColumnListing('fence_types'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=FenceType::find($id);
        $columns = Schema::getColumnListing('fence_types'); // users table
        $entity='fence_types';
        $action="fence_types.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=FenceType::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('fence_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=FenceType::find($id);
        $entityItem->delete();

        return redirect()->route('fence_types.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = FenceType::query();
        $columns = Schema::getColumnListing('fence_types');

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
            $entityItems = FenceType::query()->select($requestColumns);
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
        $urlEdit="fence_types.edit";
        $urlShow="fence_types.show";
        $urlDelete="fence_types.destroy";
        $urlCreate="fence_types.create";
        $urlFilter ='fence_types.filter';
        $urlReset = 'fence_types.index';
        $entity='fence_types';

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

        return view("own.index", compact('entityItems',"resColumns", "resColumsAll", 'selectColumn', "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter','urlReset','orderBy'));
    }
}
