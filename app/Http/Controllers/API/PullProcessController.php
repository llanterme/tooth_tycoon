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
use App\Models\Currency;
use App\Models\ToothReward;
use Carbon\Carbon;
use Validator;
class PullProcessController extends Controller
{
	public function __construct(BaseController $baseController)
	{
		$this->baseController=$baseController;
	}

	public function Pull(Request $request)
	{
		$rules = [
			'child_id'     => 'required',
			'teeth_number'     => 'required',
			'picture'     => 'required',
			'pull_date'     => 'required|date|date_format:Y-m-d',
		];
		$messages = [
			'child_id.required' => trans('validation.required'),
			'teeth_number.required' => trans('validation.required'),
			'picture.required' => trans('validation.required'),
			'pull_date.required' => trans('validation.required'),
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$error_messages = [];
			$errors = $validator->errors();
			foreach ($errors->getMessages() as $key => $error) {
				$error_messages[$key] = $error[0];
			}
			return response()->json([
						'message' => $errors->first(),
						'errors' => $error_messages
							], 422);
		}
		// $request->validate([
		//     'child_id' => ['required'],
		//     'teeth_number' => ['required'],
		//     'picture' => ['required'],
		//     'pull_date' => ['required','date','date_format:Y-m-d'],

		// ]);

		$pull_cheack=PullDetails::where('child_id',$request->child_id)
							->where('teeth_number',$request->teeth_number)
							->first();
		if(!empty($pull_cheack))
		{
			return $this->baseController->ResponseJson(0,trans('messages.pull_exists'),$pull_cheack,200);
		}

		$teeth_number = ToothReward::where('teeth_number',$request->teeth_number)
							->first();
		$Budget_amount = Budget::where('user_id', $request->user()->id)->get()->first();

		$PullDetails 			= new PullDetails;
		$PullDetails->child_id	= $request->child_id;
		$PullDetails->teeth_number=$request->teeth_number;
		//$PullDetails->reward =isset($teeth_number['reward'])?$teeth_number['reward']:0;
		$PullDetails->reward =isset($Budget_amount['amount'])?$Budget_amount['amount']:0;
		$PullDetails->pull_date = $request->pull_date;

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
		$reward  	= (int)PullDetails::where('child_id',$request->child_id)->sum('reward');
		$CashOut  	= (int)CashOut::where('child_id',$request->child_id)->sum('amount');
		$PullDetails->earn  	= (string)($reward-$CashOut);
		//$PullDetails->earn="10";
		return $this->baseController->ResponseJson(1,trans('messages.pull_success'),$PullDetails,200);
	}

	public function invest(Request $request)
	{
		// $request->validate([
		// "child_id"=> ['required'],
		// "pull_detail_id"=> ['required'],
		// "years"=> ['required'],
		// "rate"=> ['required'],
		// "end_date"=> ['required','date','date_format:Y-m-d','after:now'],
		// "amount"=> ['required'],
		// "final_amount"=> ['required']
		// ]);
		$rules = [
			'child_id'     => 'required',
			'pull_detail_id'     => 'required',
			'years'     => 'required',
			'rate'     => 'required',
			'amount'     => 'required',
			'final_amount'     => 'required',
			'end_date'     => 'required|date|date_format:Y-m-d|after:now',
		];
		$messages = [
			'child_id.required' => trans('validation.required'),
			'pull_detail_id.required' => trans('validation.required'),
			'years.required' => trans('validation.required'),
			'rate.required' => trans('validation.required'),
			'amount.required' => trans('validation.required'),
			'final_amount.required' => trans('validation.required'),
			'end_date.required' => trans('validation.required'),
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$error_messages = [];
			$errors = $validator->errors();
			foreach ($errors->getMessages() as $key => $error) {
				$error_messages[$key] = $error[0];
			}
			return response()->json([
						'message' => $errors->first(),
						'errors' => $error_messages
							], 422);
		}
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
		return $this->baseController->ResponseJson(1,trans('messages.invest_success'),$invest,200);
	}

	public function cashout(Request $request)
	{
		// $request->validate([
		// "child_id"=> ['required'],
		// "pull_detail_id"=> ['required'],
		// "amount"=> ['required'],
		// ]);
		$rules = [
			'child_id'     => 'required',
			'pull_detail_id'     => 'required',
			'amount'     => 'required',
		];
		$messages = [
			'child_id.required' => trans('validation.required'),
			'pull_detail_id.required' => trans('validation.required'),
			'amount.required' => trans('validation.required'),
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$error_messages = [];
			$errors = $validator->errors();
			foreach ($errors->getMessages() as $key => $error) {
				$error_messages[$key] = $error[0];
			}
			return response()->json([
						'message' => $errors->first(),
						'errors' => $error_messages
							], 422);
		}
		$cashout=new CashOut();
		$cashout->user_id=$request->user()->id;
		$cashout->child_id=$request->child_id;
		$cashout->pull_detail_id=$request->pull_detail_id;
		$cashout->amount=$request->amount;
		$cashout->save();
		return $this->baseController->ResponseJson(1,trans('messages.cash_out'),$cashout,200);
	}

	public function SetBudget(Request $request)
	{
		$rules = [
			'amount'     => 'required',
			'currency_id'     => 'required',
		];
		$messages = [
			'amount.required' => trans('validation.required'),
			'currency_id.required' => trans('validation.required'),
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$error_messages = [];
			$errors = $validator->errors();
			foreach ($errors->getMessages() as $key => $error) {
				$error_messages[$key] = $error[0];
			}
			return response()->json([
						'message' => $errors->first(),
						'errors' => $error_messages
							], 422);
		}
		// $request->validate([
		// 	"amount"=> ['required'],
		// ]);
		$budget=Budget::updateOrCreate(
						['user_id' => $request->user()->id],
						['currency_id' => $request->currency_id,'amount' => $request->amount,'user_id' => $request->user()->id]
					);
		return $this->baseController->ResponseJson(1,trans('messages.add_budget'),$budget,200);
	}

	public function Milestore(Request $request)
	{
		$request->validate(["child_id"=> ['required'],]);
		$MileStore=new MileStore;
		$MileStore->user_id=$request->user()->id;
		$MileStore->child_id=$request->child_id;
		$MileStore->save();
		return $this->baseController->ResponseJson(1,trans('messages.mile_store'),$MileStore,200);
	}

	public function getCurrency(Request $request)
	{
		$Currencyobj = Currency::select('id','currency','code','symbol')->get()->toArray();

		return $this->baseController->ResponseJson(1,trans('messages.success_list'),$Currencyobj,200);
	}
}
