<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repository\BaseController;
use App\Models\Childe;
use App\Models\PullDetails;
use App\Models\Badges;
use Carbon\Carbon;
use Validator; 
class ChildController extends Controller
{
    public function __construct(BaseController $baseController)
    {
        $this->baseController=$baseController;
    }

    public function child_list(Request $request)
    {
        $user=$request->user();
        if($user->Childe->count()>0)
            return $this->baseController->ResponseJson(1,'Childe List',$user->Childe,200);
        else
            return $this->baseController->ResponseJson(1,'Childe List id Empty.',[],200);
    }

    public function ChildAdd(Request $request)
    {
        $rules = [
            'name'     => 'required',
            'age'     => 'required',
        ];
        $messages = [
            'name.required' => trans('validation.required'),
            'age.required' => trans('validation.required'),
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
        //     'name' => 'required',
        //     'age' => 'required',
        // ]);
        $user=$request->user();
        $Childe=new Childe();
        $Childe->name=$request->name;
        $Childe->age=$request->age;
        if($request->hasFile('image'))
        {
            // $code = Carbon::now()->timestamp;
            // $file_name=$code.'.'.$request->file('image')->extension();
            // $request->file('image')->move(public_path("childe"),$file_name);
            $Childe->img='storage/'.$request->file('image')->store('childe');
            // $Childe->img=$file_name;
        }
        $Childe->user_id=$user->id;
        $Childe->save();
        return $this->baseController->ResponseJson(1,'Childe Added Successfully',$Childe,200);
    }

    public function PullHistory(Request $request)
    {

        $request->validate([
            'child_id' => 'required',
        ]);

        $list=array();
        $list['TeethList']=PullDetails::where('child_id',$request->child_id)->get();
        $list['Amount']=PullDetails::where('child_id',$request->child_id)->get()->count()*10;
        $list['Badges']=Badges::all();

        if($list['TeethList']->count()>0)
        {
            return $this->baseController->ResponseJson(1,'Childe Summary',$list,200);
        }
        else
        {
            return $this->baseController->ResponseJson(1,'This Child Not Pulled Any Teeth',[],200);
        }
    }
}
