<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\Material;
use App\Unit;
use App\Company;
use App\Department;
use App\Branch;
use Auth;

class ProductController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Read-Product')) 
            {
                if(!Auth::user()->hasRole('SuperAdmin'))
                    {
       $product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $unitData=Unit::orderBy('created_at','desc')->get();
       $setModal=0;
       $productData=0;
       $CompanyData=Company::all();
       $materialData=Material::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       return view('Product.index',compact('CompanyData','product','setModal','productData','materialData','unitData'));
   }
   else{
        $product=Product::where([['delete_status', '=', '1'],])->get();
       $unitData=Unit::orderBy('created_at','desc')->get();
       $setModal=0;
       $productData=0;
       $CompanyData=Company::all();
       $materialData=Material::where([['delete_status', '=', '1'],])->get();
       return view('Product.index',compact('CompanyData','product','setModal','productData','materialData','unitData'));
   }
   }
   else{
    abort(500);
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

    public function approve(Request $request)
    {
            return $request;
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
            $this->SaveProduct($request,$productData);
            $sync_data = [];
            for($i = 0; $i < $formulaSize;$i++)
            {
            $sync_data[$request->FormulaList[$i]] = ['quantity' => $request->QuantityList[$i]];
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
        if (Auth::user()->can('Edit-Product')) 
            {
         $productData=Product::findOrFail($id);
       $setModal=1;
       $CompanyData=Company::all();
       $departmentData=Department::find($productData->department_id);
        $branchData=Branch::find($productData->branch_id);
       $product=Product::where([['delete_status', '=', '1'],['company_id', '=', $productData->company_id],['branch_id', '=', $productData->branch_id],])->get();
       $unitData=Unit::orderBy('created_at','desc')->get();
       $materialData=Material::where([['delete_status', '=', '1'],['company_id', '=', $productData->company_id],['branch_id', '=', $productData->branch_id],])->get();
       return view('Product.index',compact('CompanyData','product','setModal','productData','unitData','materialData','branchData','departmentData'));
       
   }
   else{
    abort(500);
   }
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
        $formulaSize=sizeof($request->FormulaList);
        if(count(array_unique($request->FormulaList))<count($request->FormulaList))
        {
            return redirect()->back()->withInput()->withErrors(['Duplicate' => 'Duplicate Material Name']);// Array has duplicates
        }
        else{
       $productData=Product::findOrFail($id);
        $this->validateEditInput($request,$productData);
        $this->SaveEditProduct($request,$productData);
        $sync_data = [];
            for($i = 0; $i < $formulaSize;$i++)
            {
            $sync_data[$request->FormulaList[$i]] = ['quantity' => $request->QuantityList[$i]];
            }
            if($productData->save())
            {
            
            Session::flash('notice','Product was successfully Edited');
           
            $productData->materials()->sync($sync_data);
            return redirect('/Product');
             }
            else
            {
            Session::flash('alert','Product was not successfully Edited');
            return redirect('/Product');
            } //
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('Delete-Product')) 
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
        }
        }
        else{
            abort(500);
        } //   //
    }


    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'mat_code'=>'required|unique:products,product_code',
            'name' => 'required|unique:products,name,NULL,id,branch_id,'.Auth::user()->branch_id,
            'unitID' => 'required',
            'user_code'=>  'required'
        ]);
    }
    protected function validateEditInput(Request $request,$productData)
    {
        $this->validate($request, [
            'mat_code' => 'required|unique:products,product_code,'.$productData->id,
            'name' => 'required|unique:products,name,'.$productData->id.'NULL,id,branch_id,'.Auth::user()->branch_id,
            'unitID' => 'required',
            'user_code'=>  'required'
        ]);
    }
    protected function SaveProduct(Request $request,$productData)
    {
        $productData->name=$request->name;
        $productData->product_code=$request->mat_code;
        $productData->delete_status=1;
        $productData->description=$request->Description;
        $productData->user_id=$request->user_code;
        $productData->unit_id=$request->unitID;
        $productData->branch_id=$request->branchList;
        $productData->company_id=$request->companyList;
        $productData->department_id=$request->departmentList;
        $productData->toArray();
    }
     protected function SaveEditProduct(Request $request,$productData)
    {
        $productData->name=$request->name;
        $productData->product_code=$request->mat_code;
        $productData->delete_status=1;
        $productData->description=$request->Description;
        $productData->unit_id=$request->unitID;
        $productData->user_id=$request->user_code;
        $productData->branch_id=$request->branchList;
        $productData->company_id=$request->companyList;
        $productData->department_id=$request->departmentList;
        $productData->toArray();
    }
}
