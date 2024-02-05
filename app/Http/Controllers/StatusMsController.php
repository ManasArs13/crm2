<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\StatusMs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StatusMsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=StatusMs::query()->paginate(50);
        $columns = Schema::getColumnListing('status_ms'); // users table
        $needMenuForItem=true;
        $urlEdit="status_ms.edit";
        $urlShow="status_ms.show";
        $urlDelete="status_ms.destroy";
        $urlCreate="status_ms.create";
        $urlFilter ='status_ms.filter';
        $entity='status_ms';

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
        $entityItem = new StatusMs();
        $columns = Schema::getColumnListing('status_ms'); // users table


        $entity='status_ms';
        $action="status_ms.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        StatusMs::create($request->post());
        return redirect()->route("status_ms.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=StatusMs::findOrFail($id);
        $columns = Schema::getColumnListing('status_ms'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=StatusMs::find($id);
        $columns = Schema::getColumnListing('status_ms'); // users table
        $entity='status_ms';
        $action="status_ms.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=StatusMs::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('status_ms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=StatusMs::find($id);
        $entityItem->delete();

        return redirect()->route('status_ms.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = StatusMs::query();
        $columns = Schema::getColumnListing('status_ms');

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
            $entityItems = StatusMs::query()->select($requestColumns);
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
        $urlEdit="status_ms.edit";
        $urlShow="status_ms.show";
        $urlDelete="status_ms.destroy";
        $urlCreate="status_ms.create";
        $urlFilter ='status_ms.filter';
        $urlReset = 'status_ms.index';
        $entity='status_ms';

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

        return view("own.index", compact('entityItems',"resColumns", "resColumnsAll",'selectColumn', "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter','urlReset','orderBy'));
    }
}
