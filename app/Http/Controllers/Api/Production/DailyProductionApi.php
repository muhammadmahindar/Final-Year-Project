<?php

namespace App\Http\Controllers\Api\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Auth;
use App\DailyProduct;
use Carbon\Carbon;  

class DailyProductionApi extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productData=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
        return response()->json($productData);
    }


    public function productselect(Request $request)
    {
        $data=DailyProduct::where([['product_id','=',$request->productID],['created_at','>=',Carbon::today()]])->get();
       if ($data->isEmpty()) {
        $productData=Product::find($request->productID);
           return response()->json($productData);
       }
       else{
        return response()->json([
            'data' => 'Resource not found'
        ], 403);
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dailyproduction= new DailyProduct();
        $this->ValidateInput($request);
        $this->SaveDaily($request,$dailyproduction);
        if($dailyproduction->save())
        {
            return response()->json([
            'data' => 'Object Saved'
        ], 201);
        }
        else{
            return response()->json([
            'data' => 'Not Saved'
        ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    protected function ValidateInput(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric',
            'produced' => 'required|numeric',
            'dispatches'=>  'numeric',
            'sale_return'=>'numeric',
            'received'=>'numeric',
            'branch_id'=>'numeric',
            'department_id'=>'numeric',
            'company_id'=>'numeric'
        ]);
    }
    protected function SaveDaily(Request $request,$dailyproduction)
    {
        $dailyproduction->product_id=$request->product_id;
        $dailyproduction->produced=$request->produced;
        $dailyproduction->dispatches=$request->dispatches;
        $dailyproduction->sale_return=$request->sale_return;
        $dailyproduction->received=$request->received;
        $dailyproduction->branch_id=1;
        $dailyproduction->department_id=1;
        $dailyproduction->company_id=1;
        $dailyproduction->toArray();
    }
}
