<?php

namespace App\Http\Controllers\GatePass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\GatePass;
use Auth;
use App\Material;
use App\Product;
use DB;
class GatePassController extends Controller
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
    
        if (Auth::user()->can('Read-GatePass')) 
            {
        // $gatepass=DB::table('gate_passes')
        // ->join('gate_passes_item', function ($join) {
        //     $join->on('gate_passes.id', '=', 'gate_passes_item.gate_id')
        //          ->where('gate_passes_item.gate_id', '>', 0);
        // })
        // ->get();
                $gatepass=GatePass::all();
                 
       return view('GatePass.index',compact('gatepass','product','material'));
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
        if (Auth::user()->can('Create-GatePass')) 
            {
        $product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
                 $material=Material::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();

        return view('GatePass.create',compact('material','product'));
    }
    else
       {
        abort(500);
       }
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
                return redirect()->back()->withInput()->withErrors(['DuplicateMaterial' => 'Duplicate Material Selected']);
            }
        }
        elseif ($request->productList!=NULL) {
            if (count(array_unique($request->productList))<count($request->productList)) {
                return redirect()->back()->withInput()->withErrors(['DuplicateProduct' => 'Duplicate Product Selected']);
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
                return redirect('/GatePass');
            }
            else{
                Session::flash('alert','GatePass was not successfully created');
                return redirect('/GatePass');
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
        if (Auth::user()->can('Show-GatePass')) 
            {
        $gatePassData=GatePass::findOrFail($id);
        return view('GatePass.show',compact('gatePassData'));
    }
    else
       {
        abort(500);
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
        if (Auth::user()->can('Edit-GatePass')) 
            {
        $gatePassData=GatePass::findOrFail($id);
        $product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
                 $material=Material::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
                 return view('GatePass.edit',compact('material','product','gatePassData'));
             }
             else
       {
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
        $materialSize=sizeof($request->materialList);
         $productSize=sizeof($request->productList);
        if($request->materialList!=NULL){
            if (count(array_unique($request->materialList))<count($request->materialList)) {
                return redirect()->back()->withInput()->withErrors(['DuplicateMaterial' => 'Duplicate Material Selected']);
            }
        }
        elseif ($request->productList!=NULL) {
            if (count(array_unique($request->productList))<count($request->productList)) {
                return redirect()->back()->withInput()->withErrors(['DuplicateProduct' => 'Duplicate Product Selected']);
            }
        }
            $gatePassData=GatePass::findOrFail($id);
            $this->validateInput($request);
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
                Session::flash('notice','GatePass was successfully Edited');
                $gatePassData->materials()->sync($sync_data);
                $gatePassData->products()->sync($sync_data1);
                return redirect('/GatePass');
            }
            else{
                Session::flash('alert','GatePass was not successfully Edited');
                return redirect('/GatePass');
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
        if (Auth::user()->can('Delete-GatePass')) 
            {
        $gatePassData=GatePass::findOrFail($id);
        $gatePassData->delete();
        return redirect('/GatePass');
    }
    else
       {
        abort(500);
       }
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
}
