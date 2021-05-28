@extends('adminlte::page')

@section('title', config('adminlte.title').' Users')
{{-- config('adminlte.title_prefix', '')) --}}
@section('content_header')
    <h1>Budges</h1>
@stop

@section('content')
@include('admin.massage')




<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('Budges.create') }}" class="btn btn-primary float-right">
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Depend</th>
        <th scope="col">Img</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($badges as $item)
        <tr>
            <td>
                {{ $loop->index+1 }}
            </td>
            <td title="{{ $item->description }}">
                {{ $item->name }}
            </td>
            <td title="{{ $item->description }}">
                <span class="badge badge-success" style="text-transform: uppercase">{{ $item->depend }}</span>
            </td>
            <td>
                <img src="{{ asset($item->img) }}" alt="" width="50px">
            </td>
            <td>
                <form action="{{route('Budges.destroy',$item->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                        <a href="{{ route('Budges.edit',$item->id) }}" class="btn btn-primary"> <i class="fa fa-edit"></i></a>
                        <a href="{{ route('Budges.Question',$item->id) }}" class="btn bg-gray"> <i class="fa fa-question-circle"></i></a>
                    <button class='btn btn-danger' type="submit"><i class="fa fa-trash"></i></button>
                   </form>
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
