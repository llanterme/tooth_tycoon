@extends('adminlte::page')

@section('title', 'Set Tooth Rewards')

@section('content_header')
    <h1>Edit Tooth Rewards</h1>
@stop

@section('content')
@include('admin.massage')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form role="form" action="{{ route('reward-save') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-2">
                              <label for="example" >Type</label>
                              {{-- <input type="email" class="form-control" placeholder="Enter your email"> --}}
                            </div>
                            <div class="col-2">
                              <label for="example">Tooth No</label>
                              {{-- <input type="email" class="form-control" placeholder="Enter your email"> --}}
                            </div>
                            <div class="col-4">
                              <label for="example">Reward</label>
                              {{-- <input type="password" class="form-control" placeholder="Enter your password"> --}}
                            </div>
                          </div>
                        @foreach($rewards as $val)
                           <div class="form-row">
                            <div class="col-2">
                              <label for="example" class="col-sm-4 col-form-label col-form-label-sm">{{$val->type}}</label>
                              
                            </div>
                            <div class="col-2">
                              <label for="example" class="col-sm-4 col-form-label col-form-label-sm">{{$val->teeth_number}}</label>
                              
                            </div>
                            <div class="col-4 mb-2">
                             
                              <input type="number" name="reward[{{$val->id}}]" class="form-control" placeholder="Enter your password" value="{{$val->reward}}">
                            </div>
                          </div>
                        @endforeach

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
