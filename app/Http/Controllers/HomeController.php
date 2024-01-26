<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Models\Userright;
use App\Models\Userrole;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $verified = Auth::user()->accountVerified();
//        $roles = Userrole::query()->select("rolename")->where("rolename",'=',"Creator");
//
//
//        $role = Auth::user()->hasRole($roles);
        //$superRole = Auth::user()->hasRole("Superuser");
        // $user = Auth::user();
        // $role = Auth::user()->hasRole("Reviewer");
        // $hashedPassword = Auth::user()->getAuthPassword();
        // if (Hash::check("Admin@123", $hashedPassword))
        //     return redirect()->route("profile")->with("message", "Please update your password before you can continue");
        // else
            return Bridge::view("home", get_defined_vars());
    }
}
