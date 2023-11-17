<?php

namespace App\Services\Entity;

use App\Contracts\EntityInterface;
use App\Models\OrderMs;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductsCategory;
use App\Models\Shipments;
use App\Models\ShipmentsProducts;
use App\Services\Api\MoySkladService;
use Illuminate\Support\Arr;

class DemandServices implements EntityInterface
{
    private Option $options;

    public MoySkladService $service;
    public function __construct(Option $options, MoySkladService $service)
    {
        $this->service = $service;
        $this->options = $options;
    }

    /**
     * @param array $rows
     * @return void
     */
    public function import(array $rows): void
    {
        $attributeDelivery = $this->options::query()->where('code', '=', "ms_order_delivery_guid")->first()?->value;
        $attributeTransport = $this->options::query()->where("code", '=', "ms_order_transport_guid")->first()?->value;
        $attributeVehicleType = $this->options::query()->where("code", '=', "ms_order_vehicle_type_guid")->first()?->value;
        $attributeDeliveryPrice = $this->options::query()->where("code", '=', "ms_order_delivery_price_guid")->first()?->value;

        foreach ($rows['rows'] as $row) {
            $products = $row['positions']['rows'];
            $urlService = 'https://api.moysklad.ru/app/#demand/edit?id=';

            $entity = Shipments::query()->firstOrNew(['id' => $row["id"]]);
            if (Arr::exists($row, 'deleted')) {
                if ($entity->id === null) {
                    $entity->delete();
                }
            } else {

                $delivery = null;
                $transport = null;
                $deliveryPrice = 0;
                $vehicleType = null;

                $orderId = isset($row['customerOrder']) ? $this->getGuidFromUrl($row['customerOrder']['meta']['href']) : null;
                $entity->id = $row['id'];
                $entity->name = $row['name'];
                $entity->description = !empty($row['description']) ? $row['description'] : null;
                $entity->shipment_address = $row['shipmentAddress'] ?? null;
                $entity->order_id = OrderMs::query()->where('id', $orderId)->exists() ? $orderId : null;
                $entity->counterparty_link = $row['agent']['meta']['uuidHref'];
                $entity->service_link = $urlService . $row['id'];
                $entity->paid_sum = $row['payedSum'] / 100;
                $entity->status = isset($row['state']) ? $row['state']['name'] : null;
                $entity->created_at = $row['moment'];
                $entity->suma = $row['sum'] / 100;
                $entity->updated_at = $row['updated'];


                if (isset($row["attributes"])) {
                    foreach ($row["attributes"] as $attribute) {
                        switch ($attribute["id"]) {
                            case $attributeDelivery:
                                $delivery = $attribute["value"]["id"];
                                break;
                            case $attributeTransport:
                                $transport = $attribute["value"]["id"];
                                break;
                            case $attributeVehicleType:
                                $vehicleType = $attribute["value"]["id"];
                                break;
                            case $attributeDeliveryPrice:
                                $deliveryPrice = $attribute["value"];
                                break;
                        }
                    }
                }

                $entity->transport_id=$transport;
                $entity->delivery_id=$delivery;
                $entity->vehicle_type_id=$vehicleType;
                $entity->delivery_price=$deliveryPrice;
                $entity->save();

                foreach ($products as $product) {
                    $productData = null;
                    if (isset($product['assortment']['meta']['href'])) {
                        $productData = $this->service->actionGetRowsFromJson($product['assortment']['meta']['href'], false);
                    }
                    $product_id = Product::query()->where('id', $productData['id'])->first()->id;
                    if ($product_id) {
                        ShipmentsProducts::query()->updateOrCreate(
                            ['shipment_id' => $row['id']],
                            [
                                'shipment_id' => $row['id'],
                                'quantity' => $product['quantity'],
                                'product_id' => $productData['id'],
                            ]
                        );
                    }
                }
            }
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function getGuidFromUrl($url): string
    {
        $arUrl = explode("/", $url);
        return $arUrl[count($arUrl) - 1];
    }
}
