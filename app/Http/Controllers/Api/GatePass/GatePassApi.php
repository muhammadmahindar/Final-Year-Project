<?php

namespace App\Http\Controllers\Api\GatePass;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\GatePass;
use App\Product;
use App\Material;
use Auth;

class GatePassApi extends Controller
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
        if (Auth::user()->can('Read-GatePass')) 
            {
                $gatepass=GatePass::all();
                // $gatepass=GatePass::find(1)->materials()->get();
                
                return response()->json($gatepass);
            } 
       else
       {
        return response()->json([
            'data' => 'Permission not found'
        ], 403);
       }

        // return response()->json([
        //     'msg' => 'working'
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product=Product::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
                 $material=Material::where([['delete_status', '=', '1'],['company_id', '=', Auth::user()->company_id],['branch_id', '=', Auth::user()->branch_id],])->get();
                   return response()->json($arrayName = array('product' => $product,'material'=>$material ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $json = '{
    "gate_passes":{
        "contact_phone":"12345678901",
        "id":3,
        "remarks":"sincere",
        "person_name":"Ali Abrar",
        "destination":"Lahore"
        },
        
    "materials":[
        {"quantity":2,"material_id":1},
        {"quantity":3,"material_id":2},
        {"quantity":4,"material_id":3}
    ],
    
    "products":[
        {"product_id":1,"quantity":1},
        {"product_id":2,"quantity":1},
        {"product_id":3,"quantity":1}
    ]
    
}'; 

    $obj = json_decode($json);
    
    $gatePassObj = $obj->{'gate_passes'};

    // Saving GatePass Info

    $products = $obj->{'products'};
    $materials = $obj->{'materials'};

    $productsArray = [];
    $materialsArray = [];
    $productSize = count($products);
    $materialSize = count($materials);
    $id = '';
    $qty = '';

    for ($i=0; $i < $productSize; $i++) { 
        $product = $products[$i];

        $id = $product->product_id;
        $qty = $product->quantity;
        $productsArray[$id] = ['quantity' => $qty];

    }

    for ($i=0; $i < $materialSize; $i++) { 
        $material = $materials[$i];

        $id = $material->material_id;
        $qty = $material->quantity;

        $materialsArray[$id] = ['quantity' => $qty];

    }

    // Saving GatePass Object
    $gatePass = new GatePass();
    $gatePass->person_name = $gatePassObj->person_name;
    $gatePass->contact_phone = $gatePassObj->contact_phone;
    $gatePass->destination = $gatePassObj->destination;
    $gatePass->remarks = $gatePassObj->remarks;

    if ($gatePass->save()) {
        $gatePass->products()->sync($productsArray);
        $gatePass->materials()->sync($materialsArray);
        return response()->json([
            'status' => "success",
            'msg' => 'Successfully Created!'
        ]);
    } else {
        return response()->json([
            'status' => "fail",
            'msg' => 'UnSuccessfull !'
        ]);
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
        $gatePass = GatePass::find($id);
        $products = $gatePass->products()->get();
        $materials = $gatePass->materials()->get();


        return response()->json([
            'gatepass' => $gatePass,
            'products' => $products,
            'materials' => $materials
        ]);
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


        $products = GatePass::find(1)->products()->get();

        $productId = $products[0]->pivot->product_id;

        // $product = 

        // $products->save();

        return response()->json(
            $productId
        );



        // return $request->bearerToken();
        // $gatePassInput = json_decode($request->getContent(), true);

        // $gatepass = GatePass::find(1);

        // // return $gatepass;

        // $gatepass->person_name = $gatePassInput{"person_name"};
        // $gatepass->contact_phone = $gatePassInput{"contact_phone"};
        // $gatepass->destination = $gatePassInput{"destination"};
        // $gatepass->remarks = $gatePassInput{"remarks"};
        
        // $gatepass->save();


        // // return $gatePass;
        // return response()->json([
        //     "gatepass" => $gatePassInput

        // ]);


        
        // return $request->all();

        // return response()->json([
        //     "gatepass" => $request->input('person_name')
        //     // "gatepass" => "Hello"
             
        // ]);
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
        return response()->json([
            'data' => 'OK'
        ], 200);
    }
}
