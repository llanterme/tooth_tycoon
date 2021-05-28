@extends('adminlte::page')

@section('title', config('adminlte.title').' Users')
{{-- config('adminlte.title_prefix', '')) --}}
@section('content_header')
    <h1>Budget</h1>
@stop

@section('content')
@include('admin.massage')

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Email</th>
        <th scope="col">Name</th>
        <th scope="col">Set Date</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($Budget as $item)
        <tr>
            <td>
                {{ $sr++ }}
            </td>
            <td>
                {{ $item->amount }}
            </td>
            <td>
                {{ $item->user->name }}
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
@stop

@section('js')
    <script>
        $(document).ready(function() {
           $('#example').DataTable({
            });
        } );
        </script>
@stop
