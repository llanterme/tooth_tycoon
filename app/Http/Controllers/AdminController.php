<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Admin;
use App\Badges;
use App\Budget;
use App\CashOut;
use App\InvestAmount;
use App\User;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Log;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', '=', $request->email)->first();
        if (!$admin)
        {
            $errors = new MessageBag(['email' => ['Invalid Email.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->only('email','password'));
            // return redirect()->back()->withInput($request->only('email'));
            // return response()->json(['success'=>false, 'message' => 'Login Fail, please check email id']);
        }
        if (!Hash::check($request->password, $admin->password))
        {
            $errors = new MessageBag(['password' => ['Invalid Password.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->only('email','password'));
            // return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
        }

        $array=array();
        $array["email"]=$admin->email;
        $array["pass"]=$admin->password;
        $array["name"]=$admin->name;
        $array["login_time"]=date('Y-m-d H:i:s');
        $array["ip"]=$request->ip();
        $request->session()->put('_admin_session',$array);
        Log::info('Admin Login', ['admin' => $array]);
        return redirect('admin/home');

    }

    public function home(Request $request)
    {
        $user=User::all()->count();
        $budges=Badges::all()->count();
        $budget=Budget::all()->count();
        $investamount=InvestAmount::all()->count();
        $cashout=CashOut::all()->count();
        return view('admin.home',compact('user','budges','budget','investamount','cashout'));
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('_admin_session');
        return redirect("/");
    }
}
