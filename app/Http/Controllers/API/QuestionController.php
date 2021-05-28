<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Http\Repository\BaseController;
use App\SubmitQuestion;
use Validator;

class QuestionController extends Controller
{
	public function __construct(BaseController $baseController)
	{
		$this->baseController=$baseController;
	}

	public function GetQuestion()
	{
		return $this->baseController->ResponseJson(1,'Add Budget',Question::all(),200);
	}

	public function SubmitQuestion(Request $request)
	{
		$msg=trans('messages.submit_question');
		// $request->validate([
		// 	"question1"=> ['required'],
		// 	"question2"=> ['required'],
		// 	"child_id"=> ['required']
		// ]);
		$rules = [
			'child_id'     => 'required',
			'question1'     => 'required',
			'question2'     => 'required',
		];
		$messages = [
			'child_id.required' => trans('validation.required'),
			'question1.required' => trans('validation.required'),
			'question2.required' => trans('validation.required'),
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
		$data=array();
		$submit_last=SubmitQuestion::where('childe_id',$request->child_id)->orderBy('id', 'DESC')->first();
		if(!empty($submit_last))
		{
			if($submit_last->created_at->toDateString()==date('Y-m-d'))
			{
				$msg=trans('messages.submit_question_today');
				$data['tooth']=SubmitQuestion::where('childe_id',$request->child_id)->orderBy('id', 'DESC')->first();
				$data['count']=SubmitQuestion::where('childe_id',$request->child_id)->count();
			}
			else
			{
				$last_date=date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
				if($last_date==$submit_last->created_at->toDateString())
				{
					
					$msg=trans('messages.submit_question_match');
					$data['tooth']=$this->add_data($request);
					$data['count']=SubmitQuestion::where('childe_id',$request->child_id)->count();
				}
				else
				{
					$qus_sub = SubmitQuestion::where('childe_id',$request->child_id)->get();
					foreach($qus_sub as $submit){
						$submit->delete();
					}
					
					$msg=trans('messages.submit_question_missed');
					$data['tooth']=$this->add_data($request);
					$data['count']=SubmitQuestion::where('childe_id',$request->child_id)->count();
				}
			}
		}
		else
		{
			$data['tooth']=$this->add_data($request);
			$data['count']=SubmitQuestion::where('childe_id',$request->child_id)->count();
		}
		return $this->baseController->ResponseJson(1,$msg,$data,200);
	}

	public function add_data($request)
	{
		$submit=new SubmitQuestion();
		$submit->question1=$request->question1;
		$submit->question2=$request->question2;
		$submit->childe_id=$request->child_id;
		$submit->save();
		return $submit;
	}
}
