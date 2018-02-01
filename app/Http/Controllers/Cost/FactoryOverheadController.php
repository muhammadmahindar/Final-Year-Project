<?php

namespace App\Http\Controllers\Cost;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FactoryOverhead as Factory;
use Auth;
class FactoryOverheadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
     {
           if (Auth::user()->can('Read-FactoryOverhead')) 
            {
      
        $factorydata=Factory::where([['delete_status', '=', '1'],])->get();
         $setModal=0;
        $companyData=0;
        return view('CostTypes.FactoryOverhead.index',compact('factorydata','setModal','companyData'));
               }
       else{
        abort(500);
       } //


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
        $factoryData = new Factory();
        $this->SaveFactory($request,$factoryData);
        if($factoryData->save())
        {
            Session::flash('notice','FactoryOverhead was successfully created');
            return redirect('/FactoryOverhead');
        }
        else
        {
            Session::flash('alert','FactoryOverhead was not successfully created');
            return redirect('/FactoryOverhead');
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
         if (Auth::user()->can('Edit-FactoryOverhead')) 
            {
       $factorydata=Factory::all();
       $companyData=Factory::findOrFail($id);
       $setModal=1;
      return view('CostTypes.FactoryOverhead.index',compact('factorydata','setModal','companyData'));
    
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
        $factoryData=Factory::findOrFail($id);
       $this->validateEditInput($request,$factoryData);
        $this->SaveFactory($request,$factoryData);
        if($factoryData->save())
        {
            Session::flash('notice','FactoryOverhead was successfully Edited');
            return redirect('/FactoryOverhead');
        }
        else
        {
            Session::flash('alert','FactoryOverhead was not successfully Edited');
            return redirect('/FactoryOverhead');
        }//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                     if (Auth::user()->can('Delete-FactoryOverhead')) 
            {
        $FactoryOverheadData=Factory::findOrFail($id);
        $FactoryOverheadData->delete_status=0;
         if( $FactoryOverheadData->save())
        {
            Session::flash('notice','FactoryOverhead was successfully Deleted');
            return redirect('/FactoryOverhead');
        }
        else
        {
            Session::flash('alert','FactoryOverhead was not successfully Deleted');
            return redirect('/FactoryOverhead');
        }
    }
    else{
        abort(500);
    }
//
    }
     protected function validateEditInput(Request $request,$factoryData)
    {
        $this->validate($request, [
            'name' => 'required|unique:factory_over_heads,name,'.$factoryData->name
        ]);
    }
        protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:factory_over_heads,name'
        ]);
    }
    protected function SaveFactory(Request $request,$factoryData)
    {
        $factoryData->name=$request->name;
        $factoryData->toArray();
    }
    
}
