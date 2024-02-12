<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Order;
use App\Models\OrderMs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class OrderMsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems = OrderMs::query()->paginate(50);
        $columns = Schema::getColumnListing('order_ms'); // users table
        $needMenuForItem = true;
        $urlEdit = "order_ms.edit";
        $urlShow = "order_ms.show";
        $urlDelete = "order_ms.destroy";
        $urlCreate = "order_ms.create";
        $urlFilter = 'order_ms.filter';
        $entity = 'order_ms';

        $resColumns = [];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumns[$column] = trans("column." . $column);
            $resColumnsAll[$column] = ['name_rus' => trans("column." . $column), 'checked' => false];
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        uasort($resColumnsAll, function ($a, $b) {
            return ($a > $b);
        });

        $minCreated = OrderMs::query()->min('created_at');
        $maxCreated = OrderMs::query()->max('created_at');
        $minUpdated = OrderMs::query()->min('updated_at');
        $maxUpdated = OrderMs::query()->max('updated_at');

        $filters = [
            [
                'type' => 'date',
                'name' =>  'created_at',
                'name_rus' => 'Дата создания',
                'min' => substr($minCreated, 0, 10),
                'max' => substr($maxCreated, 0, 10)
            ],
            [
                'type' => 'date',
                'name' =>  'updated_at',
                'name_rus' => 'Дата обновления',
                'min' => substr($minUpdated, 0, 10),
                'max' => substr($maxUpdated, 0, 10)
            ],
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
        $entityItem = new OrderMs();
        $columns = Schema::getColumnListing('order_ms'); // users table


        $entity = 'order_ms';
        $action = "order_ms.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        OrderMs::create($request->post());
        return redirect()->route("order_ms.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem = OrderMs::findOrFail($id);
        $columns = Schema::getColumnListing('order_ms'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem = OrderMs::find($id);
        $columns = Schema::getColumnListing('order_ms'); // users table
        $entity = 'order_ms';
        $action = "order_ms.update";

        return view("own.edit", compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem = OrderMs::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('order_ms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem = OrderMs::find($id);
        $entityItem->delete();

        return redirect()->route('order_ms.index');
    }
    public function filter(FilterRequest $request)
    {
        $needMenuForItem = true;
        $urlEdit = "order_ms.edit";
        $urlShow = "order_ms.show";
        $urlDelete = "order_ms.destroy";
        $urlCreate = "order_ms.create";
        $urlFilter = 'order_ms.filter';
        $urlReset = 'order_ms.index';
        $entity = 'order_ms';

        $orderBy  = $request->orderBy;
        $entityItems = OrderMs::query();
        $columns = Schema::getColumnListing('order_ms');
        $resColumns = [];
        $resColumnsAll = [];

        /* Колонки для меню */
        foreach ($columns as $column) {
            $resColumnsAll[$column] = [
                'name_rus' => trans("column." . $column),
                'checked' => in_array($column, $request->columns ? $request->columns : []) ? true : false
            ];
        }

        uasort($resColumnsAll, function ($a, $b) {
            return ($a > $b);
        });

        /* Колонки для отображения */
        if (isset($request->columns)) {
            $requestColumns = $request->columns;
            $requestColumns[] = "id";
            $columns = $requestColumns;
            $entityItems = OrderMs::query()->select($requestColumns);
        }

        foreach ($columns as $column) {
            $resColumns[$column] = trans("column." . $column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        if (isset($request->filters)) {
            foreach ($request->filters as $key => $value) {
                if ($key == 'created_at' || $key == 'updated_at') {
                    $entityItems = OrderMs::query()
                        ->where($key, '>=', $value['min'] . ' 00:00:00')
                        ->where($key, '<=', $value['max'] . ' 23:59:59');
                }
            }
        }


        /* Сортировка */
        if (isset($request->orderBy)  && $request->orderBy == 'asc') {
            $entityItems = $entityItems->orderBy($request->getColumn())->paginate(50);
            $orderBy = 'desc';
        } else if (isset($request->orderBy)  && $request->orderBy == 'desc') {
            $entityItems = $entityItems->orderByDesc($request->getColumn())->paginate(50);
            $orderBy = 'asc';
        } else {
            $entityItems = $entityItems->paginate(50);
        }



        $minCreated = OrderMs::query()->min('created_at');
        $maxCreated = OrderMs::query()->max('created_at');
        $minUpdated = OrderMs::query()->min('updated_at');
        $maxUpdated = OrderMs::query()->max('updated_at');

        $filters = [
            [
                'type' => 'date',
                'name' =>  'created_at',
                'name_rus' => 'Дата создания',
                'min' => substr($minCreated, 0, 10),
                'max' => substr($maxCreated, 0, 10)
            ],
            [
                'type' => 'date',
                'name' =>  'updated_at',
                'name_rus' => 'Дата обновления',
                'min' => substr($minUpdated, 0, 10),
                'max' => substr($maxUpdated, 0, 10)
            ],
        ];

        return view("own.index", compact(
            'entityItems',
            //   'selectColumn',
            "resColumns",
            "resColumnsAll",
            "needMenuForItem",
            "urlShow",
            "urlDelete",
            "urlEdit",
            "urlCreate",
            "entity",
            'urlFilter',
            'urlReset',
            'orderBy',
            'filters'
        ));
    }
}
