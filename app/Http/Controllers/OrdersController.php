<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Color;
use App\Models\Column;
use App\Models\Delivery;
use App\Models\FenceType;
use App\Models\Option;
use App\Models\Order;
use App\Models\OrdersPosition;
use App\Models\Product;
use App\Models\ProductsCategory;
use App\Models\VehicleType;
use App\Models\Wall;
use App\Services\Entity\CounterpartyService;
use App\Services\Entity\OrderService;
use Doctrine\DBAL\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entityItems = Order::query()->paginate(50);
        $columns = Schema::getColumnListing('orders'); // users table
        $needMenuForItem = true;
        $urlEdit = "orders.edit";
        $urlShow = "orders.show";
        $urlDelete = "orders.destroy";
        $urlCreate = "orders.create";
        $urlFilter = 'orders.filter';
        $entity = 'orders';

        $resColumns = [];
        $resColumnsAll = [];

        foreach ($columns as $column) {
            $resColumns[$column] = trans("column." . $column);
        }

        uasort($resColumns, function ($a, $b) {
            return ($a > $b);
        });

        $resColumsAll = $resColumns;

        return view("own.index", compact('entityItems', "resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity", 'urlFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = Option::where("module", "calc")->get();
        $defaultValues = [];

        foreach ($options as $option) {
            $defaultValues[$option->code] = $option->value;
        }

        $fenceTypes = FenceType::all();
        $wallsHeights = Wall::all();
        $columnsHeights = Column::all();
        $colors = Color::all();
        $deliveries = Delivery::all()->sortBy("name");
        $vehicleTypes = VehicleType::all()->sortBy("sort");
        $productsCategories = ProductsCategory::where("is_active", 1)->get();
        $productsBD = Product::where("is_active", 1)->orderBy("category_id")->get();
        $products = [];
        $action = "orders.store";

        foreach ($productsBD as $product) {
            $products[$product->category_id][$product->color_id] =
                [
                    "id" => $product->id,
                    "price" => $product->price,
                    "weight_kg" => $product->weight_kg,
                    "count_pallets" => $product->count_pallets,
                    'quantity' => 1
                ];
        }

        return view("orders.create", compact('fenceTypes', 'wallsHeights', 'columnsHeights', 'colors', "deliveries", "vehicleTypes", "productsCategories", 'defaultValues', 'products', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $entityItem = Order::firstOrCreate([
            'name' => $request->name,
            'phone' => $request->phone,
            'delivery_id' => $request->delivery_id,
            'vehicle_type_id' => $request->vehicle_type_id,
            'fence_length' => $request->fence_length,
            'number_of_columns' => $request->number_of_columns,
            'fence_type_id' => $request->fence_type_id,
            'wall_id' => $request->wall_id,
            "column_id" => $request->column_id,
            'weight' => $request->weight,
            'sum' => $request->sum,
            'delivery_price' => $request->deliveryPrice[$request->vehicle_type_id]
        ]);

        foreach ($request->products as $product) {
            $position = json_decode($product);

            OrdersPosition::create([
                'order_id' => $entityItem->id,
                'product_id' => $position->id,
                "quantity" => $position->quantity,
                "sum" => 0,
                //        'weight'=>$position->weight,
                'price' => $position->price
            ]);
        }

        return redirect()->route("orders.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entityItem = Order::findOrFail($id);
        $columns = Schema::getColumnListing('orders'); // users table
        return view("orders.show", compact('entityItem', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entityItem = Order::find($id);
        $columns = Schema::getColumnListing('orders'); // users table
        $entity = 'orders';
        $action = "orders.update";

        return view("own.edit", compact('entityItem', 'columns', 'action', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entityItem = Order::find($id);
        $entityItem->fill($request->post())->save();

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entityItem = Order::find($id);
        $entityItem->positions()->delete();
        $entityItem->delete();

        return redirect()->route('orders.index');
    }

    public function delivery(Request $request)
    {
        $distance = Delivery::find($request->delivery_id)->distance;
        $weight = $request->weight_kg;
        $prices = DB::table('vehicle_types')->pluck('id');

        $deliveryPrices = [];

        if ($distance != 0) {
            //Можно выбрать самый оптимальный тоннаж , удовлетв условию, то есть пробежаться по всем и получить одно число.
            $distances = DB::table('shipping_prices')
                ->select(\DB::raw('MIN(distance) AS distance, vehicle_type_id'))
                ->groupBy("vehicle_type_id")
                ->where("distance", ">=", $distance)
                ->get();

            foreach ($distances as $distance) {

                $min = DB::table('shipping_prices')
                    ->select(\DB::raw('MIN(tonnage) AS min_tonnage'))
                    ->where('vehicle_type_id', "=", $distance->vehicle_type_id)
                    ->where("distance", "=", $distance->distance)
                    ->where('tonnage', '>=', $weight)
                    ->get();

                $minTonnage = $min->value("min_tonnage");

                if ($minTonnage != null) {
                    $price = DB::table('shipping_prices')
                        ->select("id", "price", "tonnage")
                        ->where('vehicle_type_id', "=", $distance->vehicle_type_id)
                        ->where("distance", "=", $distance->distance)
                        ->where('tonnage', '=', $minTonnage)
                        ->get();

                    $deliveryPrices[$distance->vehicle_type_id] = round($price->value("price") * $price->value("tonnage") / 100) * 100;
                } else {
                    if (
                        $distance->vehicle_type_id == "a4ee16dd-8d7e-11ec-0a80-0f9b002ff027"
                        ||
                        $distance->vehicle_type_id == "93da19d9-f355-11ed-0a80-043100015554"
                    ) {

                        $min = DB::table('shipping_prices')
                            ->select(\DB::raw('MAX(tonnage) AS max_tonnage'))
                            ->where('vehicle_type_id', "=", $distance->vehicle_type_id)
                            ->where("distance", "=", $distance->distance)
                            ->where('tonnage', '<', round($weight))
                            ->get();

                        $maxTonnage = $min->value("max_tonnage");

                        $price = DB::table('shipping_prices')
                            ->select("id", "price")
                            ->where('vehicle_type_id', "=", $distance->vehicle_type_id)
                            ->where("distance", "=", $distance->distance)
                            ->where('tonnage', '=', $maxTonnage)
                            ->get();

                        $deliveryPrices[$distance->vehicle_type_id] = round($price->value("price") * round($weight) / 100) * 100;
                    } else {
                        $deliveryPrices[$distance->vehicle_type_id] = null;
                    }
                }
            }
        }

        foreach ($prices as $price) {
            if (!isset($deliveryPrices[$price])) {
                $deliveryPrices[$price] = 0;
            } elseif ($deliveryPrices[$price] == null) {
                $deliveryPrices[$price] = 0;
            }
        }

        return response()->json(['prices' => $deliveryPrices]);
    }


    public function createOrderMs(string $id, CounterpartyService $counterpartyService, OrderService $orderService)
    {
        $entityItem = Order::find($id);

        $msOrder["delivery"]["id"] = $entityItem->delivery->id;
        $msOrder["delivery"]["name"] = $entityItem->delivery->name;

        $msOrder["vehicle_type"]["id"] = $entityItem->vehicle_type->id;
        $msOrder["vehicle_type"]["name"] = $entityItem->vehicle_type->name;

        $msOrder["deliveryPrice"] = $entityItem->delivery_price;
        $msOrder["positions"] = [];

        foreach ($entityItem->positions as $position) {

            if ($position->quantity > 0)
                $msOrder["positions"][] = ["product_id" => $position->product_id, "quantity" => $position->quantity, "price" => $position->price];
        }

        $msContact = ["name" => $entityItem->name, "phone" => $entityItem->phone];

        $result = $counterpartyService->issetCounterpartyMS($msContact);

        if (isset($result["id"])) {
            $msOrder["contact"] = $result["id"];
            $result = $orderService->updateOrderMs($msOrder);
            return redirect()->route('orders.index');
        }
    }

    /**
     * @throws Exception
     */
    public function filter(FilterRequest $request)
    {
        $orderBy  = $request->orderBy;
        $selectColumn = $request->getColumn();
        $entityItems = Order::query();
        $columns = Schema::getColumnListing('orders');

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
            $entityItems = Order::query()->select($requestColumns);
        }

        $columnIsForeignKey = false;
        $foreignKeyData = null;
        try {
            $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('orders');
            foreach ($foreignKeys as $foreignKey) {
                foreach ($request->columns as $column) {
                    if ($foreignKey->getLocalColumns() === [$column]) {
                        $columnIsForeignKey = true;
                        $foreignKeyData = $foreignKey;
                        break;
                    }
                }
            }
        } catch (\Throwable $e) {
        }
        if ($columnIsForeignKey && $orderBy == 'asc') {
            $entityItems = $entityItems
                ->join($foreignKeyData->getForeignTableName(), 'orders.' . $request->getColumn(), '=', $foreignKeyData->getForeignTableName() . '.id')
                ->orderBy($foreignKeyData->getForeignTableName() . '.' . "name")
                ->paginate(50);
            $orderBy = 'desc';
        } elseif ($columnIsForeignKey && $orderBy == 'desc') {
            $entityItems = $entityItems
                ->join($foreignKeyData->getForeignTableName(), 'orders.' . $request->getColumn(), '=', $foreignKeyData->getForeignTableName() . '.id')
                ->orderByDesc($foreignKeyData->getForeignTableName() . '.' . "name")
                ->paginate(50);
            $orderBy = 'asc';
        } elseif (isset($request->orderBy) && $orderBy == 'asc') {
            $entityItems =    $entityItems->orderBy($request->getColumn())->paginate(50);
            $orderBy = 'desc';
        } elseif (isset($request->orderBy) && $orderBy == 'desc') {
            $entityItems =    $entityItems->orderByDesc($request->getColumn())->paginate(50);
            $orderBy = 'asc';
        } else {
            $entityItems =   $entityItems->paginate(50);
        }

        $needMenuForItem = true;
        $urlEdit = "orders.edit";
        $urlShow = "orders.show";
        $urlDelete = "orders.destroy";
        $urlCreate = "orders.create";
        $urlFilter = 'orders.filter';
        $urlReset = 'orders.index';
        $entity = 'orders';


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
        return view("own.index", compact('entityItems', 'selectColumn', "resColumns", "resColumnsAll", "needMenuForItem", "urlShow", "urlDelete", "urlEdit", "urlCreate", "entity", 'urlFilter', 'urlReset', 'orderBy'));
    }
}
