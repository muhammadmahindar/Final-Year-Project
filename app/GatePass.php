<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    public function materials()
    {
        return $this->belongsToMany('App\Material', 'gate_passes_material', 'gate_id', 'material_id')->withPivot('quantity')->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'gate_passes_product', 'gate_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }
}
