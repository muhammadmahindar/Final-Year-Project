<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Product;
use App\DailyProduct;
use Auth;
use Carbon\Carbon;
use App\SemiFixed;
use App\FactoryOverHead;
use DB;
class MonthlyReport extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function ProductSelect()
    {
        if (Auth::user()->can('Daily-ProductionReport')) 
            {
    	$product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
    	return view('Reports.selection',compact('product'));
    } else
       {
        abort(500);
       }
    }

    
    public function ShowForm()
    {
        if (Auth::user()->can('Monthly-ProductionReport')) 
            {
        $product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
        return view('Reports.ProductMonthly',compact('product'));
    }
     else
       {
        abort(500);
       }
    }
    public function ShowDaily(Request $request)
    {
        $productname=Product::find($request->productID);
        $myData= DB::table('daily_production')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()) )->orderBy('created_at','asc')->get();
    return view('Reports.DailyGraph',compact('myData','productname'));
    }


    public function ShowMonthly (Request $request)
    {
        $productionData=Product::find($request->productID);
        //Total quantity produced
        $quantityData=DB::table('product_production')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('quantity');
        //Total Rate
        $totalrate=DB::table('production_costs')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('rate'); 
        //Total Cost
        $costData=DB::table('production_costs')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('cost');  

        //Semi All
        $semiAll=SemiFixed::all();
        $semireturn=[];
        foreach ($semiAll as $key => $value) {  
                   $semireturn[$key]=DB::table('production_semi_fixed')->where('product_id',$request->productID)->where('semi_id',$value->id)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('quantity');
                  }  
        //Semi Fixed Total
        $semiData=DB::table('production_semi_fixed')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('quantity');
         $factoryAll=FactoryOverHead::all();
         $factoryreturn=[];
        foreach ($factoryAll as $key => $value) {  
                   $factoryreturn[$key]=DB::table('factory_ovear_head_production')->where('product_id',$request->productID)->where('factory_id',$value->id)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('quantity');
                  }  

        //factory overhead total
        $factoryData=DB::table('factory_ovear_head_production')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('quantity');
        return view('Reports.MonthlyGraphProduct',compact('quantityData','totalrate','semiAll','semireturn','factoryreturn','factoryAll','costData','semiData','factoryData','productionData'));
    }
    
}

