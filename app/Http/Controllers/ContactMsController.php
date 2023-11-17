<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\ContactMs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ContactMsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems=ContactMs::query()->paginate(50);
        $columns = Schema::getColumnListing('contact_ms'); // users table
        $needMenuForItem=true;
        $urlEdit="contact_ms.edit";
        $urlShow="contact_ms.show";
        $urlDelete="contact_ms.destroy";
        $urlCreate="contact_ms.create";
        $urlFilter ='contact_ms.filter';
        $entity='contact_ms';

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
        $entityItem = new ContactMs();
        $columns = Schema::getColumnListing('contact_ms'); // users table


        $entity='contact_ms';
        $action="contact_ms.store";

        return view('own.create', compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ContactMs::create($request->post());
        return redirect()->route("contact_ms.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem=ContactMs::findOrFail($id);
        $columns = Schema::getColumnListing('contact_ms'); // users table
        return view("own.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem=ContactMs::find($id);
        $columns = Schema::getColumnListing('contact_ms'); // users table
        $entity='contact_ms';
        $action="contact_ms.update";

        return view("own.edit", compact('entityItem','columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem=ContactMs::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('contact_ms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem=ContactMs::find($id);
        $entityItem->delete();

        return redirect()->route('contact_ms.index');
    }
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = ContactMs::query();
        $columns = Schema::getColumnListing('contact_ms');

        if (isset($request->columns)){
            $requestColumns = $request->columns;
            $requestColumns[]="id";
            $columns =$requestColumns;
            $entityItems = ContactMs::query()->select($requestColumns);
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
        $urlEdit="contact_ms.edit";
        $urlShow="contact_ms.show";
        $urlDelete="contact_ms.destroy";
        $urlCreate="contact_ms.create";
        $urlFilter ='contact_ms.filter';
        $urlReset = 'contact_ms.index';
        $entity='contact_ms';

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

        return view("own.index", compact('entityItems','selectColumn',"resColumns", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity",'urlFilter','urlReset','orderBy'));
    }
}
