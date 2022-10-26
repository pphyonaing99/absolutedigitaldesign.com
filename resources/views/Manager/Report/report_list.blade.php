@extends('master')
@section('title','Category List')
@section('link','Category List')
@section('content')
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Category List</h3>
              	<button type="button" data-toggle="modal" data-target="#category" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                  	<th>Description</th>
                  	<th>Measuring Unit</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($report_tasks as $report)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$report->task->name}}</td>
                  	<td>{{$report->report_description}}</td>
                  	<td><embed src="{{'image/'.$report->photo}}" height="300" width="300" /></td>
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

<!--Add category Modal -->
  <div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Category Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">

        	<form method="POST" action="{{route('store_reported_task')}}" enctype="multipart/form-data">
        	    @csrf 
        		@if ($message = Session::get('success'))
	               <div class="alert alert-success alert-block">
	                  <button type="button" class="close" data-dismiss="alert">×</button>
	                  <strong>{{ $message }}</strong>
	               </div>
	               <br>
               @endif
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Report Description:</label>
		            <input type="text" class="form-control" id="name" name="report_description">
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Finiashed_date:</label>
		            <input type="date" class="form-control" id="measuring_unit" name="finished_date" id="recipient-name">
		            <span class="text-danger">{{ $errors->first('measuring_unit') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Finiashed_date:</label>
		            <select name="product_id" class="form-control">
		                @foreach($site_inventories as $item)
		                <option value="{{$item->product_id}}">{{ $item->name }}</option>
		                @endforeach
		            </select>
		            <span class="text-danger">{{ $errors->first('measuring_unit') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Finiashed_date:</label>
		            <select name="task_id" class="form-control">
		                @foreach($tasks as $task)
		                <option value="{{$task->id}}">{{ $task->task_name }}</option>
		                @endforeach
		            </select>
		            <span class="text-danger">{{ $errors->first('measuring_unit') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Stock Qty:</label>
		            <input type="text" class="form-control" id="stock_qty" name="stock_qty" id="recipient-name">
		            <span class="text-danger">{{ $errors->first('measuring_unit') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Stock Qty:</label>
		            <input type="file" class="form-control" id="stock_qty" name="photo" id="recipient-name">
		            <span class="text-danger">{{ $errors->first('measuring_unit') }}</span>
		        </div>
	            <input type="submit" name="btnsubmit" class="btn btn-primary float-right btn-submit" value="Create Category">
	        </form>

        </div>
      </div>
    </div>
  </div>
<!-- page script -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

@endsection