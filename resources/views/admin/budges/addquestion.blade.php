@extends('adminlte::page')

@section('title', config('adminlte.title').' Users')
{{-- config('adminlte.title_prefix', '')) --}}
@section('content_header')
    <h1>Add Question</h1>
@stop

@section('content')
@include('admin.massage')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form role="form" action="{{ route('Budges.Question.Add',$badges->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Question</label>
                            <textarea type="text" name="description" class="form-control" id="exampleInputPassword1" placeholder="Question"></textarea>
                        </div>
                        <div class="from-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
