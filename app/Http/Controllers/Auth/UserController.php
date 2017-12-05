<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
   public function index()
   {
   	$userData=User::all();
    $permissionData=Permission::all();
    $setModal=0;
    $roleaData=0;
   	return view('auth.users.index',compact('userData','setModal','roleaData','permissionData')); 
   }
}
