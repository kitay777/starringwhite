<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductContent extends Model
{
    protected $fillable = [
        'base_item_id',
        'description',
        'size',
    ];
}