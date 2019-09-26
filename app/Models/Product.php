<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \App\Traits\ProductTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'excerpt',
        'description',

        'sell_price',
        'active',
    ];

    protected $table = 'product';
}
