<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use Auth;
class RoleController extends Controller
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
        if (Auth::user()->can('Read-Role')) 
            {
        $roleData=Role::where('delete_status',1)->get();
        $permissionData=Permission::all();
        $setModal=0;
        $roleaData=0;
        return view('Role.index',compact('roleData','setModal','roleaData','permissionData'));}
        else
        {
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
        $permissionSize=sizeof($request->permissionList);
        $this->validateInput($request);
        $roleData = new Role();
        $this->SaveRole($request,$roleData);
        if($roleData->save())
        {
            Session::flash('notice','Role was successfully created');
            for($i = 0; $i < $permissionSize;$i++)
            {
                $roleData->givePermissionTo($request->permissionList[$i]);
            }
            return redirect('/Role');
        }
        else
        {
            Session::flash('alert','Role was not successfully created');
            return redirect('/Role');
        } //
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
        if (Auth::user()->can('Edit-Role')) 
            {
       $roleaData=Role::findOrFail($id);
       $setModal=1;
       $permissionData=Permission::all();
       $roleData=Role::where('delete_status',1)->get();
       return view('Role.index',compact('permissionData','setModal','roleaData','roleData')); 
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
        $permissionSize=sizeof($request->permissionList);
        $roleData =Role::findOrFail($id);
        $this->validateEditInput($request,$roleData);
        $this->SaveRole($request,$roleData);
        $idPer=Role::findOrFail($id)->permissions;
       foreach ($idPer as $pername) {
           $roleData->revokePermissionTo($pername->name);
       }
        if($roleData->save())
        {
            Session::flash('notice','Role was successfully Edited');
            for($i = 0; $i < $permissionSize;$i++)
            {
                $roleData->givePermissionTo($request->permissionList[$i]);
            }
            return redirect('/Role');
        }
        else
        {
            Session::flash('alert','Role was not successfully Edited');
            return redirect('/Role');
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
        if (Auth::user()->can('Delete-Role')) 
            {
       $roleData=Role::findOrFail($id);
        if($roleData->delete())
        {
            Session::flash('notice','Role was successfully Deleted');
            return redirect('/Role');
        }
        else
        {
            Session::flash('alert','Role was not successfully Deleted');
            return redirect('/Role');
        }
    }
    else{
        abort(500);
    }
    }
    protected function validateInput(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name'
        ]);
    }
    protected function validateEditInput(Request $request,$roleData)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$roleData->id
        ]);
    }
    protected function SaveRole(Request $request,$roleData)
    {
        $roleData->name=$request->name;
        $roleData->delete_status=1;
        $roleData->toArray();
    }
}
