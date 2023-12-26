<?php

namespace App\Services\Entity;

use App\Contracts\EntityInterface;
use App\Models\Option;
use App\Models\Product;
use App\Models\TechChart;
use App\Models\TechChartMaterial;
use App\Models\TechChartProduct;
use App\Services\Api\MoySkladService;

class ProductService implements EntityInterface
{
    private $options;
    private $service;

    public function __construct(Option $options, MoySkladService $service)
    {
        $this->options = $options;
        $this->service = $service;
    }

    public function import(array $rows)
    {
        $countPalletsGuid = $this->options::where('code', '=', "ms_count_pallets_guid")->first()?->value;
        $colorGuid = $this->options::where('code', '=', "ms_product_color_guid")->first()?->value;

        foreach ($rows['rows'] as $row) {
            $entity = Product::firstOrNew(['id' => $row['id']]);

            if ($entity->id === null) {
                $entity->id = $row['id'];
                $entity->is_active = 0;
            }

            $quantity = 0;
            if (isset($row["minimumBalance"]))
                $quantity = $row["minimumBalance"];
            $entity->name = $row['name'];
            $entity->category_id = \Arr::exists($row, 'productFolder') && isset($row["productFolder"]["id"]) ? $row["productFolder"]["id"] : null;
            $entity->weight_kg = $row["weight"];
            $entity->count_pallets = 0;
            $entity->min_balance_mc = $quantity;
            if (isset($row["attributes"])) {
                foreach ($row["attributes"] as $attr) {
                    if ($attr["id"] == $countPalletsGuid) {
                        $entity->count_pallets = $attr["value"];
                        break;
                    }

                    if ($attr["id"] == $colorGuid) {
                        $entity->color =  $this->getGuidFromUrl($attr["value"]["meta"]["href"]);
                        break;
                    }
                }
            }

            if (isset($row["salePrices"][0])) {
                $entity->price = $row["salePrices"][0]["value"] / 100;
            } else {
                $entity->price = 0;
            }
            $entity->save();
        }
    }

    /**
     * @return void
     */
    public function importResidual(): void
    {
        $urlResidual = 'https://api.moysklad.ru/api/remap/1.2/report/stock/bystore/current';

        $residuals = $this->service->actionGetRowsFromJson($urlResidual, false);

        foreach ($residuals as $residual) {

            $residual_material = 'не указано'; 
            $tech_chart_product = TechChartProduct::where('product_id', '=', $residual['assortmentId'])->first();

            if ($tech_chart_product) {
                $tech_chart = TechChart::with('materials')->find($tech_chart_product->tech_chart_id);

                if ($tech_chart) {
                    $tech_chart_materials = $tech_chart->materials;

                    $residual_material = 'да';

                    foreach ($tech_chart_materials as $material) {
                        $product = Product::where('id', '=', $material->product_id)->first();
                        dump($product);
                        // if ($product->residual < $material->quantity) {
                        //     $residual_material = 'нет';
                        // }
                    }
                }
            }

            Product::query()->where('id', $residual['assortmentId'])->update(
                ['residual' => $residual['stock'], 'materials' => $residual_material]
            );
        }
    }

    public function getGuidFromUrl($url)
    {
        $arUrl = explode("/", $url);
        return $arUrl[count($arUrl) - 1];
    }
}
