<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function user()
    {
        return $this->belongsTo('App\User');
    }
 	
 	 public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }
   public function materials()
    {
        return $this->belongsToMany('App\Material')->withPivot('quantity')->withTimestamps();
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }

}
