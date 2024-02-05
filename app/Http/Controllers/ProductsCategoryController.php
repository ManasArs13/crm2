<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\ProductsCategory\StoreRequest;
use App\Http\Requests\ProductsCategory\UpdateRequest;
use App\Models\ProductsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProductsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entity='products_categories';

        $entityItems=ProductsCategory::query()->orderByDesc('sort') ->paginate(50);
        if ($request->type == 'products'){
            $entityItems = ProductsCategory::query()->where('type',ProductsCategory::PRODUCTS)->orderByDesc('sort')->paginate(50);
        }elseif ($request->type == 'materials'){
            $entity='products_categories_materials';
            $entityItems = ProductsCategory::query()->where('type',ProductsCategory::MATERIAL)->orderByDesc('sort')->paginate(50);
        }
        $columns = Schema::getColumnListing('products_categories'); // users table
        $needMenuForItem=true;
        $urlEdit="products_categories.edit";
        $urlShow="products_categories.show";
        $urlDelete="products_categories.destroy";
        $urlCreate="products_categories.create";
        $urlFilter ='products_categories.filter';

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
        $entityItem = new ProductsCategory();
        $columns = Schema::getColumnListing('products_categories'); // users table


        $entity='products_categories';
        $action="products_categories.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ProductsCategory::create($request->post());
        return redirect()->route("products_categories.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=ProductsCategory::findOrFail($id);
        $columns = Schema::getColumnListing('products_categories'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=ProductsCategory::find($id);
        $columns = Schema::getColumnListing('products_categories'); // users table
        $entity = 'products_categories';
        if ($entityItem->type == ProductsCategory::MATERIAL){
           $entity = 'products_categories_materials';
        }
        $action="products_categories.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=ProductsCategory::find($id);
        $entityItem->fill($request->post())->save();
        $action = '/admin/products_categories';
        if ($entityItem->type == ProductsCategory::MATERIAL){
            $action = '/admin/products_categories?type=materials';
        }elseif($entityItem->type == ProductsCategory::PRODUCTS){
            $action = '/admin/products_categories?type=products';
        }
        return redirect()->to($action);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=ProductsCategory::query()->find($id);
        $entityItem->delete();
        $action = '/admin/products_categories';
        if ($entityItem->type == ProductsCategory::MATERIAL){
            $action = '/admin/products_categories?type=materials';
        }elseif($entityItem->type == ProductsCategory::PRODUCTS){
            $action = '/admin/products_categories?type=products';
        }
        return redirect()->to($action);
    }
    public function filter(FilterRequest $request)
    {
        $entity='products_categories';
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = ProductsCategory::query();

        if ($request->type == 'products'){
            $entityItems = ProductsCategory::query()->where('type',ProductsCategory::PRODUCTS);
        }elseif ($request->type == 'materials'){
            $entity = 'products_categories_materials';
            $entityItems = ProductsCategory::query()->where('type',ProductsCategory::MATERIAL);
        }

        $columns = Schema::getColumnListing('products_categories');

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
            $entityItems = ProductsCategory::query()->select($requestColumns);
        }
        if (isset($request->orderBy)  && $request->orderBy == 'asc') {
            $entityItems = $entityItems->orderBy($request->getColumn())->orderByDesc('sort')->paginate(50);
            $orderBy = 'desc';
        }elseif (isset($request->orderBy)  && $request->orderBy == 'desc') {
            $entityItems = $entityItems->orderByDesc($request->getColumn())->orderByDesc('sort')->paginate(50);
            $orderBy = 'asc';
        } else{
            $entityItems =   $entityItems->paginate(50);
        }
        $needMenuForItem=true;
        $urlEdit="products_categories.edit";
        $urlShow="products_categories.show";
        $urlDelete="products_categories.destroy";
        $urlCreate="products_categories.create";
        $urlFilter ='products_categories.filter';
        $urlReset = 'products_categories.index';
        $entity='products_categories';

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
