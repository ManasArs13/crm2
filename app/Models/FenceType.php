<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FenceType extends Model
{
    protected $table = 'fence_types';
    protected $guarded = false;
    public $timestamps = true;
}
