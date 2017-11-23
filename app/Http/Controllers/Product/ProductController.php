<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\Material;
use Log;
use App\Unit;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $product=Product::where('delete_status',1)->get();
       $unitData=Unit::orderBy('created_at','desc')->get();
       $setModal=0;
       $productData=0;
       $materialData=Material::where('delete_status',1)->get();
       return view('Product.index',compact('product','setModal','productData','materialData','unitData'));
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
         $formulaSize=sizeof($request->FormulaList);
        if(count(array_unique($request->FormulaList))<count($request->FormulaList))
        {
            return redirect()->back()->withInput()->withErrors(['Duplicate' => 'Duplicate Material Name']);// Array has duplicates
        }
        else{
        //doesnt have duplicate material
            $this->validateInput($request);
            $productData = new Product();
            $this->SaveMaterial($request,$productData);
            $sync_data = [];
            for($i = 0; $i < $formulaSize;$i++)
            {
            $sync_data[$request->FormulaList[$i]] = ['quantity' => $request->QuantityList[$i]];
            Log::info('This is some useful information.');
            }
            if($productData->save())
            {
            
            Session::flash('notice','Product was successfully created');
           
            $productData->materials()->sync($sync_data);
            return redirect('/Product');
             }
            else
            {
            Session::flash('alert','Product was not successfully created');
            return redirect('/Product');
            } //

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
     $productData=Product::findOrFail($id);
       $productData->delete_status=0;
        if($productData->save())
        {
            Session::flash('notice','Product was successfully Deleted');
            return redirect('/Product');
        }
        else
        {
            Session::flash('alert','Product was not successfully Deleted');
            return redirect('/Product');
        } //   //
    }


    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'mat_code'=>'required|unique:products,product_code',
            'name' => 'required|unique:products,name',
            'unitID' => 'required',
            'user_code'=>  'required'
        ]);
    }
    protected function SaveMaterial(Request $request,$productData)
    {
        $productData->name=$request->name;
        $productData->product_code=$request->mat_code;
        $productData->delete_status=1;
        $productData->description=$request->Description;
        $productData->user_id=$request->user_code;
        $productData->unit_id=$request->unitID;
        $productData->toArray();
    }
}
