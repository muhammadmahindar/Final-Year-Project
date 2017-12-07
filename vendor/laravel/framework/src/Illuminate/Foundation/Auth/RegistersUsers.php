<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Company;
use App\Branch;
use App\Department;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Facades\Session;
use Auth;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */

    public function showRegistrationForm()
    {
        if (Auth::user()->can('Create-User')) 
            {
        $CompanyData=Company::all();
        $roleData=Role::where('delete_status',1)->get();
        return view('auth.register',compact('CompanyData','BranchData','DepartmentData','roleData'));
    }else{
        abort(500);
    }
    }

    public function getbranch(Request $request)
    {
        if($request->ajax()){
            $states=Branch::where('company_id',$request->companyList)->pluck("name","id")->all();
            $data = view('auth.ajax.ajaxbranch',compact('states'))->render();
            return response()->json(['options'=>$data]);
        }
    }


    public function getdepartment(Request $request)
    {
        if($request->ajax()){
            $states=Branch::where('id',$request->branchList)->get();
            $data = view('auth.ajax.ajaxdepartment',compact('states'))->render();
            return response()->json(['options'=>$data]);
        }
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $formulaSize=sizeof($request->roleList);
        if(count(array_unique($request->roleList))<count($request->roleList))
        {
            return redirect()->back()->withInput()->withErrors(['roleList' => 'Duplicate Role Name']);// Array has duplicates
        }
        else
        {
        event(new Registered($user = $this->create($request->all())));
        for($i = 0; $i < $formulaSize;$i++)
        {
          $user->assignRole($request->roleList[$i]); 
        }
        }
        
        Session::flash('notice','User was successfully ');
        return redirect('Users');
    }

    /**
     * Get the guard to be uCreatedsed during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
