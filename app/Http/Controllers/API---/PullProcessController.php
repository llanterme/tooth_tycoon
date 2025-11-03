<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repository\BaseController;
use App\Models\PullDetails;
use App\Models\InvestAmount;
use App\Models\CashOut;
use App\Models\Budget;
use App\Models\MileStore;
use Carbon\Carbon;

class PullProcessController extends Controller
{
    public function __construct(BaseController $baseController)
    {
        $this->baseController=$baseController;
    }

    public function Pull(Request $request)
    {
        $request->validate([
            'child_id' => ['required'],
            'teeth_number' => ['required'],
            'picture' => ['required'],
            'pull_date' => ['required','date','date_format:Y-m-d'],

        ]);

        $pull_cheack=PullDetails::where('child_id',$request->child_id)->where('teeth_number',$request->teeth_number)->first();
        if(!empty($pull_cheack))
        {
            return $this->baseController->ResponseJson(0,'Exist This recode.',$pull_cheack,200);
        }


        $PullDetails=new PullDetails;
        $PullDetails->child_id=$request->child_id;
        $PullDetails->teeth_number=$request->teeth_number;
        $PullDetails->pull_date=$request->pull_date;

        if($request->hasFile('picture'))
        {
            // $extension = $request->file('picture')->extension();
            // $code = Carbon::now()->timestamp;
            // $file_name=$code.'.'.$extension;
            // $request->file('picture')->move(public_path("pull_img"),$file_name);
            $PullDetails->picture='storage/'.$request->file('picture')->store('batges');
            // $PullDetails->picture=$file_name;
        }
        $PullDetails->save();
        $PullDetails->earn="10";
        return $this->baseController->ResponseJson(1,'Pull Teeth Details.',$PullDetails,200);
    }

    public function invest(Request $request)
    {
        $request->validate([
        "child_id"=> ['required'],
        "pull_detail_id"=> ['required'],
        "years"=> ['required'],
        "rate"=> ['required'],
        "end_date"=> ['required','date','date_format:Y-m-d','after:now'],
        "amount"=> ['required'],
        "final_amount"=> ['required']
        ]);
        $invest=new InvestAmount();
        $invest->user_id=$request->user()->id;
        $invest->child_id=$request->child_id;
        $invest->pull_detail_id=$request->pull_detail_id;
        $invest->years=$request->years;
        $invest->rate=$request->rate;
        $invest->end_date=$request->end_date;
        $invest->amount=$request->amount;
        $invest->final_amount=$request->final_amount;
        $invest->save();
        return $this->baseController->ResponseJson(1,'invest detail',$invest,200);
    }

    public function cashout(Request $request)
    {
        $request->validate([
        "child_id"=> ['required'],
        "pull_detail_id"=> ['required'],
        "amount"=> ['required'],
        ]);
        $cashout=new CashOut();
        $cashout->user_id=$request->user()->id;
        $cashout->child_id=$request->child_id;
        $cashout->pull_detail_id=$request->pull_detail_id;
        $cashout->amount=$request->amount;
        $cashout->save();
        return $this->baseController->ResponseJson(1,'Cash Out Detail',$cashout,200);
    }

    public function SetBudget(Request $request)
    {
        $request->validate([
            "amount"=> ['required'],
        ]);
        $budget=Budget::updateOrCreate(['user_id' => $request->user()->id],['amount' => $request->amount,'user_id' => $request->user()->id]);
        return $this->baseController->ResponseJson(1,'Add Budget',$budget,200);
    }

    public function Milestore(Request $request)
    {
        $request->validate(["child_id"=> ['required'],]);
        $MileStore=new MileStore;
        $MileStore->user_id=$request->user()->id;
        $MileStore->child_id=$request->child_id;
        $MileStore->save();
        return $this->baseController->ResponseJson(1,"Success",$MileStore,200);
    }
}
