<?php

namespace App\Services\Entity;

use App\Contracts\EntityInterface;
use App\Models\TechChart;
use App\Models\TechChartMaterial;
use App\Services\Api\MoySkladService;

class TechChartService implements EntityInterface
{
    private MoySkladService $service;

    public function __construct(MoySkladService $service)
    {
        $this->service = $service;
    }

    public function import(array $rows)
    {

        foreach ($rows["rows"] as $row) {

            $entity = TechChart::firstOrNew(['id' => $row['id']]);

            if ($entity->id === null) {
                $entity->id = $row['id'];
            }

            if (isset($row["products"])) {
                $products = $this->service->actionGetRowsFromJson($row['products']['meta']['href']);
                $product = $this->service->actionGetRowsFromJson($products['0']['product']['meta']['href'], false);

                $entity->quantity = $products['0']['quantity'];
                $entity->product_id = $product['id'];

                $entity->archived = $row["archived"];

                $entity->name = $row["name"];

                if (isset($row["description"])) {
                    $entity->description = $row["description"];
                }

                if (isset($row["cost"])) {
                    $entity->cost = $row["cost"] / 100;
                }

                if (isset($row["pathName"])) {
                    $entity->group = $row["pathName"];
                }


                if (isset($row["materials"])) {

                    $materials = $this->service->actionGetRowsFromJson($row['materials']['meta']['href']);

                    foreach ($materials as $material) {
                        $entity_material = TechChartMaterial::firstOrNew(['id' => $material['id']]);

                        if ($entity_material->id === null) {
                            $entity_material->id = $material['id'];
                        }

                        $entity_material->tech_chart_id = $row['id'];
                        $entity_material->quantity = $material['quantity'];

                        $product = $this->service->actionGetRowsFromJson($material['product']['meta']['href'], false);
                        $entity_material->product_id = $product['id'];

                        $entity_material->save();
                    }
                }

                $entity->save();
            }
        }
    }
}
