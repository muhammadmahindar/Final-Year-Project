<?php

namespace App\Http\Controllers\Api\Production;

use App\Http\Controllers\Controller;
use App\Jobs\PendingProductionNotifier;
use App\Material;
use App\Product;
use App\Production;
use App\ProductionCost;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductionControllerApi extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Read-Production')) {
            $production = Production::where([
                ['delete_status', '=', '1'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();

            return  response()->json([
                'productions' => $production,
            ]);

        // $setModal=0;
            // $productionData=0;
            // $productData=Product::where([
            //     ['delete_status', '=', '1'],
            //     ['company_id', '=', Auth::user()->company_id],
            //     ['branch_id', '=', Auth::user()->branch_id]
            // ])->get();

            // return response()->json([
            //     'production' => $production,
            //     // 'products' => $production
            //     // 'productData'=>$productData
            // ]);
        } else {
            return response()->json([
                'data' => 'Permission not found',
            ], 403);
        }
    }

    public function notifications()
    {
        $pending;
        $approved;
        $completed;

        // Getting Notifications
        if (Auth::user()->can('Read-Production')) {
            foreach (Auth::user()->unReadNotifications as $value) {
                $value->markAsRead();
            }

            //
            $pending = Production::where([
                ['delete_status', '=', '1'],
                ['status', '=', '1'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();

            $approved = Production::where([
                ['delete_status', '=', '1'],
                ['status', '=', '3'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();

            $completed = Production::where([
                ['delete_status', '=', '1'],
                ['status', '=', '4'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();
        }

        return response()->json([
            'pending'   => $pending,
            'approved'  => $approved,
            'completed' => $completed,
        ]);
    }

    public function pending()
    {
        if (Auth::user()->can('Read-Production')) {
            foreach (Auth::user()->unReadNotifications as $value) {
                $value->markAsRead();
            }
            $production = Production::where([
                ['delete_status', '=', '1'],
                ['status', '=', '1'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();
            $setModal = 0;
            $productionData = 0;
            $productData = Product::where([
                ['delete_status', '=', '1'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();

            return response()->json(
                $arrayName = [
                    'production' => $production, 'productData'=>$productData, ]
            );
        } else {
            return response()->json([
                'data' => 'Permission not found',
            ], 403);
        }
    }

    public function approved()
    {
        if (Auth::user()->can('Read-Production')) {
            foreach (Auth::user()->unReadNotifications as $value) {
                $value->markAsRead();
            }

            $production = Production::where([
                ['delete_status', '=', '1'],
                ['status', '=', '3'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();
            $setModal = 0;
            $productionData = 0;
            $productData = Product::where([
                ['delete_status', '=', '1'],
                ['company_id', '=', Auth::user()->company_id],
                ['branch_id', '=', Auth::user()->branch_id],
            ])->get();

            return response()->json(
                $arrayName = ['production' => $production, 'productData'=>$productData]
            );
        } else {
            return response()->json([
                'data' => 'Permission not found',
            ], 403);
        }
    }

    public function completed()
    {
        if (Auth::user()->can('Read-Production')) {
            $production = Production::where([['delete_status', '=', '1'], ['status', '=', '4'], ['company_id', '=', Auth::user()->company_id], ['branch_id', '=', Auth::user()->branch_id]])->get();
            $setModal = 0;
            $productionData = 0;
            $productData = Product::where(
                [
                    ['delete_status', '=', '1'],
                    ['company_id', '=', Auth::user()->company_id],
                    ['branch_id', '=', Auth::user()->branch_id], ]
            )->get();

            return response()->json(
                $arrayName = [
                    'production' => $production,
                    'productData'=> $productData, ]
            );
        } else {
            return response()->json([
                'data' => 'Permission not found',
            ], 403);
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formulaSize = count($request->FormulaList);
        if (count(array_unique($request->FormulaList)) < count($request->FormulaList)) {
            return response()->json([
                'data' => 'Vaildation Failed not found',
            ], 400);
        } else {
            //doesnt have duplicate material
            $this->validateInput($request);
            $productionData = new Production();
            $this->SaveProduction($request, $productionData);
            $sync_data = [];
            for ($i = 0; $i < $formulaSize; $i++) {
                $sync_data[$request->FormulaList[$i]] = ['quantity' => $request->QuantityList[$i]];
            }

            if ($productionData->save()) {
                Session::flash('notice', 'Production was successfully created');

                $productionData->products()->sync($sync_data);
                $this->dispatch(new PendingProductionNotifier($productionData));

                return response()->json([
                    'data' => 'Saved',
                ], 201);
            } else {
                Session::flash('alert', 'Production was not successfully created');

                return response()->json([
                    'data' => 'Cant Save',
                ], 500);
            } //
        }
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
        $production = Production::findOrFail($id);
        // foreach (Auth::user()->unReadNotifications as $value) {
        //     if($value->data['id']==$production->id && $value->data['status']==4){
        //         $value->markAsRead();
        //     }
        // }

        return response()->json([

            'productions' => $production,
            'products'    => $production->products,

        ]);
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
        //
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

    protected function validateEditInput(Request $request, $productionData)
    {
        $this->validate($request, [
            'mat_code'       => 'required|unique:productions,production_code,'.$productionData->id,
            'name'           => 'required|unique:productions,name,'.$productionData->id,
            'user_code'      => 'required',
            'department_code'=> 'required',
            'branch_code'    => 'required',
            'company_code'   => 'required',
        ]);
    }

    protected function SaveEditProduction(Request $request, $productionData)
    {
        $productionData->name = $request->name;
        $productionData->production_code = $request->mat_code;
        if ($productionData->status == 4) {
            $teac = ProductionCost::where('production_id', $productionData->id)->get();
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
        $productionData->status = $request->statusproduct;
        $productionData->delete_status = 1;
        $productionData->description = $request->Description;
        $productionData->user_id = $request->user_code;
        $productionData->company_id = $request->company_code;
        $productionData->branch_id = $request->branch_code;
        $productionData->department_id = $request->department_code;
        $productionData->toArray();
    }

    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'mat_code'       => 'required|unique:productions,production_code',
            'name'           => 'required|unique:productions,name',
            'user_code'      => 'required',
            'department_code'=> 'required',
            'branch_code'    => 'required',
            'company_code'   => 'required',
        ]);
    }

    protected function SaveProduction(Request $request, $productionData)
    {
        $productionData->name = $request->name;
        $productionData->production_code = $request->mat_code;
        $productionData->status = 1;
        $productionData->delete_status = 1;
        $productionData->description = $request->Description;
        $productionData->user_id = $request->user_code;
        $productionData->company_id = $request->company_code;
        $productionData->branch_id = $request->branch_code;
        $productionData->department_id = $request->department_code;
        $productionData->toArray();
    }
}
