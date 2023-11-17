<?php

namespace Database\Seeders;

use App\Models\OrderAmo;
use App\Models\OrderMs;
use App\Models\SyncOrdersContacts\OrderMsOrderAmo;
use Illuminate\Database\Seeder;

class SyncOrderFromLink extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $orderMs = OrderMs::query()->whereNotNull('order_amo_link')->where('order_amo_link' ,'!=' ,'')->get();
       foreach ($orderMs as $order){
           $orderAmoId =(integer) substr($order->order_amo_link,strrpos($order->order_amo_link,'/')+ 1);
           $orderAmo = OrderAmo::query()->where('id',$orderAmoId)->exists();
           if ($orderAmo){
            $syncOrders = new OrderMsOrderAmo();
            $syncOrders->order_ms_id = $order->id;
            $syncOrders->order_amo_id = $orderAmoId;
            $syncOrders->save();
           }
       }
    }
}
