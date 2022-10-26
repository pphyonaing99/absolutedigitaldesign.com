@extends('master')
@section('title','Create Equipment')
@section('link','Create Equipment')
@section('content')
<!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<div class="row">
<!-- left column -->
	<div class="col-md-6 offset-md-3">
	<!-- general form elements -->
	<div class="card card-primary">
	  <div class="card-header">
	    <h3 class="card-title">Equipment Register</h3>
	  </div>
	  <!-- /.card-header -->
	  <!-- form start -->
	  <form role="form" method="post" action="{{route('store_equipment')}}">
	  	@csrf
	    <div class="card-body">
	      <div class="form-group">
	        <label for="serial_number">Serial Number</label>
	        <input type="text" class="form-control" name="serial_number" id="serial_number" placeholder="Enter Serial Number">
	      </div>
	      <div class="form-group">
	        <label for="name">Name</label>
	        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Equipment Name">
	      </div>
	      <div class="form-group">
	        <label for="brand_name">Brand Name</label>
	        <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter Your Brand Name">
	      </div>
	      <div class="form-group">
	        <label for="quantity">Quantity</label>
	        <input type="number" class="form-control" name="stock_qty" id="quantity" placeholder="Enter Your Product Quantity">
	      </div>
	      <div class="form-group">
	      <label>Register Date:</label>

	      <div class="input-group">
	        <div class="input-group-prepend">
	          <span class="input-group-text">
	            <i class="far fa-calendar-alt"></i>
	          </span>
	        </div>
	        <input type="date" name="reg_date" class="form-control float-right">
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
<!-- /.card -->
@endsection