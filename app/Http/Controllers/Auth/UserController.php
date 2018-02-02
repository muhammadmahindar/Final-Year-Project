<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use App\Company;
use App\Branch;
use App\Department;
use Auth;
class UserController extends Controller
{

   public function index()
   {
    if (Auth::user()->can('Read-User')) 
            {
   	$userData=User::where('delete_status',1)->get();
    $permissionData=Permission::all();
    $roleaData=0;
    $setModal=0;
   	return view('auth.users.index',compact('userData','setModal','roleaData','permissionData')); 
   }
   else{
    abort(500);
   }
   }

   public function edit($id)
    {
        if (Auth::user()->can('Edit-User')) 
            {
        $userData=User::findOrFail($id);
        $CompanyData=Company::all();
        $departmentData=Department::find($userData->department_id);
        $branchData=Branch::find($userData->branch_id);
        $roleData=Role::where('delete_status',1)->get();
       return view('auth.users.edit',compact('CompanyData','branchData','departmentData','roleData','userData'));
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
        $formulaSize=sizeof($request->roleList);
        if(count(array_unique($request->roleList))<count($request->roleList))
        {
            return redirect()->back()->withInput()->withErrors(['roleList' => 'Duplicate User Name']);// Array has duplicates
        }
        else{ 
            $userData=User::findOrFail($id);
            $this->validateEditInput($request,$userData);
            $this->SaveUser($request,$userData);
           
            foreach ($userData->roles as $keyvalue) {
                $userData->removeRole($keyvalue->name);
            }

              if($userData->save())
            {

            Session::flash('notice','User was successfully Edited');
            for($i = 0; $i < $formulaSize;$i++)
            {
          $userData->assignRole($request->roleList[$i]); 
            }
            return redirect('/Users');
            }
            else
            {
            Session::flash('alert','User was not successfully Edited');
            return redirect('/Users');
            } 
          

        }
    }
     protected function SaveUser(Request $request,$userData)
    {
            $userData->name=$request->name;
            $userData->email=$request->email;
            $userData->active=$request->status;
            $userData->branch_id=$request->branchList;
            $userData->department_id=$request->departmentList;
            $userData->company_id=$request->companyList;
            $userData->toArray();
    }
   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('Delete-User')) 
            {
       $userData=User::findOrFail($id);
       $userData->delete_status=0;
        if($userData->save())
        {
            Session::flash('notice','User was successfully Deleted');
            return redirect('/Users');
        }
        else
        {
            Session::flash('alert','User was not successfully Deleted');
            return redirect('/Users');
        }
    }
    else{
        abort(500);
    }
    }
    protected function validateEditInput(Request $request,$userData)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$userData->id,
            'status'=>'required',
            'branchList'=>'required',
            'departmentList'=>'required',
            'companyList'=>'required',
            'roleList'=>'required'
        ]);
       
    }

}
