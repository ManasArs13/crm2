<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\ShippingPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ShippingPricesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=ShippingPrice::query()->paginate(50);
        $columns = Schema::getColumnListing('shipping_prices'); // users table
        $needMenuForItem=true;
        $urlEdit="shipping_prices.edit";
        $urlShow="shipping_prices.show";
        $urlDelete="shipping_prices.destroy";
        $urlCreate="shipping_prices.create";
        $urlFilter ='shipping_prices.filter';
        $entity='shipping_prices';

        $resColumns=[];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumns[$column]=trans("column.".$column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        return view("own.index", compact('entityItems',"resColumns", "resColumsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
       public function create()
    {
        $entityItem = new ShippingPrice();
        $columns = Schema::getColumnListing('shipping_prices'); // users table


        $entity='shipping_prices';
        $action="shipping_prices.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        ShippingPrice::create($request->post());
        return redirect()->route("shipping_prices.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=ShippingPrice::findOrFail($id);
        $columns = Schema::getColumnListing('shipping_prices'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=ShippingPrice::find($id);
        $columns = Schema::getColumnListing('shipping_prices'); // users table
        $entity='shipping_prices';
        $action="shipping_prices.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        $entityItem=ShippingPrice::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('shipping_prices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=ShippingPrice::find($id);
        $entityItem->delete();

        return redirect()->route('shipping_prices.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;

        $entityItems = ShippingPrice::query();
        $selectColumn = $request->getColumn();
        $columns = Schema::getColumnListing('shipping_prices');

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
            $entityItems = ShippingPrice::query()->select($requestColumns);
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
        $urlEdit="shipping_prices.edit";
        $urlShow="shipping_prices.show";
        $urlDelete="shipping_prices.destroy";
        $urlCreate="shipping_prices.create";
        $urlFilter ='shipping_prices.filter';
        $urlReset = 'shipping_prices.index';
        $entity='shipping_prices';

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
