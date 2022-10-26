@extends('master')
@section('title','Handtool List')
@section('link','Handtool List')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Handtool List</h3>
              	<button type="button" data-toggle="modal" data-target="#handtool" class="btn btn-primary"><i class="fas fa-plus"></i> Add Handtool</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>Serial No</th>
                	<th>Name</th>
                  	<th>Model</th>
                  	<th>Brand</th>
                  	<th>Location</th>
                  	<th>Action</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($handtools as $handtool)
                  <tr class="text-center">  
                  	<td>{{$handtool->serial_number}}</td>
                  	<td>{{$handtool->name}}</td>
                  	<td>{{$handtool->model}}</td>
                  	<td>{{$handtool->brand->name}}</td>
                  	<td>{{$handtool->shelve->name}}</td>
                  	@if($handtool->status == 0)
                  	<td><span class="badge badge-success p-1"> Active</span></td>
                  	@else
                  	<td><span class="badge badge-danger p-1"><i class="fa fa-exclamation"></i> Busy</span></td>
                  	@endif
                  </tr>                       
                  
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>

<!--Add Handtool Modal -->
  <div class="modal fade" id="handtool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">HandTool Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">

        	<form id="form" action="{{route('store-handtool')}}" method="post"> 
        	@csrf
        		@if ($message = Session::get('success'))
	               <div class="alert alert-success alert-block">
	                  <button type="button" class="close" data-dismiss="alert">×</button>
	                  <strong>{{ $message }}</strong>
	               </div>
	               <br>
               @endif
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Category:</label>
		            <select name="category_id" class="form-control">
		                @foreach($categories as $category)
		                <option value="{{$category->id}}">{{$category->name}}</option>
		                @endforeach
		            </select>
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Name:</label>
		            <input type="text" class="form-control" id="name" name="name">
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Brand:</label>
		            <select name="brand_id" class="form-control">
		                @foreach($brands as $brand)
		                <option value="{{$brand->id}}">{{$brand->name}}</option>
		                @endforeach
		            </select>
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Supplier:</label>
		            <select name="supplier_id" class="form-control">
		                @foreach($suppliers as $supplier)
		                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
		                @endforeach
		            </select>
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="model"  class="float-left">Model:</label>
		            <input type="text" class="form-control" id="model" name="model">
		            <span class="text-danger">{{ $errors->first('model') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="serial_number"  class="float-left">Serial Number:</label>
		            <input type="text" class="form-control" id="serial_number" name="serial_number">
		            <span class="text-danger">{{ $errors->first('serial_number') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="purchase_price"  class="float-left">Purchase Price:</label>
		            <input type="number" class="form-control" id="purchase_price" name="purchase_price">
		            <span class="text-danger">{{ $errors->first('purchase_price') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="selling_price"  class="float-left">Selling Price:</label>
		            <input type="number" class="form-control" id="selling_price" name="selling_price">
		            <span class="text-danger">{{ $errors->first('selling_price') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="purchase_date"  class="float-left">Purchase Date:</label>
		            <input type="date" class="form-control" id="purchase_date" name="purchase_date">
		            <span class="text-danger">{{ $errors->first('purchase_date') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="shelve_id"  class="float-left">Shelve:</label>
		            <select name="shelve_id" class="form-control">
		                @foreach($shelves as $shelve)
		                <option value="{{$shelve->id}}">{{$shelve->name}}</option>
		                @endforeach
		            </select>
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
 		            <label for="message-text"  class="float-left">Description:</label>
		            <textarea class="form-control" id="description" name="description"></textarea>
		            <span class="text-danger">{{ $errors->first('description') }}</span>
		        </div>
	            <input type="submit" name="btnsubmit" class="btn btn-primary float-right" value="Add Handtool">
	        </form>

        </div>
      </div>
    </div>
  </div>

@endsection