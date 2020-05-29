<?php

namespace App\Http\Controllers\Branch;

use App\Branch;
use App\Company;
use App\Department;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BranchController extends Controller
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
        if (Auth::user()->can('Read-Branch')) {
            $branch = Branch::orderBy('created_at', 'desc')->get();
            $company = Company::orderBy('created_at', 'desc')->get();
            $departmentData = Department::orderBy('created_at', 'desc')->get();
            $setModal = 0;
            $branchData = 0;

            return view('Branch.index', compact('branch', 'setModal', 'branchData', 'company', 'departmentData'));
        } else {
            abort(500);
        }

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
        $this->validateInput($request);
        $branchData = new Branch();
        $this->SaveBranch($request, $branchData);
        if ($branchData->save()) {
            if ($request->departmentList != null) {
                $branchData->departments()->sync($request->departmentList);
            }
            Session::flash('notice', 'Branch was successfully created');

            return redirect('/Branch');
        } else {
            Session::flash('alert', 'Branch was not successfully created');

            return redirect('/Branch');
        } //
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
        if (Auth::user()->can('Edit-Branch')) {
            $branchData = Branch::findOrFail($id);
            $setModal = 1;
            $branch = Branch::orderBy('created_at', 'desc')->get();
            $company = Company::orderBy('created_at', 'desc')->get();
            $departmentData = Department::orderBy('created_at', 'desc')->get();

            return view('Branch.index', compact('company', 'branch', 'setModal', 'branchData', 'departmentData'));
        } else {
            abort(500);
        }  //
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
        $branchData = Branch::findOrFail($id);
        $this->validateEditInput($request, $branchData);
        $this->SaveBranch($request, $branchData);
        if ($branchData->save()) {
            if ($request->departmentList != null) {
                $branchData->departments()->sync($request->departmentList);
            }
            Session::flash('notice', 'Branch was successfully Edited');

            return redirect('/Branch');
        } else {
            Session::flash('alert', 'Branch was not successfully Edited');

            return redirect('/Branch');
        } //
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

       // $branchData=Branch::findOrFail($id);

       //   if( $branchData->delete())
       //  {
       //      Session::flash('notice','Branch was successfully Deleted');
       //      return redirect('/Branch');
       //  }
       //  else
       //  {
       //      Session::flash('alert','Branch was not successfully Deleted');
       //      return redirect('/Branch');
       //  } //
    }

    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|unique:branches,name',
            'email' => 'required',
            'phone' => 'min:11|numeric',
        ]);
    }

    protected function validateEditInput(Request $request, $branchData)
    {
        $this->validate($request, [
            'name'  => 'required|unique:branches,name,'.$branchData->id,
            'email' => 'required',
            'phone' => 'min:11|numeric',
        ]);
    }

    protected function SaveBranch(Request $request, $branchData)
    {
        $branchData->name = $request->name;
        $branchData->email = $request->email;
        $branchData->phone = $request->phone;
        $branchData->address = $request->Address;
        $branchData->description = $request->Description;
        $branchData->company_id = $request->companyId;
        $branchData->toArray();
    }
}
