<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Company;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company=Company::orderBy('created_at','desc')->get();
        $setModal=0;
        $companyData=0;
       return view('Company.index',compact('company','setModal','companyData')); //
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
        $companyData = new Company();
        $this->SaveCompany($request,$companyData);
        if($companyData->save())
        {
            Session::flash('notice','Company was successfully created');
            return redirect('/Company');
        }
        else
        {
            Session::flash('alert','Company was not successfully created');
            return redirect('/Company');
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
       $companyData=Company::findOrFail($id);
       $setModal=1;
       $company=Company::orderBy('created_at','desc')->get();
       return view('Company.index',compact('company','setModal','companyData'));; //
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
       $companyData=Company::findOrFail($id);
       $this->validateEditInput($request,$companyData);
        $this->SaveCompany($request,$companyData);
        if($companyData->save())
        {
            Session::flash('notice','Company was successfully Edited');
            return redirect('/Company');
        }
        else
        {
            Session::flash('alert','Company was not successfully Edited');
            return redirect('/Company');
        } //
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

    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:companies,name',
            'email' => 'required',
            'phone'=>  'min:11|numeric'
        ]);
    }
    protected function validateEditInput(Request $request,$companyData)
    {
        $this->validate($request, [
            'name' => 'required|unique:companies,name,'.$companyData->id,
            'email' => 'required',
            'phone'=>  'min:11|numeric'
        ]);
    }
    protected function SaveCompany(Request $request,$companyData)
    {
        $companyData->name=$request->name;
        $companyData->email=$request->email;
        $companyData->phone=$request->phone;
        $companyData->address=$request->Address;
        $companyData->description=$request->Description;
        $companyData->toArray();
    }
}
