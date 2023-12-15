<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\ColumnsController;
use App\Http\Controllers\ContactAmosController;
use App\Http\Controllers\ContactMsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveriesController;
use App\Http\Controllers\FenceTypesController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\OrderAmosController;
use App\Http\Controllers\OrderMsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidualController;
use App\Http\Controllers\ShipmentsController;
use App\Http\Controllers\ShippingPricesController;
use App\Http\Controllers\StatusAmoController;
use App\Http\Controllers\StatusMsController;
use App\Http\Controllers\SyncContactMsAmoController;
use App\Http\Controllers\SyncOrderMsAmoController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\VehicleTypesController;
use App\Http\Controllers\WallsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   // return view('welcome');
    return redirect()->route('admin.dashboard');
});

Route::get('/dashboard', function () {
    //return view('dashboard');
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('is_admin')->group(function (){

    Route::get('/admin', AdminController::class);
    Route::get('add_token',[AdminController::class,'index'])->name('index');
    Route::patch('/update_access_token',[AdminController::class,'updateAccessToken'])->name('get.access');
    Route::get('/get_token',[AdminController::class,'getAccessToken']);


    Route::prefix('admin')->group(function () {
        Route::resources([
            'products_categories' => ProductsCategoryController::class,
            'fence_types' => FenceTypesController::class,
            'colors' => ColorsController::class,
            'columns' => ColumnsController::class,
            'deliveries' => DeliveriesController::class,
            'orders'=> OrdersController::class,
            'options'=> OptionsController::class,
            'products'=> ProductsController::class,
            'walls'=> WallsController::class,
            'vehicle_types'=> VehicleTypesController::class,
            'shipping_prices'=> ShippingPricesController::class,
            'contact_amos'=> ContactAmosController::class,
            'contact_ms'=> ContactMsController::class,
            'status_ms'=> StatusMsController::class,
            'status_amos'=> StatusAmoController::class,
            'transports'=> TransportController::class,
            'order_ms'=> OrderMsController::class,
            'order_amos'=> OrderAmosController::class,
            'shipments'=>ShipmentsController::class,
        ]);

        Route::get('/residuals', [ResidualController::class, 'all'])->name('residual');
        Route::get('/residuals/blocks_materials', [ResidualController::class, 'blocksMaterials'])->name('residual.blocksMaterials');
        Route::get('/residuals/blocks_categories', [ResidualController::class, 'blocksCategories'])->name('residual.blocksCategories');
        Route::get('/residuals/blocks_products', [ResidualController::class, 'blocksProducts'])->name('residual.blocksProducts');
        Route::get('/residuals/concretes_materials', [ResidualController::class, 'concretesMaterials'])->name('residual.concretesMaterials');

        Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');

        Route::post('/orders/delivery',[ OrdersController::class, 'delivery'])->name('orders.delivery');
        Route::get('/orders/create/{order}/ms',[ OrdersController::class, 'createOrderMs'])->name('orders.createOrderMs');
    });
    Route::get('/admin/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/dashboard-2',[DashboardController::class,'buildingsMaterialDashboard'])->name('admin.dashboard-2');
    Route::get('/admin/dashboard-3',[DashboardController::class,'buildingsMaterialDashboard'])->name('admin.dashboard-3');

    Route::get('/fetch-orders', [DashboardController::class,'fetchOrders'])->name('filter.orders');
    Route::get('/month-orders', [DashboardController::class,'getOrderMonth'])->name('month.orders');
    Route::get('/map_data',[DashboardController::class,'getOrderDataForMap'])->name('map.data');
    Route::get('/options/filter',[OptionsController::class,'filter'])->name('options.filter');
    Route::get('/products_categories/filter',[ProductsCategoryController::class,'filter'])->name('products_categories.filter');
    Route::get('/colors/filter',[ColorsController::class,'filter'])->name('colors.filter');
    Route::get('/columns/filter',[ColumnsController::class,'filter'])->name('columns.filter');
    Route::get('/deliveries/filter',[DeliveriesController::class,'filter'])->name('deliveries.filter');
    Route::get('/orders/filter',[OrdersController::class,'filter'])->name('orders.filter');
    Route::get('/products/filter',[ProductsController::class,'filter'])->name('products.filter');
    Route::get('/walls/filter',[WallsController::class,'filter'])->name('walls.filter');
    Route::get('/vehicle_types/filter',[VehicleTypesController::class,'filter'])->name('vehicle_types.filter');
    Route::get('/shipping_prices/filter',[ShippingPricesController::class,'filter'])->name('shipping_prices.filter');
    Route::get('/contact_amos/filter',[ContactAmosController::class,'filter'])->name('contact_amos.filter');
    Route::get('/contact_ms/filter',[ContactMsController::class,'filter'])->name('contact_ms.filter');
    Route::get('/status_ms/filter',[StatusMsController::class,'filter'])->name('status_ms.filter');
    Route::get('/status_amos/filter',[StatusAmoController::class,'filter'])->name('status_amos.filter');
    Route::get('/transports/filter',[TransportController::class,'filter'])->name('transports.filter');
    Route::get('/order_ms/filter',[OrderMsController::class,'filter'])->name('order_ms.filter');
    Route::get('/order_amos/filter',[OrderAmosController::class,'filter'])->name('order_amos.filter');
    Route::get('/fence_types/filter',[FenceTypesController::class,'filter'])->name('fence_types.filter');
    Route::get('/shipments/filter',[ShipmentsController::class,'filter'])->name('shipments.filter');

    Route::get('sync/order',[SyncOrderMsAmoController::class,'index'])->name('sync');
    Route::get('order_sync/edit',[SyncOrderMsAmoController::class,'edit'])->name('edit.sync');
    Route::post('order_sync/store',[SyncOrderMsAmoController::class,'store'])->name('order.sync');

    Route::get('show/contact_sync',[SyncContactMsAmoController::class,'index'])->name('show');
    Route::get('contact_sync/edit',[SyncContactMsAmoController::class,'edit'])->name('editContact.sync');
    Route::get('contact_sync/store',[SyncContactMsAmoController::class,'store'])->name('contactSync.sync');
});

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";});


Route::get('/ms', function() {
    Artisan::call('ms:import-transport');
    return "Кэш очищен.";
});

require __DIR__.'/auth.php';
