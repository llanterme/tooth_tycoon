<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ToothReward;
use Session;

class ToothRewardController extends Controller
{
    public function index()
    {
        $rewards = ToothReward::orderBy('teeth_number')->get();
        return view('admin.tooth_reward.edit',compact('rewards'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'reward.*' => ['required'],
        ]);

        
        $rewards = $request->reward;
        // echo"<pre>";
        // print_r($rewards);
        foreach ($rewards as $key => $value) {
            $user = ToothReward::find($key);
            $user->reward=$value;
            $user->save();
        }
    
        Session::flash('message', 'Saved Successfully.');

        return redirect(route('tooth-reward-setting'));

    }
}
