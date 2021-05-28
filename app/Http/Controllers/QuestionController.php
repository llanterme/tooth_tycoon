<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Badges;
use App\Question;
use Session;

class QuestionController extends Controller
{
    public function index($id)
    {
        $badges=Badges::find($id);
        $question=Question::where('badges_id',$id)->where('status',0)->get();
        return view('admin.budges.question',compact('badges','question'));
    }

    public function AddQuestion($id)
    {
        $badges=Badges::find($id);
        return view('admin.budges.addquestion',compact('badges'));
    }

    public function StoreQuestion($id,Request $request)
    {
        $request->validate([
            'description' => ['required']
        ]);
        $question=new Question();
        $question->question=$request->description;
        $question->badges_id=$id;
        $question->save();
        Session::flash('message', 'Question Added Successfully.');
        return redirect(route('Budges.Question',$id));
    }

    public function EditQuestion($id)
    {
        $question=Question::find($id);
        return view('admin.budges.editquestion',compact('question'));
    }

    public function UpdateQuestion($id,Request $request)
    {
        $request->validate([
            'description' => ['required']
        ]);
        $question=Question::find($id);
        $question->question=$request->description;
        $question->save();
        Session::flash('message', 'Question Update Successfully.');
        return redirect(route('Budges.Question',$question->badges_id));
    }

    public function SoftDeleteQuestion($id)
    {
        $question=Question::find($id);
        $question->status='1';
        $question->save();
        Session::flash('message', 'Question Delete Successfully.');
        return redirect(route('Budges.Question',$question->badges_id));
    }
}
