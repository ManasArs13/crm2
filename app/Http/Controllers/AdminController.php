<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccessTokenRequest;
use App\Models\Option;
use App\Models\Order;
use App\Models\OrderMs;
use App\Models\Product;
use App\Services\Api\AmoService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
   public  AmoService $amoService;

    public function __construct(AmoService $amoService)
    {
         $this->amoService = $amoService;
    }

    public function __invoke()
    {
        $entityItems=Order::query()->paginate(50);
        $columns = Schema::getColumnListing('orders'); // users table
        $resColumns=[];
        foreach ($columns as $column) {
            $resColumns[$column]=trans("column.".$column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        $urlEdit="";
        $entity="orders";
        $urlFilter = 'orders.filter';

        $urlCreate="orders.create";
        $needMenuForItem=true;

        return view("own.index", compact('entityItems',"urlEdit", "urlCreate", "entity", "needMenuForItem", 'resColumns','urlFilter'));
    }


    public function index(): View
    {
        return view('importAccessToken.token');
    }


    public function updateAccessToken(UpdateAccessTokenRequest $request ): RedirectResponse
    {
         Option::query()->updateOrCreate(
            ['code' => 'code'],
            ['value' => $request->getCode()]
        );
         return redirect('/get_token');
    }
    public function getAccessToken():RedirectResponse
    {
        try {
            $this->amoService->getAccessToken();
            return redirect('/add_token')->with('success', 'Update successful');
        }catch(Exception $e){
            return redirect('/add_token')->with('error', 'Update failed ');
        }
    }
}
