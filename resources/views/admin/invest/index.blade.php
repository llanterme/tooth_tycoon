@extends('adminlte::page')

@section('title', config('adminlte.title').' Users')
{{-- config('adminlte.title_prefix', '')) --}}
@section('content_header')
    <h1>Invest</h1>
@stop

@section('content')
@include('admin.massage')

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Chile</th>
        <th scope="col">Year</th>
        <th scope="col">Rate</th>
        <th scope="col">Amount</th>
        <th scope="col">Teeth Number</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($invest as $item)
        <tr>
            <td>
                {{ $sr++ }}
            </td>
            <td>
                {{ $item->User->name }}
            </td>
            <td>
                {{ $item->Childe->name }}
            </td>
            <td>
                {{ $item->years }}
                ( {{ date('d-M-Y',strtotime($item->end_date)) }} )

            </td>
            <td>
                {{ $item->rate }}
            </td>
            <td>
                {{ $item->amount }}
            </td>
            <td>
                {{ $item->pulldetail->teeth_number }}
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>

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
