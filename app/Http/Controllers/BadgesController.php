<?php

namespace App\Http\Controllers;

use App\Models\Badges;
use Illuminate\Http\Request;
use Carbon\carbon;
use Session;
use App\Models\Question;
use File;
use Storage;

class BadgesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $badges=Badges::all();

        return view('admin.budges.index',compact('badges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.budges.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'img' => ['required'],
            'depend' => ['required'],
            'number_time' => ['required']
        ]);
        $Badges=new Badges();
        $Badges->name=$request->name;
        $Badges->description=$request->description;
        $Badges->depend=$request->depend;
        $Badges->number_time=$request->number_time;


        if($request->hasFile('img'))
        {
            $Badges->img='storage/'.$request->file('img')->store('badges');
        }

        $Badges->save();

        Session::flash('message', 'Budge Added Successfully.');

        return redirect(route('Budges.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Badges  $badges
     * @return \Illuminate\Http\Response
     */
    public function show(Badges $badges)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Badges  $badges
     * @return \Illuminate\Http\Response
     */
    public function edit(Badges $badges,$id)
    {
        $badges=$badges->find($id);
        return view('admin.budges.edit',compact('badges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Badges  $badges
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'depend' => ['required'],
            'number_time' => ['required']
        ]);

        $badges=Badges::findOrFail($id);
        $badges->name=$request->name;
        $badges->description=$request->description;
        $badges->depend=$request->depend;
        $badges->number_time=$request->number_time;

        if($request->hasFile('img'))
        {
            $image_path=public_path('batges/'.$badges->img);
            if($badges->img!="default.png")
            {
                $old_file_path = str_replace('storage/','',$badges->img);
                Storage::delete($old_file_path);
            }
            $badges->img='storage/'.$request->file('img')->store('batges');
        }

        $badges->save();
        Session::flash('message', 'Budge Updated Successfully.');
        return redirect(route('Budges.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Badges  $badges
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=Badges::find($id);
        $user->delete();
        Session::flash('message', 'Budge Deleted Successfully.');
        return redirect(route('Budges.index'));
    }
}
