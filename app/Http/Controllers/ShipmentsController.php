<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Shipments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ShipmentsController extends Controller
{
    public function index()
    {
        $entityItems=Shipments::query()->paginate(50);
        $columns = Schema::getColumnListing('shipments');
        $needMenuForItem=true;
        $urlEdit="shipments.edit";
        $urlShow="shipments.show";
        $urlDelete="shipments.destroy";
        $urlCreate="shipments.create";
        $urlFilter ='shipments.filter';
        $entity='shipments';
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


    public function create()
    {
        $entityItem = new Shipments();
        $columns = Schema::getColumnListing('shipments'); // users table


        $entity='shipments';
        $action="shipments.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Shipments::create($request->post());
        return redirect()->route("shipments.index");
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=Shipments::findOrFail($id);
        $columns = Schema::getColumnListing('shipments'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=Shipments::find($id);
        $columns = Schema::getColumnListing('shipments'); // users table
        $entity='shipments';
        $action="shipments.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=Shipments::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('shipments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=Shipments::find($id);
        $entityItem->delete();

        return redirect()->route('shipments.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = Shipments::query();
        $columns = Schema::getColumnListing('shipments');

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
            $entityItems = Shipments::query()->select($requestColumns);
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
        $urlEdit="shipments.edit";
        $urlShow="shipments.show";
        $urlDelete="shipments.destroy";
        $urlCreate="shipments.create";
        $urlFilter ='shipments.filter';
        $urlReset = 'shipments.index';
        $entity='shipments';

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

        return view("own.index", compact('entityItems','selectColumn',"resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter','urlReset','orderBy'));
    }

}
