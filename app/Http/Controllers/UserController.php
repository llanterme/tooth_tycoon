<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Childe;
use App\Models\InvestAmount;
use App\Models\CashOut;
use Session;

class UserController extends Controller
{
    public function index()
    {
        $user=User::all();
        return view('admin.user.index',compact('user'));
    }

    public function edit($id)
    {
        $user=User::find($id);
        return view('admin.user.edit',compact('user'));
        // dd($user);
    }

    public function TeethDetail($id)
    {
        $user=User::find($id);
        return view('admin.user.teeth_detail',compact('user'));
    }

    public function Child($id)
    {
        $user=User::find($id);
        return view('admin.user.child',compact('user'));
    }

    public function ChildePullList($id)
    {
        $childe =Childe::find($id);
        return view('admin.user.teeth_detail',['user'=>$childe]);
    }

    public function ChildeInvest($id)
    {
        $childe =Childe::find($id);
        $amount=InvestAmount::where('child_id',$id)->get();
        return view('admin.user.invest_childe',['user'=>$childe,'amount'=>$amount]);
    }

    public function CashOut($id)
    {
        $childe =Childe::find($id);
        $amount=CashOut::where('child_id',$id)->get();
        return view('admin.user.cash_out',['user'=>$childe,'amount'=>$amount]);
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required']
        ]);

        $user=User::find($id);

        $user->email=$request->email;
        $user->name=$request->name;
        $user->save();
        Session::flash('message', 'User Updated Successfully.');

        return redirect(route('User'));

    }
}
