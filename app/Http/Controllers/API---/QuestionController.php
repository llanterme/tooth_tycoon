<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Repository\BaseController;
use App\Models\SubmitQuestion;

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
        $msg="Submit Data successfully";
        $request->validate([
            "question1"=> ['required'],
            "question2"=> ['required'],
            "child_id"=> ['required']
        ]);
        $data=array();
        $submit_last=SubmitQuestion::where('childe_id',$request->child_id)->orderBy('id', 'DESC')->first();
        if(!empty($submit_last))
        {
            if($submit_last->created_at->toDateString()==date('Y-m-d'))
            {
                $msg="You submit today";
                $data['tooth']=SubmitQuestion::where('childe_id',$request->child_id)->orderBy('id', 'DESC')->first();
                $data['count']=SubmitQuestion::where('childe_id',$request->child_id)->count();
            }
            else
            {
                $last_date=date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
                if($last_date==$submit_last->created_at->toDateString())
                {
                    $msg="Match continued";
                    $data['tooth']=$this->add_data($request);
                    $data['count']=SubmitQuestion::where('childe_id',$request->child_id)->count();
                }
                else
                {
                    $qus_sub = SubmitQuestion::where('childe_id',$request->child_id)->get();
                    foreach($qus_sub as $submit){
                        $submit->delete();
                    }
                    $msg="You missed some date";
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
