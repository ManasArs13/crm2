<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class VehicleTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=VehicleType::query()->paginate(50);
        $columns = Schema::getColumnListing('vehicle_types'); // users table
        $needMenuForItem=true;
        $urlEdit="vehicle_types.edit";
        $urlShow="vehicle_types.show";
        $urlDelete="vehicle_types.destroy";
        $urlCreate="vehicle_types.create";
        $urlFilter ='vehicle_types.filter';
        $entity='vehicle_types';

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
        $entityItem = new VehicleType();
        $columns = Schema::getColumnListing('vehicle_types'); // users table


        $entity='vehicle_types';
        $action="vehicle_types.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        VehicleType::create($request->post());
        return redirect()->route("vehicle_types.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=VehicleType::findOrFail($id);
        $columns = Schema::getColumnListing('vehicle_types'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=VehicleType::find($id);
        $columns = Schema::getColumnListing('vehicle_types'); // users table
        $entity='vehicle_types';
        $action="vehicle_types.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        $entityItem=VehicleType::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('vehicle_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=VehicleType::find($id);
        $entityItem->delete();

        return redirect()->route('vehicle_types.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = VehicleType::query();
        $columns = Schema::getColumnListing('vehicle_types');

        if (isset($request->columns)){
            $requestColumns = $request->columns;
            $requestColumns[]="id";
            $columns =$requestColumns;
            $entityItems = VehicleType::query()->select($requestColumns);
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
        $urlEdit="vehicle_types.edit";
        $urlShow="vehicle_types.show";
        $urlDelete="vehicle_types.destroy";
        $urlCreate="vehicle_types.create";
        $urlFilter ='vehicle_types.filter';
        $urlReset = 'vehicle_types.index';
        $entity='vehicle_types';
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
