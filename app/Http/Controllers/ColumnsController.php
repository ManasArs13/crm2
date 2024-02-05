<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ColumnsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems = Column::query()->paginate(50);
        $columns = Schema::getColumnListing('columns'); // users table
        $needMenuForItem = true;
        $urlEdit = "columns.edit";
        $urlShow = "columns.show";
        $urlDelete = "columns.destroy";
        $urlCreate = "columns.create";
        $urlFilter = 'columns.filter';
        $entity = 'columns';

        $resColumns = [];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumns[$column] = trans("column." . $column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        $resColumnsAll = $resColumns;

        return view("own.index", compact('entityItems', "resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity", 'urlFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entityItem = new Column();
        $columns = Schema::getColumnListing('columns'); // users table


        $entity = 'columns';
        $action = "columns.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Column::create($request->post());
        return redirect()->route("columns.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem = Column::findOrFail($id);
        $columns = Schema::getColumnListing('columns'); // users table
        return view("own.show", compact('entityItem', "columns"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem = Column::find($id);
        $columns = Schema::getColumnListing('columns'); // users table
        $entity = 'columns';
        $action = "columns.update";

        return view("own.edit", compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem = Column::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('columns.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem = Column::find($id);
        $entityItem->delete();

        return redirect()->route('columns.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = Column::query();
        $columns = Schema::getColumnListing('columns');

        $resColumns = [];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumnsAll[$column] = trans("column." . $column);
        }

        uasort($resColumnsAll, function ($a, $b) {
            return ($a > $b);
        });

        if (isset($request->columns)) {
            $requestColumns = $request->columns;
            $requestColumns[] = "id";
            $columns = $requestColumns;
            $entityItems = Column::query()->select($requestColumns);
        }
        if (isset($request->orderBy)  && $request->orderBy == 'asc') {
            $entityItems = $entityItems->orderBy($request->getColumn())->paginate(50);
            $orderBy = 'desc';
        } elseif (isset($request->orderBy)  && $request->orderBy == 'desc') {
            $entityItems = $entityItems->orderByDesc($request->getColumn())->paginate(50);
            $orderBy = 'asc';
        } else {
            $entityItems =   $entityItems->paginate(50);
        }
        $needMenuForItem = true;
        $urlEdit = "columns.edit";
        $urlShow = "columns.show";
        $urlDelete = "columns.destroy";
        $urlCreate = "columns.create";
        $urlFilter = 'columns.filter';
        $urlReset = 'columns.index';
        $entity = 'columns';


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

        return view("own.index", compact('entityItems', "resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity", 'urlFilter', 'urlReset', 'orderBy', 'selectColumn'));
    }
}
