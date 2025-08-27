<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'price',
        'price_sale',
        'stock',
        'category_id',
        'description',
        'weight',
        'length',
        'width',
        'height',
        'video',
    ];

    protected $casts = [
        'price' => 'float',
        'price_sale' => 'float',
        'stock' => 'integer',
        'weight' => 'float',
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
    ];
}
