<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CashOut;

class CashOutController extends Controller
{
    public function index()
    {
        $cashout=CashOut::all();
        return view('admin.cashout.index',compact('cashout'));
    }
}
