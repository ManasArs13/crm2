<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSyncOrdersRequest;
use App\Models\OrderAmo;
use App\Models\OrderMs;
use App\Models\SyncOrdersContacts\OrderMsOrderAmo;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SyncOrderMsAmoController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
       $orders = OrderMs::query()->with('orderAmo')->paginate(50);
        $urlEdit  = 'edit.sync';
        return view('SyncOrder.sync',compact('orders','urlEdit'));
    }


    /**
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        $orderMs = OrderMs::query()->with(['orderAmo', 'contact_ms'])->find($request->id);
        $contactMs = $orderMs->contact_ms;
        $suggestions = [];
        if ($contactMs && $contactMs->phone_norm) {
            $suggestions = OrderAmo::query()->whereHas('contact_amo', function (Builder $query) use ($contactMs) {
                $query->where('phone_norm', $contactMs->phone_norm);
            })->get();
        }
        $orderAmo = $orderMs->orderAmo;
        $id = $request->id;
        $urlSync = 'order.sync';
        return view('SyncOrder.edit',compact('orderMs','orderAmo','urlSync','id','suggestions'));
    }


    /**
     * @param StoreSyncOrdersRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSyncOrdersRequest $request): RedirectResponse
    {
        if (isset($request->notSync)){
            OrderMsOrderAmo::query()->where('order_ms_id',$request->order_ms_id)->delete();
            return  redirect()->route("sync");
        }
        $budget = OrderAmo::query()->find($request->id)->price;
        $orderMsOrderAmo  =new OrderMsOrderAmo();
        $orderMsOrderAmo->order_amo_id=$request->id;
        $orderMsOrderAmo->order_ms_id =$request->order_ms_id;
        $orderMsOrderAmo->is_manual = true;
        $orderMsOrderAmo->save();
      return  redirect()->route("sync");
    }

}
