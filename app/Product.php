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
    } //

}
