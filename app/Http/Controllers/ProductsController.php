<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entity = 'products';
        $entityItems = Product::query()->where('type', Product::PRODUCTS)->orderByDesc('sort')->paginate(50);
        if ($request->type == 'materials') {
            $entity = 'materials';
            $entityItems = Product::query()->where('type', Product::MATERIAL)->orderByDesc('sort')->paginate(50);
        }
        $columns = Schema::getColumnListing('products');
        $needMenuForItem = true;
        $urlEdit = "products.edit";
        $urlShow = "products.show";
        $urlDelete = "products.destroy";
        $urlCreate = "products.create";
        $urlFilter = 'products.filter';
        $columns[] = 'remainder';

        $resColumns = [];
        $resColumnsAll = [];
        foreach ($columns as $column) {
            $resColumns[$column] = trans("column." . $column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        $resColumnsAll = $resColumns;

        $minCreated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->min('created_at');
        $maxCreated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->max('created_at');
        $minUpdated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->min('updated_at');
        $maxUpdated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->max('updated_at');
        $minWeight = Product::query()->where('type',  $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->min('weight_kg');
        $maxWeigth = Product::query()->where('type',  $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->max('weight_kg');

        $filters = [
            ['type' => 'data',  'name' =>  'created_at', 'name_rus' => 'Дата создания',  'min' => substr($minCreated, 0, 10), 'max' => substr($maxCreated, 0, 10)],
            ['type' => 'data',  'name' =>  'updated_at', 'name_rus' => 'Дата обнавления', 'min' => substr($minUpdated, 0, 10), 'max' => substr($maxUpdated, 0, 10)],
            ['type' => 'number', 'name' =>  'weight_kg',  'name_rus'=> 'Вес', 'min' => $minWeight,  'max' => $maxWeigth]
        ];

        return view("own.index", compact(
                                        'entityItems',
                                        "resColumns",
                                        "resColumnsAll",
                                        "needMenuForItem",
                                        "urlShow",
                                        "urlDelete",
                                        "urlEdit",
                                        "urlCreate",
                                        "entity",
                                        'urlFilter',
                                        'filters'
                                    ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entityItem = new Product();
        $columns = Schema::getColumnListing('products'); // users table


        $entity = 'products';
        $action = "products.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Product::query()->create($request->post());
        return redirect()->route("products.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem = Product::findOrFail($id);
        $columns = Schema::getColumnListing('products'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem = Product::find($id);
        $columns = Schema::getColumnListing('products'); // users table
        $entity = 'products';
        if ($entityItem->type == Product::MATERIAL) {
            $entity = 'materials';
        }

        $action = "products.update";

        return view("own.edit", compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem = Product::find($id);
        $entityItem->fill($request->post())->save();
        $action = '/admin/products?type=products';
        if ($entityItem->type == Product::MATERIAL) {
            $action = '/admin/products?type=materials';
        }
        return redirect()->to($action);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem = Product::query()->find($id);
        $entityItem->delete();
        $action = '/admin/products?type=products';
        if ($entityItem->type == Product::MATERIAL) {
            $action = '/admin/products?type=materials';
        }
        return redirect()->to($action);
    }
    public function filter(FilterRequest $request)
    {
        $entity = 'products';
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $selectFilter = $request->getFilter();
        $entityItems = Product::query();

        if ($request->type == 'products') {
            $entityItems = Product::query()->where('type', Product::PRODUCTS);
        } else if ($request->type == 'materials') {
            $entity = 'materials';
            $entityItems = Product::query()->where('type', Product::MATERIAL);
        }

        $columns = Schema::getColumnListing('products');

        $resColumns = [];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumnsAll[$column] = trans("column." . $column);
        }

        uasort($resColumnsAll, function ($a, $b) {
            return ($a > $b);
        });


        if(isset($request->filters)) {
            foreach ($request->filters as $key => $value) {
                Product::query()->whereBetween($key, [$value['min'], [$value['max']]]);
            }
        }
        

        if (isset($request->columns)) {
            $requestColumns = $request->columns;
            $requestColumns[] = "id";
            $columns = $requestColumns;
            $entityItems = Product::query()->select($requestColumns);
        }

        if (isset($request->orderBy)  && $request->orderBy == 'asc') {
            $entityItems = $entityItems->orderBy($selectColumn)->orderByDesc('sort')->paginate(50);
            $orderBy = 'desc';
        } elseif (isset($request->orderBy)  && $request->orderBy == 'desc') {
            $entityItems = $entityItems->orderByDesc($selectColumn)->orderByDesc('sort')->paginate(50);
            $orderBy = 'asc';
        } else {
            $entityItems =   $entityItems->orderByDesc('sort')->paginate(50);
        }

        $needMenuForItem = true;
        $urlEdit = "products.edit";
        $urlShow = "products.show";
        $urlDelete = "products.destroy";
        $urlCreate = "products.create";
        $urlFilter = 'products.filter';
        $urlReset = 'products.index';

        if (isset($request->resColumns)) {
            $resColumns = $request->resColumns;
        } else {
            foreach ($columns as $column) {
                $resColumns[$column] = trans("column." . $column);
            }
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        $minCreated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->min('created_at');
        $maxCreated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->max('created_at');
        $minUpdated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->min('updated_at');
        $maxUpdated = Product::query()->where('type', $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->max('updated_at');
        $minWeight = Product::query()->where('type',  $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->min('weight_kg');
        $maxWeigth = Product::query()->where('type',  $request->type == 'materials' ? Product::MATERIAL : Product::PRODUCTS)->max('weight_kg');

        $filters = [
            ['type' => 'data',  'name' =>  'created_at', 'name_rus' => 'Дата создания',  'min' => substr($minCreated, 0, 10), 'max' => substr($maxCreated, 0, 10)],
            ['type' => 'data',  'name' =>  'updated_at', 'name_rus' => 'Дата обнавления', 'min' => substr($minUpdated, 0, 10), 'max' => substr($maxUpdated, 0, 10)],
            ['type' => 'number', 'name' =>  'weight_kg',  'name_rus'=> 'Вес', 'min' => $minWeight,  'max' => $maxWeigth]
        ];

        return view("own.index", compact('entityItems', 'filters', "resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity", 'urlFilter', 'urlReset', 'orderBy', 'selectColumn'));
    }
}
