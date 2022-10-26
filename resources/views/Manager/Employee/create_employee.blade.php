@extends('master')
@section('title','Add Employee')
@section('link','Add Employee')
@section('content')
<!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<div class="row">
<!-- left column -->
	<div class="col-md-6 offset-md-3">
	<!-- general form elements -->
	<div class="card card-primary">
	  <div class="card-header">
	    <h3 class="card-title">Employee Register</h3>
	  </div>
	  <!-- /.card-header -->
	  <!-- form start -->
	  <form role="form" method="post" action="{{route('store_employee')}}" enctype="multipart/form-data">
	  	@csrf
	    <div class="card-body">
	      <div class="form-group">
	        <label for="name">Name</label>
	        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Employee Name">
	      </div>
	      <div class="form-group">
	        <label for="phone">Contact</label>
	        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Employee Phone Number">
	      </div>
	      <div class="form-group">
	        <label for="address">Address</label>
	        <input type="text" class="form-control" name="address" id="address" placeholder="Enter Employee address">
	      </div>
	      <div class="form-group">
            <label for="photo">Photo</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                <label class="custom-file-label" for="photo">Employee Photo</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text" id="">Upload</span>
              </div>
            </div>
          </div>
	      <div class="form-group">
	      		<label>Employed Date:</label>

	      <div class="input-group">
	        <div class="input-group-prepend">
	          <span class="input-group-text">
	            <i class="far fa-calendar-alt"></i>
	          </span>
	        </div>
	        <input type="date" name="employed_date" class="form-control float-right">
	      </div>
	      <!-- /.input group -->
	    </div>
	    <div class="form-group">
            <label>Supervisor</label>
            <select class="custom-select" name="role_id"
            >
            	@foreach($roles as $role)
              	<option value="{{$role->id}}">{{$role->name}}</option>
              	@endforeach
            </select>
        </div>
	    <div class="form-group">
	        <label for="salary">Salary</label>
	        <input type="number" class="form-control" name="salary" id="salary" placeholder="Enter Employee Salary">
	      </div>
	    	<div class="form-group">
		        <label for="email">Email</label>
		        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Employee Email">
		      </div>
	    	<div class="form-group">
		        <label for="password">Password</label>
		        <input type="password" class="form-control" name="password" id="password" placeholder="password">
		      </div>
	    </div>
	    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
<!-- /.card -->
@endsection