<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvestAmount;

class InvestController extends Controller
{
    public function index()
    {
        $invest=InvestAmount::all();
        return view('admin.invest.index',compact('invest'));
        // $invest=InvestAmount::find(1);
        // dd($invest->PullDetail);
    }
}
