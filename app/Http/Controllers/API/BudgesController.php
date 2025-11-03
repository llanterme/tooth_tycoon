<?php

namespace App\Http\Controllers\Api;

use App\Models\Badges;
use App\Models\PullDetails;
use App\Http\Controllers\Controller;
use App\Http\Repository\BaseController;
use App\Models\MileStore;
use App\Models\SubmitQuestion;
use Illuminate\Http\Request;
use Validator; 
class BudgesController extends Controller
{
	public function __construct(BaseController $baseController)
	{
		$this->baseController=$baseController;
	}

	public function list(Request $request)
	{
		//$request->validate(['child_id' => 'required']);
		$rules = [
			'child_id'     => 'required',
		];
		$messages = [
			'child_id.required' => trans('validation.required'),
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
		$detail_list=$list=$data=array();
		$detail_list['Pull_tooth'] 	= PullDetails::where('child_id',$request->child_id)->get()->count();
		$detail_list['molars'] 		= PullDetails::whereIn('teeth_number',['1','2','9','10','11','12','20','19'])->get()->count();
		$detail_list['canines'] 	= PullDetails::whereIn('teeth_number',['3','8','18','13'])->get()->count();
		$detail_list['incisor'] 	= PullDetails::whereIn('teeth_number',['4','5','6','7','14','15','16','17'])->get()->count();
		$detail_list['photos'] 		= PullDetails::whereNotNull('picture')->get()->count();
		$detail_list['question1'] 	= SubmitQuestion::where('question1',true)->get()->count();
		$detail_list['question2'] 	= SubmitQuestion::where('question2',true)->get()->count();
		$detail_list['mile_store'] 	= MileStore::where('child_id',$request->child_id)->get()->count();
		

		$Badges=Badges::all();

		foreach($Badges as $badge_list)
		{
			if($badge_list->number_time>0)
			{
				$badge_list->visible=false;
				$badge_list->now_exist=$detail_list[$badge_list->depend];
				if($detail_list[$badge_list->depend]>$badge_list->number_time)
				{
					$badge_list->visible=true;
				}
			}
			array_push($list,$badge_list);
		}
		$data['badges']=$list;

		return $this->baseController->ResponseJson(1,trans('messages.success_list'),$data,200);
	}
}
