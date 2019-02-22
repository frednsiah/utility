<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function product_variations () {
        return $this->hasMany('App\Models\ProductVariation');
    }

    public function provider () {
        return $this->belongsTo('App\Provider');
    }
}
