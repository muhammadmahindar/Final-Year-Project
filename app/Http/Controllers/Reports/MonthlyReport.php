<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\DailyProduct;
use Auth;
use Carbon\Carbon;
use DB;
class MonthlyReport extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function ProductSelect()
    {
    	$product=Product::all();
    	return view('Reports.selection',compact('product'));
    }
    public function ShowForm()
    {
        $product=Product::all();
        return view('Reports.ProductMonthly',compact('product'));
    }
    public function ShowReport(Request $request)
    {
        $productname=Product::find($request->productID);
        $myData= DB::table('daily_production')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()) )->orderBy('created_at','asc')->get();
    return view('Reports.MonthlyGraph',compact('myData','productname'));
    }


    public function ShowMonthly (Request $request)
    {
        //Total quantity produced
        $quantityData=DB::table('product_production')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('quantity');
        //Total Rate
        $totalrate=DB::table('production_costs')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('rate'); 
        //Total Cost
        $costData=DB::table('production_costs')->where('product_id',$request->productID)->whereBetween('created_at', array(Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()))->sum('cost');            
        //Semi Fixed Total

        //factory overhead
    }
    
}

