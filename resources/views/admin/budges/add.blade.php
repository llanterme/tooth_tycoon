@extends('adminlte::page')

@section('title', config('adminlte.title').' Users')

@section('content_header')
    <h1>Add Budges</h1>
@stop

@section('content')
@include('admin.massage')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form role="form" action="{{ route('Budges.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            @csrf
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" name="description" class="form-control" id="description" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="img">Img</label>
                            <input type="file" name="img" class="form-control" id="img">
                        </div>
                        <div class="form-group">
                            <label for="list">Depend</label>
                            <select class="form-control" name="depend" id="list">
                                <option value="Pull_tooth">Pull_tooth</option>
                                <option value="mile_store">mile_store</option>
                                <option value="photos">photos</option>
                                <option value="incisor">incisor</option>
                                <option value="canines">canines</option>
                                <option value="premolars">premolars</option>
                                <option value="molars">molars</option>
                                <option value="question1">question1</option>
                                <option value="question2">question2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number">Nubmer Counts</label>
                            <input type="number" name="number_time" id="number" value="0" class="form-control">
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
           $('#example').DataTable({
            });
        } );
        </script>
@stop
