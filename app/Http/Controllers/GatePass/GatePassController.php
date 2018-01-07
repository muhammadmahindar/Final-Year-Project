<?php

namespace App\Http\Controllers\GatePass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GatePass;
use Auth;
use App\Material;
use App\Product;
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
        $gatepass=GatePass::all();
       return view('GatePass.index',compact('gatepass'));
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
        return view('GatePass.create');
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
        $gatePassData=new GatePass();
        $this->SaveGatePass($request,$gatePassData);
        $gatePassData->save();
        return redirect('/GatePass');
        
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
        $gatePassData=GatePass::findOrFail($id);
        $gatePassData->delete();
        return redirect('/GatePass');
    }
    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'person_name'=>'required',
            'contact_phone' => 'required|numeric',
            'destination' => 'required'
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
