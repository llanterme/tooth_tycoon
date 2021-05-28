@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
@include('admin.massage')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form role="form" action="{{ route('User-Update', $user->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputPassword1" placeholder="Name" value="{{ $user->name }}" >
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
<style>


  </style>

@stop

@section('js')
    <script>
        $(document).ready(function() {


        } );
        </script>
@stop
