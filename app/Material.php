<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
  	public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }   //
}
