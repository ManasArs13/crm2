<?php

namespace App\Services\Entity;

use App\Contracts\EntityInterface;
use App\Models\Option;
use App\Models\ProductsCategory;
use App\Services\Api\MoySkladService;

class ProductsCategoryService implements EntityInterface
{

    public function import(array $rows)
    {
        foreach ($rows['rows'] as $row) {
            $entity = ProductsCategory::firstOrNew(['id' => $row['id']]);

            if ($entity->id === null) {
                $entity->id = $row['id'];
                $entity->is_active = 0;
            }

            $entity->name = $row['name'];
//            $group->description = \Arr::exists($row, 'description') ? $row['description'] : '';
            $entity->save();
        }
    }

    public function findActiveGroups(){
        $guids = ProductsCategory::where('is_active', 1)
            ->select("id")
            ->get();

        return $guids;
    }
}
