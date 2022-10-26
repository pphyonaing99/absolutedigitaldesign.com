@extends('master')
@section('title','Purchase Order')
@section('link','Purchase Order')
@section('content')
<!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<div class="row">
<!-- left column -->
	<div class="col-md-6 offset-md-3">
	<!-- general form elements -->
	<div class="card card-primary">
	  <div class="card-header">
	    <h3 class="card-title">Purchase Order Register</h3>
	  </div>
	  <!-- /.card-header -->
	  <!-- form start -->
	  <form role="form" method="post" action="{{route('store_product')}}">
	  	@csrf
	    <div class="card-body">
	      <div class="form-group">
	        <label for="project_name">Project Name</label>
	        <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Customer Project Name">
	      </div>
	      <div class="form-group">
	        <label for="customer_name">Customer Name</label>
	        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Customer Name">
	      </div>
	      <div class="form-group">
	        <label for="phone">Contact</label>
	        <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter Customer Phone Number">
	      </div>
	      <div class="form-group">
	        <label for="quantity">Product</label>
	        <input type="number" class="form-control" name="stock_qty" id="quantity" placeholder="Enter Your Product Quantity">
	      </div>
	      <div class="form-group">
	        <label for="reorder_quantity">Reorder Quantity</label>
	        <input type="number" class="form-control" name="reorder_quantity" id="reorder_quantity" placeholder="Enter Your Product Quantity">
	      </div>
	      <div class="form-group">
	        <label for="measuring_unit">Measuring Unit</label>
	        <input type="number" class="form-control" name="measuring_unit" id="measuring_unit" placeholder="Enter Measuring Unit">
	      </div>
	      <div class="form-group">
	        <label for="purchase_price">Purchase Price</label>
	        <input type="number" class="form-control" name="purchase_price" id="purchase_price" placeholder="Enter Purchase Price">
	      </div>
	      <div class="form-group">
	        <label for="selling_price">Selling Price</label>
	        <input type="number" class="form-control" name="selling_price" id="selling_price" placeholder="Enter Selling Price">
	      </div>
	      <div class="form-group">
	        <label for="location">Location</label>
	        <input type="text" class="form-control" name="location" id="location" placeholder="Enter Your warehouse Location">
	      </div>
	      <div class="form-group">
	      <label>Date range:</label>

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