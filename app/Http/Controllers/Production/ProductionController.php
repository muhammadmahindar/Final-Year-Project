<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Jobs\PendingProductionNotifier;
use App\Production;
use App\Material;
use App\Unit;
use App\Product;
use Auth;
use App\ProductionCost;
use App\User;
use App\SemiFixed;
use App\FactorOverhead;
class ProductionController extends Controller
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
        if (Auth::user()->can('Read-Production')) 
            {
       $production=Production::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $setModal=0;
       $productionData=0;
       $productData=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       return view('Production.index',compact('production','setModal','productionData','productData','unitData')); }
       else{
        abort(500);
       }
    }
    public function pending()
    {
        if (Auth::user()->can('Read-Production')) 
            {
                foreach (Auth::user()->unReadNotifications as $value) {
                $value->markAsRead();
             }
       $production=Production::where([['delete_status', '=', '1'],['status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $setModal=0;
       $productionData=0;
       $productData=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       return view('Production.index',compact('production','setModal','productionData','productData','unitData')); }
       else{
        abort(500);
       }
    }
    public function approved()
    {
        if (Auth::user()->can('Read-Production')) 
            {
                foreach (Auth::user()->unReadNotifications as $value) {
                $value->markAsRead();
             }
       $production=Production::where([['delete_status', '=', '1'],['status', '=', '3'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $setModal=0;
       $productionData=0;
       $productData=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       return view('Production.index',compact('production','setModal','productionData','productData','unitData')); }
       else{
        abort(500);
       }
    }
        public function completed()
    {
        if (Auth::user()->can('Read-Production')) 
            {
       $production=Production::where([['delete_status', '=', '1'],['status', '=', '4'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $setModal=0;
       $productionData=0;
       $productData=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       return view('Production.index',compact('production','setModal','productionData','productData','unitData')); }
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
            $productionData = new Production();
            $this->SaveProduction($request,$productionData);
            $sync_data = [];
            for($i = 0; $i < $formulaSize;$i++)
            {
            $sync_data[$request->FormulaList[$i]] = ['quantity' => $request->QuantityList[$i]];
            }
            if($productionData->save())
            {
            
            Session::flash('notice','Production was successfully created');
           
            $productionData->products()->sync($sync_data);
            $this->dispatch(new PendingProductionNotifier($productionData));
            return redirect('/Production');
             }
            else
            {
            Session::flash('alert','Production was not successfully created');
            return redirect('/Production');
            } //

        }   //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productionData=Production::findOrFail($id);
        foreach (Auth::user()->unReadNotifications as $value) {
            if($value->data['id']==$productionData->id && $value->data['status']==4){
                $value->markAsRead();
            }
        }
        if($productionData->status==4)
        {
            if($productionData->branch_id==Auth::user()->branch_id)
                {
       return view('Production.CompletedProduction.Show',compact('productionData'));
   }
   else
   {
    abort(500);
    }
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
        if (Auth::user()->can('Edit-Production')) 
            {
       $productionData=Production::findOrFail($id);
       $setModal=1;
       $production=Production::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       $productData=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
       return view('Production.index',compact('production','product','setModal','productionData','unitData','productData'));
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
       $productionData=Production::findOrFail($id);
        $this->validateEditInput($request,$productionData);
        $this->SaveEditProduction($request,$productionData);
        $sync_data = [];
            for($i = 0; $i < $formulaSize;$i++)
            {
            $sync_data[$request->FormulaList[$i]] = ['quantity' => $request->QuantityList[$i]];
            }
            if($productionData->save())
            {
            
            Session::flash('notice','Production was successfully Edited');
           
            $productionData->products()->sync($sync_data);
            return redirect('/Production');
             }
            else
            {
            Session::flash('alert','Production was not successfully Edited');
            return redirect('/Production');
            }        //
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
        if (Auth::user()->can('Delete-Production')) 
            {
       $productionData=Production::findOrFail($id);
       $productionData->delete_status=0;
        if($productionData->save())
        {
            Session::flash('notice','Production was successfully Deleted');
            return redirect('/Production');
        }
        else
        {
            Session::flash('alert','Production was not successfully Deleted');
            return redirect('/Production');
        } 
    }
    else
    {
        abort(500);
    }
    }
    protected function validateEditInput(Request $request,$productionData)
    {
        $this->validate($request, [
            'mat_code' => 'required|unique:productions,production_code,'.$productionData->id,
            'name' => 'required|unique:productions,name,'.$productionData->id,
            'user_code'=>  'required',
            'department_code'=>'required',
            'branch_code'=>'required',
            'company_code'=>'required',
        ]);
    }
      protected function SaveEditProduction(Request $request,$productionData)
    {
        $productionData->name=$request->name;
        $productionData->production_code=$request->mat_code;
        if ($productionData->status==4) {
            $teac=ProductionCost::where('production_id',$productionData->id)->get();
            foreach ($teac as $keyue) {
              $keyue->delete();  
            }
            foreach ($productionData->semiFixed as $delsemi) {
               $productionData->semiFixed()->detach($delsemi->id);
            }
            foreach ($productionData->factoryoverhead as $delfact) {
               $productionData->factoryoverhead()->detach($delfact->id);
            }
            
        }
        $productionData->status=$request->statusproduct;
        $productionData->delete_status=1;
        $productionData->description=$request->Description;
        $productionData->user_id=$request->user_code;
        $productionData->company_id=$request->company_code;
        $productionData->branch_id=$request->branch_code;
        $productionData->department_id=$request->department_code;
        $productionData->toArray();
    }
     protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'mat_code'=>'required|unique:productions,production_code',
            'name' => 'required|unique:productions,name',
            'user_code'=>  'required',
            'department_code'=>'required',
            'branch_code'=>'required',
            'company_code'=>'required',
        ]);
    }
     protected function SaveProduction(Request $request,$productionData)
    {
        $productionData->name=$request->name;
        $productionData->production_code=$request->mat_code;
        $productionData->status=1;
        $productionData->delete_status=1;
        $productionData->description=$request->Description;
        $productionData->user_id=$request->user_code;
        $productionData->company_id=$request->company_code;
        $productionData->branch_id=$request->branch_code;
        $productionData->department_id=$request->department_code;
        $productionData->toArray();
    }
}
