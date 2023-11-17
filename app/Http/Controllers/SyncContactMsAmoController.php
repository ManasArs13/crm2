<?php

namespace App\Http\Controllers;

use App\Models\ContactMs;
use App\Models\SyncOrdersContacts\ContactMsContactAmo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SyncContactMsAmoController extends Controller
{
    public function index(): View
    {
        $contacts = ContactMs::query()
            ->whereHas('contactAmo')
            ->with('contactAmo')
            ->paginate(50);
        $urlEdit  = 'editContact.sync';
        return view('SyncContact.contact',compact('contacts','urlEdit'));
    }


    /**
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        $contacts = ContactMsContactAmo::query()->find($request->id);
        $contactMs = $contacts->contactMs;
        $contactAmo = $contacts->contactAmo;
        $id = $request->id;
        $urlSync = 'contactSync.sync';
        return view('SyncContact.edit',compact('contactMs','contactAmo','urlSync','id'));
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        ContactMsContactAmo::query()->where('id',$request->id)->update(['is_unique'=>$request->sync]);

        return  redirect()->route("show");
    }
}
