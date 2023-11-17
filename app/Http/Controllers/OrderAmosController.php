<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\OrderAmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class OrderAmosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=OrderAmo::query()->paginate(50);
        $columns = Schema::getColumnListing('order_amos');
        $needMenuForItem=true;
        $urlEdit="order_amos.edit";
        $urlShow="order_amos.show";
        $urlDelete="order_amos.destroy";
        $urlCreate="order_amos.create";
        $urlFilter ='order_amos.filter';
        $entity='order_amos';

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
        $entityItem = new OrderAmo();
        $columns = Schema::getColumnListing('order_amos'); // users table


        $entity='order_amos';
        $action="order_amos.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        OrderAmo::create($request->post());
        return redirect()->route("order_amos.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=OrderAmo::findOrFail($id);
        $columns = Schema::getColumnListing('order_amos'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=OrderAmo::find($id);
        $columns = Schema::getColumnListing('order_amos'); // users table
        $entity='order_amos';
        $action="order_amos.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=OrderAmo::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('order_amos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=OrderAmo::find($id);
        $entityItem->delete();

        return redirect()->route('order_amos.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = OrderAmo::query();
        $columns = Schema::getColumnListing('order_amos');

        if (isset($request->columns)){
            $requestColumns = $request->columns;
            $requestColumns[]="id";
            $columns =$requestColumns;
            $entityItems = OrderAmo::query()->select($requestColumns);
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
        $urlEdit="order_amos.edit";
        $urlShow="order_amos.show";
        $urlDelete="order_amos.destroy";
        $urlCreate="order_amos.create";
        $urlFilter ='order_amos.filter';
        $urlReset = 'order_amos.index';
        $entity='order_amos';

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
