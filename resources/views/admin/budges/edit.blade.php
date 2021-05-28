@extends('adminlte::page')

@section('title', config('adminlte.title').' Users')
{{-- config('adminlte.title_prefix', '')) --}}
@section('content_header')
    <h1>Edit Budges</h1>
@stop

@section('content')
@include('admin.massage')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form role="form" action="{{ route('Budges.update',$badges->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            @csrf
                            @method('PATCH')
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ $badges->name }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea type="text" name="description" class="form-control" id="exampleInputPassword1" placeholder="description">{{ $badges->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="img">Img</label>
                            <input type="file" name="img" class="form-control" id="img" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="list">Depend</label>
                            <select class="form-control" name="depend" id="list">
                                <option value="Pull_tooth" @if($badges->depend=="Pull_tooth") selected @endif>Pull Tooth</option>
                                <option value="mile_store" @if($badges->depend=="mile_store") selected @endif>Mile Store</option>
                                <option value="photos" @if($badges->depend=="photos") selected @endif>Photos</option>
                                <option value="incisor" @if($badges->depend=="incisor") selected @endif>Incisor</option>
                                <option value="canines" @if($badges->depend=="canines") selected @endif>Canines</option>
                                <option value="molars" @if($badges->depend=="molars") selected @endif>Molars</option>
                                <option value="question1" @if($badges->depend=="question1") selected @endif>Question 1</option>
                                <option value="question2" @if($badges->depend=="question2") selected @endif>Question 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number">Nubmer Counts</label>
                            <input type="number" name="number_time" id="number" value="{{ $badges->number_time }}" class="form-control">
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
    <script>
        $(document).ready(function() {
           $('#example').DataTable();
        } );
        </script>
@stop
