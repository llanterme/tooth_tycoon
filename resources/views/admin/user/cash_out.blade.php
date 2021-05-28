@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Cash Out detail of {{ ucfirst($user->name) }}</h1>
@stop

@section('content')
@include('admin.massage')

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Amount</th>
        <th scope="col">Date</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($amount as $item)
        <tr>
            <td>
                {{ $sr++ }}
            </td>
            <td>
                {{ $item->amount }}
            </td>
            <td>
                {{ $item->created_at->diffForHumans() }}
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

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
