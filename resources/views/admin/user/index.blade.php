@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>User</h1>
@stop

@section('content')
@include('admin.massage')

<table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Email</th>
        <th scope="col">Photo</th>
        <th scope="col">Name</th>
        <th scope="col">Join Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp
        @foreach ($user as $item)
        <tr>
            <td>
                {{ $sr++ }}
            </td>
            <td>
                {{ $item->email }}
            </td>
            <td>
                <img src="{{ asset('/user/'.$item->photo) }}" width='30px'>
            </td>
            <td>
                {{ $item->name }}
            </td>
            <td>
                {{ $item->created_at->diffForHumans() }}
                {{-- {{ ->diffInDays(Carbon\Carbon::now()) }} --}}
            </td>
            <td>
                <a href="{{ route('User-Edit',$item->id) }}" class="btn bg-orange"> <i class="fa fa-edit"></i> </a>
                <a href="{{ route('User-Child-List',$item->id) }}" class="btn bg-maroon"> <i class="fas fa-child"></i></a>
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
                "columnDefs": [
                    { "orderable": false, "targets": [4] },
                ]
            });

        } );
        </script>
@stop
