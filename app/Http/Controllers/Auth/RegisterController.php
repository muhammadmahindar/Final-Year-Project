<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => 'required|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6',
            'status'        => 'required',
            'branchList'    => 'required',
            'departmentList'=> 'required',
            'avatar'        => 'nullable',
            'companyList'   => 'required',
            'roleList'      => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => bcrypt($data['password']),
            'active'       => $data['status'],
            'branch_id'    => $data['branchList'],
            'department_id'=> $data['departmentList'],
            'company_id'   => $data['companyList'],
            'avatar'       => $data['avatar'],
            'delete_status'=> 1,
        ]);
    }
}
