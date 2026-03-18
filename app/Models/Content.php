<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    protected $fillable = [
        'type',
        'title',
        'body',
        'image',
        'link',
    ];
}
