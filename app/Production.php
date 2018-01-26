<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
   	public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function Department()
    {
        return $this->belongsTo('App\Department');
    }
     //

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity')->withTimestamps();
    }
    public function semiFixed()
    {
        return $this->belongsToMany('App\SemiFixed', 'production_semi_fixed', 'production_id', 'semi_id')->withPivot('quantity','product_id')->withTimestamps();
    }
    public function factoryoverhead()
    {
        return $this->belongsToMany('App\FactoryOverHead', 'factory_ovear_head_production', 'production_id', 'factory_id')->withPivot('quantity','product_id')->withTimestamps();
    }
}
