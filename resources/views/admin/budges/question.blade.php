@extends('adminlte::page')

@section('title', config('adminlte.title').' Users')
{{-- config('adminlte.title_prefix', '')) --}}
@section('content_header')
    <h1>Budges Question</h1>
@stop

@section('content')
@include('admin.massage')

<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('Budges.Question.Add',$badges->id) }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i></a>
    </div>
</div>

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Question</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($question as $item)
        <tr>
            <td>
                {{ $sr++ }}
            </td>
            <td>
                {{ $item->question }}
            </td>
            <td>
                <a href="{{ route('Budges.Question.Edit',$item->id) }}" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                </a>

                <a href="{{ route('Budges.Question.Delete',$item->id) }}" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                </a>
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
