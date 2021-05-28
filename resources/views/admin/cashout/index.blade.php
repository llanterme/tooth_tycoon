@extends('adminlte::page')

@section('title', config('adminlte.title').' CashOut')
{{-- config('adminlte.title_prefix', '')) --}}
@section('content_header')
    <h1>CashOut</h1>
@stop

@section('content')
@include('admin.massage')

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Chile</th>
        <th scope="col">Amount</th>
        <th scope="col">Teeth Number</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($cashout as $item)
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
                {{ $item->amount }}
            </td>
            <td>
                {{ isset($item->PullDetail->teeth_number)?$item->PullDetail->teeth_number:'' }}
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
