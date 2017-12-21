<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Jobs\ProductionApprovedNotifier;
use Auth;
use App\Production;
use App\ProductionCost;
use App\SemiFixed;
Use App\FactoryOverHead;
class ProductionApproval extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        $semi=SemiFixed::all();
        $factory=FactoryOverHead::all();
        return view('Production.CompletedProduction.Completed',compact('productionData','semi','factory'));
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
        $productionData=Production::findOrFail($id);
        $semiSize=sizeof($request->semiId);
        $factorySize=sizeof($request->factoryId);
        $sync_data = [];
        $sync_data1= [];
            for($i = 0; $i < $semiSize;$i++)
            {
            $sync_data[$request->semiId[$i]] = ['quantity' => $request->SemiQuantityList[$i]];
            }
             for($i = 0; $i < $factorySize;$i++)
            {
            $sync_data1[$request->factoryId[$i]] = ['quantity' => $request->FactoryQuantityList[$i]];
            }
        $productionData->semiFixed()->sync($sync_data);
        $productionData->factoryoverhead()->sync($sync_data1);
        $productionData->status=$request->approval;
        if($productionData->save())
        {
                if($productionData->status==4)
                { 
                    //products in production request
                    foreach ($productionData->products as $value)
                    {
                    //materials in that product
                        foreach ($value->materials as $key) 
                        {
                            $productionCost=new ProductionCost();
                            $productionCost->product_id=$value->id;
                            $productionCost->production_id=$productionData->id; //production id
                            $productionCost->material_id=$key->id; //material id
                            $productionCost->rate=100; //to be taken from inventory
                            $productionCost->quantity=$key->pivot->quantity*$value->pivot->quantity; /*material quantity*production quantity*/
                            $productionCost->cost=$productionCost->rate*$productionCost->quantity;
                            $productionCost->save(); 
                       }
                    }

                    Session::flash('notice','Production was successfully Marked Completed');
                } 
                else
                {
                    Session::flash('notice','Production was successfully Approved');
                }

            $this->dispatch(new ProductionApprovedNotifier($productionData));
            return redirect('/Production');
        }
        else
        {
            Session::flash('alert','Production was not successfully Approved');
            return redirect('/Production');
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
        //
    }
}
