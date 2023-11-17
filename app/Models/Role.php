<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable=['name'];
    protected $table = 'role';
    protected $guarded = false;

    public const IS_USER=3;
    public const IS_ADMIN=1;
    public const IS_MANAGER=2;
}
