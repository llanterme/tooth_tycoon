@if(Session::has('message'))
<div class="col-sm-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h6><i class="icon fa fa-check"></i> Success !</h6>
        {{ Session::get('message') }}
    </div>
</div>
@endif

@if(Session::has('error'))
<div class="col-sm-12">
    <div class="alert  alert-danger alert-dismissible">
      <span class="badge badge-pill badge-danger">Error</span>  {{ Session::get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        @foreach ($errors->all() as $error)
            {{ $error }} <br>
        @endforeach
    </div>
@endif




