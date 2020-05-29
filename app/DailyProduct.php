<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyProduct extends Model
{
    protected $table = 'daily_production';

    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }
}
