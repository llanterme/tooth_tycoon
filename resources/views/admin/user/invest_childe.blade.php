@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Teeth detail of {{ ucfirst($user->name) }}</h1>
@stop

@section('content')
@include('admin.massage')

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Year</th>
        <th scope="col">Rate</th>
        <th scope="col">End Date</th>
        <th scope="col">Amount</th>
        <th scope="col">Final Amount</th>

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
                {{ $item->years }}
            </td>
            <td>
                {{ $item->rate }}
            </td>
            <td>
                {{ date('d-m-Y',strtotime($item->end_date)) }}
            </td>
            <td>
                {{ $item->amount }}
            </td>
            <td>
                {{ $item->final_amount }}
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
