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
}
