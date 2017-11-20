<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    
   public function branches()
    {
        return $this->belongsToMany('App\Branch')->withTimestamps();
    }
}
