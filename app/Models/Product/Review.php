<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'product_id',
        'user_id',
        'star_seller',
        'star_courier',
        'variations',
        'description',
        'attachments',
        'show_username',
    ];

    protected $casts = [
        'star_seller' => 'integer',
        'attachments' => 'array',
        'show_username' => 'boolean',
    ];
}
