<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public function products () {
        return $this->hasMany('App\Models\Product');
    }

    public function utility () {
        return $this->belongsTo('App\Utility');
    }
}
