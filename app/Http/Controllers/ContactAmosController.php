<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\ContactAmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ContactAmosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=ContactAmo::query()->paginate(50);
        $columns = Schema::getColumnListing('contact_amos');
        $needMenuForItem=true;
        $urlEdit="contact_amos.edit";
        $urlShow="contact_amos.show";
        $urlDelete="contact_amos.destroy";
        $urlCreate="contact_amos.create";
        $urlFilter ='contact_amos.filter';
        $entity='contact_amos';

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
        $entityItem = new ContactAmo();
        $columns = Schema::getColumnListing('contact_amos'); // users table


        $entity='contact_amos';
        $action="contact_amos.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ContactAmo::create($request->post());
        return redirect()->route("contact_amos.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=ContactAmo::findOrFail($id);
        $columns = Schema::getColumnListing('contact_amos'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=ContactAmo::find($id);
        $columns = Schema::getColumnListing('contact_amos'); // users table
        $entity='contact_amos';
        $action="contact_amos.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=ContactAmo::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('contact_amos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=ContactAmo::find($id);
        $entityItem->delete();

        return redirect()->route('contact_amos.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = ContactAmo::query();
        $columns = Schema::getColumnListing('contact_amos');

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
            $entityItems = ContactAmo::query()->select($requestColumns);
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
        $urlEdit="contact_amos.edit";
        $urlShow="contact_amos.show";
        $urlDelete="contact_amos.destroy";
        $urlCreate="contact_amos.create";
        $urlFilter ='contact_amos.filter';
        $urlReset = 'contact_amos.index';
        $entity='contact_amos';

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
