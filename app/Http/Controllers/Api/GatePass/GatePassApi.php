<?php

namespace App\Http\Controllers\Api\GatePass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\GatePass;
use App\Product;
use App\Material;
use Auth;

class GatePassApi extends Controller
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
        if (Auth::user()->can('Read-GatePass')) 
            {
                $gatepass=GatePass::all();
                return response()->json($gatepass);
            } 
       else
       {
        return response()->json([
            'data' => 'Permission not found'
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
        $product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
                 $material=Material::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
                   return response()->json($arrayName = array('product' => $product,'material'=>$material ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $materialSize=sizeof($request->materialList);
         $productSize=sizeof($request->productList);
        if($request->materialList!=NULL){
            if (count(array_unique($request->materialList))<count($request->materialList)) {
                return response()->json([
            'data' => 'Vaildation Failed not found'
        ], 400);
            }
        }
        elseif ($request->productList!=NULL) {
            if (count(array_unique($request->productList))<count($request->productList)) {
                return response()->json([
            'data' => 'Vaildation Failed not found'
        ], 400);
            }
        }
            $this->validateInput($request);
            $gatePassData=new GatePass();
            $this->SaveGatePass($request,$gatePassData);
            $sync_data = [];
            for($i = 0; $i < $materialSize;$i++)
            {
            $sync_data[$request->materialList[$i]] = ['quantity' => $request->QuantityList[$i]];
            }
            $sync_data1 = [];
            for($i = 0; $i < $productSize;$i++)
            {
            $sync_data1[$request->productList[$i]] = ['quantity' => $request->QuantityList1[$i]];
            }
            if ($gatePassData->save()) {
                Session::flash('notice','GatePass was successfully created');
                $gatePassData->materials()->sync($sync_data);
                $gatePassData->products()->sync($sync_data1);
                return response()->json([
            'data' => 'Saved'
        ], 201);
            }
            else{
                Session::flash('alert','GatePass was not successfully created');
                return response()->json([
            'data' => 'Cant Save'
        ], 500);
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

     protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'person_name'=>'required',
            'contact_phone' => 'required|numeric',
            'destination' => 'required',
        ]);
    }
     protected function SaveGatePass(Request $request,$gatePassData)
    {
        $gatePassData->person_name=$request->person_name;
        $gatePassData->contact_phone=$request->contact_phone;
        $gatePassData->destination=$request->destination;
        $gatePassData->remarks=$request->remarks;
        $gatePassData->toArray();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gatePassData=GatePass::findOrFail($id);
        $gatePassData->delete();
        return response()->json([
            'data' => 'OK'
        ], 200);
    }
}
