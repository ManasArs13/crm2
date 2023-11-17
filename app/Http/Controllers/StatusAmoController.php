<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\StatusAmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StatusAmoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=StatusAmo::query()->paginate(50);
        $columns = Schema::getColumnListing('status_amos'); // users table
        $needMenuForItem=true;
        $urlEdit="status_amos.edit";
        $urlShow="status_amos.show";
        $urlDelete="status_amos.destroy";
        $urlCreate="status_amos.create";
        $urlFilter ='status_amos.filter';
        $entity='status_amos';

        $resColumns=[];
        foreach ($columns as $column) {
            $resColumns[$column]=trans("column.".$column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        return view("own.index", compact('entityItems',"resColumns", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entityItem = new StatusAmo();
        $columns = Schema::getColumnListing('status_amos'); // users table


        $entity='status_amos';
        $action="status_amos.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        StatusAmo::create($request->post());
        return redirect()->route("status_amos.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=StatusAmo::findOrFail($id);
        $columns = Schema::getColumnListing('status_amos'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=StatusAmo::find($id);
        $columns = Schema::getColumnListing('status_amos'); // users table
        $entity='status_amos';
        $action="status_amos.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=StatusAmo::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('status_amos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=StatusAmo::find($id);
        $entityItem->delete();

        return redirect()->route('status_amos.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = StatusAmo::query();
        $columns = Schema::getColumnListing('status_amos');

        if (isset($request->columns)){
            $requestColumns = $request->columns;
            $requestColumns[]="id";
            $columns =$requestColumns;
            $entityItems = StatusAmo::query()->select($requestColumns);
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
        $urlEdit="status_amos.edit";
        $urlShow="status_amos.show";
        $urlDelete="status_amos.destroy";
        $urlCreate="status_amos.create";
        $urlFilter ='status_amos.filter';
        $urlReset = 'status_amos.index';
        $entity='status_amos';

        $resColumns=[];
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

        return view("own.index", compact('entityItems',"resColumns",'selectColumn', "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter','urlReset','orderBy'));
    }
}
