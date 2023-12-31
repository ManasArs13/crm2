<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DeliveriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=Delivery::query()->paginate(50);
        $columns = Schema::getColumnListing('deliveries'); // users table
        $needMenuForItem=true;
        $urlEdit="deliveries.edit";
        $urlShow="deliveries.show";
        $urlDelete="deliveries.destroy";
        $urlCreate="deliveries.create";
        $urlFilter ='deliveries.filter';
        $entity='deliveries';

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
        $entityItem = new Delivery();
        $columns = Schema::getColumnListing('deliveries'); // users table


        $entity='deliveries';
        $action="deliveries.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        Delivery::create($request->post());
        return redirect()->route("deliveries.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=Delivery::findOrFail($id);
        $columns = Schema::getColumnListing('deliveries'); // users table
        return view("own.show", compact('entityItem', "columns"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=Delivery::find($id);
        $columns = Schema::getColumnListing('deliveries'); // users table
        $entity='deliveries';
        $action="deliveries.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        $entityItem=Delivery::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('deliveries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=Delivery::find($id);
        $entityItem->delete();

        return redirect()->route('deliveries.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = Delivery::query();
        $columns = Schema::getColumnListing('deliveries');

        if (isset($request->columns)){
            $requestColumns = $request->columns;
            $requestColumns[]="id";
            $columns =$requestColumns;
            $entityItems = Delivery::query()->select($requestColumns);
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
        $urlEdit="deliveries.edit";
        $urlShow="deliveries.show";
        $urlDelete="deliveries.destroy";
        $urlCreate="deliveries.create";
        $urlFilter ='deliveries.filter';
        $urlReset = 'deliveries.index';
        $entity='deliveries';

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
