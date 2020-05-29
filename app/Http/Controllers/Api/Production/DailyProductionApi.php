<?php

namespace App\Http\Controllers\Api\Production;

use App\DailyProduct;
use App\Http\Controllers\Controller;
use App\Product;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyProductionApi extends Controller
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
        $productData = Product::where([['delete_status', '=', '1'], ['company_id', '=', Auth::user()->company_id], ['branch_id', '=', Auth::user()->branch_id]])->get();

        return response()->json([
            'products' => $productData,
        ]);
    }

    public function productselect(Request $request)
    {
        $data = DailyProduct::where([['product_id', '=', $request->productID], ['created_at', '>=', Carbon::today()]])->get();
        if ($data->isEmpty()) {
            $productData = Product::find($request->productID);

            return response()->json($productData);
        } else {
            return response()->json([
                'data' => 'Resource not found',
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
        $products = Product::all();

        return response()->json([
            'products' => $products,
        ]);
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
        $dailyProductionJson = json_decode($request->getContent());
        // return $dailyProductionJson->{"product_id"};

        $dailyproduction = new DailyProduct();
        // $this->ValidateInput($request);
        $this->SaveDaily($dailyProductionJson, $dailyproduction);
        if ($dailyproduction->save()) {
            return response()->json([
                'status' => 'success',
                'msg'    => 'Resource has been created',
            ], 200);
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
        //
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

    protected function ValidateInput(Request $request)
    {
        $this->validate($request, [
            'product_id'   => 'required|numeric',
            'produced'     => 'required|numeric',
            'dispatches'   => 'numeric',
            'sale_return'  => 'numeric',
            'received'     => 'numeric',
            'branch_id'    => 'numeric',
            'department_id'=> 'numeric',
            'company_id'   => 'numeric',
        ]);
    }

    protected function SaveDaily($dailyProductionJson, $dailyproduction)
    {
        $dailyproduction->product_id = $dailyProductionJson->{'product_id'};
        $dailyproduction->produced = $dailyProductionJson->{'produced'};
        $dailyproduction->dispatches = $dailyProductionJson->{'dispatches'};
        $dailyproduction->sale_return = $dailyProductionJson->{'sale_return'};
        $dailyproduction->received = $dailyProductionJson->{'received'};
        $dailyproduction->branch_id = Auth::user()->branch_id;
        $dailyproduction->department_id = Auth::user()->department_id;
        $dailyproduction->company_id = Auth::user()->company_id;
        $dailyproduction->toArray();
    }
}
