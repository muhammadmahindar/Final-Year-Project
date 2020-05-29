<?php

namespace App;

use Carbon\Carbon;
use DB;
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

    public function sumQuantity(self $mat, Product $pro)
    {
        return DB::table('production_costs')->where('material_id', $mat->id)->where('product_id', $pro->id)->whereBetween('created_at', [Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()])->sum('quantity');
    }

    public function sumRate(self $mat, Product $pro)
    {
        return DB::table('production_costs')->where('material_id', $mat->id)->where('product_id', $pro->id)->whereBetween('created_at', [Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()])->sum('rate');
    }
}
