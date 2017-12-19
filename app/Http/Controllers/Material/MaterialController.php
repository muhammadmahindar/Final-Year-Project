<?php

namespace App\Http\Controllers\Material;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Branch;
use App\Company;
use App\Department;
use App\Material;
use App\Unit;
use Auth;
class MaterialController extends Controller
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
        if (Auth::user()->can('Read-Material')) 
            {

      $material=Material::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $unitData=Unit::orderBy('created_at','desc')->get();
        $setModal=0;
        $materialData=0;
        return view('Material.index',compact('material','setModal','materialData','unitData'));  
    }
    else
    {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
       $this->validateInput($request);
        $materialData = new Material();
        $this->SaveMaterial($request,$materialData);
        if($materialData->save())
        {
            Session::flash('notice','Material was successfully created');
            return redirect('/Material');
        }
        else
        {
            Session::flash('alert','Material was not successfully created');
            return redirect('/Material');
        } //
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
        if (Auth::user()->can('Edit-Material')) 
            {
       $materialData=Material::findOrFail($id);
       $setModal=1;
       $material=Material::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $unitData=Unit::orderBy('created_at','desc')->get();
       return view('Material.index',compact('material','setModal','materialData','unitData')); 
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
       $materialData=Material::findOrFail($id);
       $this->validateEditInput($request,$materialData);
        $this->SaveMaterial($request,$materialData);
        if($materialData->save())
        {
            Session::flash('notice','Branch was successfully Edited');
            return redirect('/Material');
        }
        else
        {
            Session::flash('alert','Branch was not successfully Edited');
            return redirect('/Material');
        } //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('Delete-Material')) 
            {
       $materialData=Material::findOrFail($id);
       $materialData->delete_status=0;
        if($materialData->save())
        {
            Session::flash('notice','Material was successfully Deleted');
            return redirect('/Material');
        }
        else
        {
            Session::flash('alert','Material was not successfully Deleted');
            return redirect('/Material');
        } }
        else
        {
            abort(500);
        }
    
    }
    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'mat_code'=>'required|unique:materials,material_code',
            'name' => 'required|unique:materials,name,NULL,id,branch_id,'.Auth::user()->branch_id,
            'unitID' => 'required',
            'user_code'=>  'required'
        ]);
    }
    protected function validateEditInput(Request $request,$materialData)
    {
        $this->validate($request, [
            'mat_code' => 'required|unique:materials,material_code,'.$materialData->id,
            'name' => 'required|unique:materials,name,'.$materialData->id.'NULL,id,branch_id,'.Auth::user()->branch_id,
            'unitID' => 'required',
            'user_code'=>  'required'
        ]);
    }
    protected function SaveMaterial(Request $request,$materialData)
    {
        $materialData->name=$request->name;
        $materialData->material_code=$request->mat_code;
        $materialData->delete_status=1;
        $materialData->description=$request->Description;
        $materialData->user_id=$request->user_code;
        $materialData->unit_id=$request->unitID;
        $materialData->branch_id=Auth::user()->branch_id;
        $materialData->company_id=Auth::user()->company_id;
        $materialData->department_id=Auth::user()->department_id;
        $materialData->toArray();
    }
}
