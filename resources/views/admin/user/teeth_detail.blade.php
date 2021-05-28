@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Teeth detail of {{ ucfirst($user->name) }}</h1>
@stop

@section('content')
@include('admin.massage')

<div class="row">
    <div class="col-12 mb-3">
        <button type="button" class="btn btn-default float-right" data-toggle="modal" data-target="#exampleModal" style="border-radius: 50%;">
        <i class="fa fa-info"></i>
        </button>
    </div>
</div>

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Teeth Number</th>
        <th scope="col">Img</th>
        <th scope="col">Date</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($user->PullDetails as $item)
        <tr>
            <td>
                {{ $sr++ }}
            </td>
            <td>
                {{ $item->teeth_number }}
            </td>
            <td>
                <img src="{{ $item->picture }}" alt="" width="120px">
            </td>
            <td>
                {{ $item->pull_date }}
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Teeth Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <img src="{{ asset('img/teeth_row.png') }}" class="img-fluid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            $('#example').DataTable({
            });

        } );
        </script>
@stop
