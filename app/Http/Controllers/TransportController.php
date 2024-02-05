<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=Transport::query()->paginate(50);
        $columns = Schema::getColumnListing('transports'); // users table
        $needMenuForItem=true;
        $urlEdit="transports.edit";
        $urlShow="transports.show";
        $urlDelete="transports.destroy";
        $urlCreate="transports.create";
        $urlFilter ='transports.filter';
        $entity='transports';

        $resColumns=[];
        $resColumnsAll =[];

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
        $entityItem = new Transport();
        $columns = Schema::getColumnListing('transports'); // users table


        $entity='transports';
        $action="transports.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Transport::create($request->post());
        return redirect()->route("transports.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=Transport::findOrFail($id);
        $columns = Schema::getColumnListing('transports'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=Transport::find($id);
        $columns = Schema::getColumnListing('transports'); // users table
        $entity='transports';
        $action="transports.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=Transport::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('transports.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=Transport::find($id);
        $entityItem->delete();

        return redirect()->route('transports.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = Transport::query();
        $columns = Schema::getColumnListing('transports');

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
            $entityItems = Transport::query()->select($requestColumns);
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
        $urlEdit="transports.edit";
        $urlShow="transports.show";
        $urlDelete="transports.destroy";
        $urlCreate="transports.create";
        $urlFilter ='transports.filter';
        $urlReset = 'transports.index';
        $entity='transports';

 
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
