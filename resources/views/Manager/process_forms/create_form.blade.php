@extends('master')
@section('title','Add Form')
@section('link','Add Form')
@section('content')
<!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<div class="row">
<!-- left column -->
	<div class="col-md-6 offset-md-3">
	<!-- general form elements -->
	<div class="card card-primary">
	  <div class="card-header">
	    <h3 class="card-title">Form Register</h3>
	  </div>
	  <!-- /.card-header -->
	  <!-- form start -->
	  <form role="form" method="post" action="{{route('store_form')}}" enctype="multipart/form-data">
	  	@csrf
	    <div class="card-body">
	      <div class="form-group">
	        <label for="name">Form Name</label>
	        <input type="text" class="form-control" name="form_name" id="name" placeholder="eg. Good Receive Note">
	      </div>
          <div class="form-group">
	        <label for="address">Prefix</label>
	        <input type="text" class="form-control" name="prefix" id="prefix" placeholder="eg. GRN">
	      </div>
	      <div class="form-group">
            <label>Approve By</label>
            
            <select class="custom-select" name="approve_role_id">
            <option>Select Role</option>
            	@foreach($roles as $role)
              	<option value="{{$role->id}}">{{$role->name}}</option>
              	@endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Check By</label>
            
            <select class="custom-select" name="check_role_id">
            <option>Select Role</option>
            	@foreach($roles as $role)
              	<option value="{{$role->id}}">{{$role->name}}</option>
              	@endforeach
            </select>
        </div>

	      
	      
	  
	    <div class="form-group">
            <label>Prepare By</label>
            
            <select class="custom-select" name="prepare_role_id">
                <option>Select Role</option>
            	@foreach($roles as $role)
              	<option value="{{$role->id}}">{{$role->name}}</option>
              	@endforeach
            </select>
        </div>
	    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary offset-md-11">Submit</button>
    </div>
  </form>
</div>
<!-- /.card -->
@endsection