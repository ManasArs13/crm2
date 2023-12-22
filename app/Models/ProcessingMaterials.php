<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProcessingMaterials extends Pivot
{
    use HasFactory, HasUuids;

    protected $table = 'processing_materials';

    protected $fillable = ['id'];

    public function processing(): BelongsTo
    {
        return $this->belongsTo(Processing::class, 'processing_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}