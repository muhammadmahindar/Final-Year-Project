<?php

namespace App\Http\Controllers\Cost;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SemiFixed;
use Auth;
class SemiFixedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
             if (Auth::user()->can('Read-SemiFixed')) 
            {
      
        $semifixedata=SemiFixed::all();
         $setModal=0;
        $companyData=0;
        return view('CostTypes.SemiFixed.index',compact('semifixedata','setModal','companyData'));
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
        $semiData = new SemiFixed();
        $this->SaveSemi($request,$semiData);
        if($semiData->save())
        {
            Session::flash('notice','SemiFixed was successfully created');
            return redirect('/SemiFixed');
        }
        else
        {
            Session::flash('alert','SemiFixed was not successfully created');
            return redirect('/SemiFixed');
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
    if (Auth::user()->can('Edit-SemiFixed')) 
            {
        $semifixedata=SemiFixed::all();
       $companyData=SemiFixed::findOrFail($id);
       $setModal=1;
       return view('CostTypes.SemiFixed.index',compact('semifixedata','setModal','companyData'));
       }
       else{
        abort(500);
       } //
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
    $semiData=SemiFixed::findOrFail($id);
       $this->validateEditInput($request,$semiData);
        $this->SaveSemi($request,$semiData);
        if($semiData->save())
        {
            Session::flash('notice','SemiFixed was successfully Edited');
            return redirect('/SemiFixed');
        }
        else
        {
            Session::flash('alert','SemiFixed was not successfully Edited');
            return redirect('/SemiFixed');
        }   //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
             if (Auth::user()->can('Delete-SemiFixed')) 
            {
        $SemiFixedData=SemiFixed::findOrFail($id);
         if( $SemiFixedData->delete())
        {
            Session::flash('notice','SemiFixed was successfully Deleted');
            return redirect('/SemiFixed');
        }
        else
        {
            Session::flash('alert','SemiFixed was not successfully Deleted');
            return redirect('/SemiFixed');
        }
    }
    else{
        abort(500);
    }
   
    }
     protected function validateEditInput(Request $request,$semiData)
    {
        $this->validate($request, [
            'name' => 'required|unique:semi_fixeds,name,'.$semiData->name
        ]);
    }
        protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:semi_fixeds,name'
        ]);
    }
    protected function SaveSemi(Request $request,$semiData)
    {
        $semiData->name=$request->name;
        $semiData->toArray();
    }
}
