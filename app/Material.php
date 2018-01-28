<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Product;
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

    public function sumQuantity(Material $mat,Product $pro)
    {
        return DB::table('production_costs')->where('material_id',$mat->id)->where('product_id',$pro->id)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('quantity');
    }
    public function sumRate(Material $mat,Product $pro)
    {
        return DB::table('production_costs')->where('material_id',$mat->id)->where('product_id',$pro->id)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('rate');
    }

}
