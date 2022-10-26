@extends('master')
@section('title','Add Project')
@section('link','Add Project')
@section('content')

<div class="row">
<!-- left column -->
	<div class="col-md-6 offset-md-3">
	<!-- general form elements -->
	<div class="card card-primary">
	  	<div class="card-header">
	    	<h3 class="card-title">Project Register</h3>
		</div>
	  <!-- /.card-header -->
	  <!-- form start -->
	  	<form role="form" method="post" action="{{route('store_project')}}">
		  	@csrf
		    <div class="card-body">
			    <div class="form-group">
			        <label for="project_name">Project Name</label>
			        <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Enter Project Name">
			    </div>
			    <div class="form-group">
			        <label for="customer">Customer</label>
			        <input type="text" class="form-control" name="customer" id="customer" placeholder="Enter Customer">
			    </div>
			    <div class="form-group">
			        <label for="location">Location</label>
			        <input type="text" class="form-control" name="location" id="location" placeholder="Enter Location of Project">
			    </div>
			    <div class="form-group">
		            <label for="description">Description</label>
		            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description"></textarea>
		        </div>
			    <div class="form-group">
			      		<label>Start Date:</label>

			    <div class="input-group">
			        <div class="input-group-prepend">
			          <span class="input-group-text">
			            <i class="far fa-calendar-alt"></i>
			          </span>
			        </div>
			        <input type="date" name="start_date" class="form-control float-right">
			    </div>
			      <!-- /.input group -->
			    </div>
		    	<div class="form-group">
		      		<label>End Date:</label>

				    <div class="input-group">
				        <div class="input-group-prepend">
				          <span class="input-group-text">
				            <i class="far fa-calendar-alt"></i>
				          </span>
				        </div>
				        <input type="date" name="end_date" class="form-control float-right">
				    </div>
		      <!-- /.input group -->
		    	</div>
		    </div>
		    <!-- /.card-body -->

	    	<div class="card-footer">
		      <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
  		</form>
	</div>
</div>
</div>
<!-- /.card -->
@endsection