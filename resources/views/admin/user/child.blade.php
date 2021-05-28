@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>{{ ucfirst($user->name) }} of Chiled List</h1>
@stop

@section('content')
@include('admin.massage')

  <table id="example" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Child Name</th>
        <th scope="col">Age</th>
        <th scope="col">Img</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sr=1;
        @endphp

        @foreach ($user->Childe as $item)
        <tr>
            <td>{{ $sr++ }} </td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->age }}</td>
            <td>
                <img src="{{ $item->img }}" width='30px'>
            </td>
            <td>
                <a href="{{ route('Childe-Teeth',$item->id) }}" class="btn bg-indigo"><i class="fas fa-history"></i></a>
                <a href="{{ route('Childe-invest',$item->id) }}" class="btn bg-maroon"><i class="fas fa-wallet"></i></a>
                <a href="{{ route('Childe-Cashout',$item->id) }}" class="btn bg-teal"><i class="fas fa-coins"></i></a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

  <!-- Modal -->
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
