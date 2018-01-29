<?php

namespace App\Http\Controllers\Auth\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use App\User;

class ProfileController extends Controller
{
    use AuthenticatesUsers;
    
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->id==$id)
        {
        $userinfo=User::findOrfail($id);
        return view('auth.profile.show',compact('userinfo'));
        }
    else{
        abort(500);
       } 
    }
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->id==$id)
        {
        $userinfo=User::findOrfail($id);
        return view('auth.profile.edit',compact('userinfo')); 
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

        $userinfo=User::findOrfail($id);
        if ($this->attemptLogin($request)) {
            $userinfo->password=bcrypt($request->newpass);
            $userinfo->save();
            Session::flash('notice','Password was successfully changed');
            return redirect('/home');
        }
        else{
            return $this->sendFailedLoginResponsec($request);
        }
    }
    public function changepassword(Request $request,$id)
    {

        $userData=User::findOrFail($id);
        if (!$userData->hasRole('SuperAdmin')) {
        $this->validate($request, [
            'user_password' => 'required|min:6',
        
    ]);
        $userData->password=bcrypt($request->user_password);
        $userData->toArray();
        $userData->save();
        Session::flash('notice',$userData->name.' Password was successfully changed');
        return redirect('/Users');
    }
    else
    {
        abort(500);
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
        //
    }
}
