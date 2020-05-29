<?php

namespace App\Http\Controllers\Production;

use App\FactoryOverHead;
use App\Http\Controllers\Controller;
use App\Jobs\ProductionApprovedNotifier;
use App\Production;
use App\ProductionCost;
use App\SemiFixed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductionApproval extends Controller
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productionData = Production::findOrFail($id);
        if ($productionData->status == 3) {
            $semi = SemiFixed::where([['delete_status', '=', '1']])->get();
            $factory = FactoryOverHead::where([['delete_status', '=', '1']])->get();

            return view('Production.CompletedProduction.Completed', compact('productionData', 'semi', 'factory'));
        } else {
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productionData = Production::findOrFail($id);
        $productionData->status = $request->approval;
        if ($productionData->status == 4) {
            foreach ($productionData->products as $productsname) {
                $semiSize = count($request->{'semiId'.$productsname->id});
                $factorySize = count($request->{'factoryId'.$productsname->id});
                $sync_data = [];
                $sync_data1 = [];
                for ($i = 0; $i < $semiSize; $i++) {
                    $sync_data[$request->{'semiId'.$productsname->id}[$i]] = ['quantity' => $request->{'SemiQuantityList'.$productsname->id}[$i], 'product_id'=>$productsname->id];
                }
                for ($i = 0; $i < $factorySize; $i++) {
                    $sync_data1[$request->{'factoryId'.$productsname->id}[$i]] = ['quantity' => $request->{'FactoryQuantityList'.$productsname->id}[$i], 'product_id'=>$productsname->id];
                }
                $productionData->semiFixed()->attach($sync_data);
                $productionData->factoryoverhead()->attach($sync_data1);
            }
        }

        if ($productionData->save()) {
            if ($productionData->status == 4) {
                //products in production request
                foreach ($productionData->products as $value) {
                    //materials in that product
                    foreach ($value->materials as $key) {
                        $productionCost = new ProductionCost();
                        $productionCost->product_id = $value->id;
                        $productionCost->production_id = $productionData->id; //production id
                            $productionCost->material_id = $key->id; //material id
                            $productionCost->rate = 100; //to be taken from inventory
                            $productionCost->quantity = $key->pivot->quantity * $value->pivot->quantity; /*material quantity*production quantity*/
                        $productionCost->cost = $productionCost->rate * $productionCost->quantity;
                        $productionCost->save();
                    }
                }

                Session::flash('notice', 'Production was successfully Marked Completed');
            } elseif ($productionData->status == 3) {
                Session::flash('notice', 'Production was successfully Approved');
            } else {
                Session::flash('notice', 'Production was successfully Disapproved');
            }

            $this->dispatch(new ProductionApprovedNotifier($productionData));

            return redirect('/Production');
        } else {
            Session::flash('alert', 'Production was not successfully Approved');

            return redirect('/Production');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
