<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use Illuminate\Support\Facades\Session;
use Auth;
class DepartmentController extends Controller
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
        if (Auth::user()->can('Read-Department')) 
            {
       $department=Department::orderBy('created_at','desc')->get();
        $setModal=0;
        $departmentData=0;
       return view('Department.index',compact('department','setModal','departmentData'));
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
        $departmentData = new Department();
        $this->SaveDepartment($request,$departmentData);
        if($departmentData->save())
        {
            Session::flash('notice','Department was successfully created');
            return redirect('/Department');
        }
        else
        {
            Session::flash('alert','Department was not successfully created');
            return redirect('/Department');
        }  //
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
        if (Auth::user()->can('Edit-Department')) 
            {
      $departmentData=Department::findOrFail($id);
       $setModal=1;
       $department=Department::orderBy('created_at','desc')->get();
       return view('Department.index',compact('department','setModal','departmentData'));
       }
       else{
        abort(500);
       }  //
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
        $departmentData=Department::findOrFail($id);
       $this->validateEditInput($request,$departmentData);
        $this->SaveDepartment($request,$departmentData);
        if($departmentData->save())
        {
            Session::flash('notice','Department was successfully Edited');
            return redirect('/Department');
        }
        else
        {
            Session::flash('alert','Department was not successfully Edited');
            return redirect('/Department');
        } // //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     //    if (Auth::user()->can('Delete-Department')) 
     //        {
     //    $departmentData=Department::findOrFail($id);
       
     //    if( $departmentData->delete())
     //    {
     //        Session::flash('notice','Department was successfully Deleted');
     //        return redirect('/Department');
     //    }
     //    else
     //    {
     //        Session::flash('alert','Department was not successfully Deleted');
     //        return redirect('/Department');
     //    }
     // }
     // else{
     //    abort(500);
     // }
    }

    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments,name',
            'email' => 'required',
            'phone'=>  'min:11|numeric'
        ]);
    }
    protected function validateEditInput(Request $request,$departmentData)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments,name,'.$departmentData->id,
            'email' => 'required',
            'phone'=>  'min:11|numeric'
        ]);
    }
    protected function SaveDepartment(Request $request,$departmentData)
    {
        $departmentData->name=$request->name;
        $departmentData->email=$request->email;
        $departmentData->phone=$request->phone;
        $departmentData->description=$request->Description;
        $departmentData->toArray();
    }
}
