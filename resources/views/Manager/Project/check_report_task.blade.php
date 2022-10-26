@extends('master')
@section('title','Report Task List')
@section('link','Report Task List')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">Report Task</h1>
            </div>
              <!-- /.card-header -->
      		<div class="card-body">

	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Project Name</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
	              	<div class="col-md-6">
	                	<h4>{{$project->project_name}}</h4>
	              	</div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Phase Name</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
	              	<div class="col-md-6">
	                	<h4>{{$phase->phase_name}}</h4>
	              	</div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Task Name</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
	              	<div class="col-md-6">
	                	<h4>{{$task->task_name}}</h4>
	              	</div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Finished Product</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
	              	<div class="col-md-6">
	              	    @if($report_task->product_id != 0)
	                	<h4>{{$report_task->product->name}}</h4>
	                	@else
	                	<h4>No Product Report</h4>
	                	@endif
	              	</div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Finished Date</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
	              	<div class="col-md-6">
	                	<h4>{{$report_task->finished_date}}</h4>
	              	</div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Report</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
	              	<div class="col-md-6">
	                	<h4>{{$report_task->report_description}}</h4>
	              	</div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Photo</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
	              	<div class="col-md-6">
	                	<h4><img src="{{'/image/'.$report_task->photo}}" data-toggle="modal" data-target="#exampleModal" width="50" height="50" style="cursor: pointer;"></h4>
	              	</div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Checked By</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
		            <div class="col-md-6">
		                <h4>{{$report_task->checked_by}}</h4>
		            </div>
	            </div>
	            <div class="row m-3">
	              	<div class="col-md-5">
	                	<h4>Task Status</h4>
	              	</div>
	              	<div class="col-md-1">
	                	:
	              	</div>
		            <div class="col-md-6">
		            	@if($report_task->task_status == 0)
		                	<h4><span class="badge badge-success">No Finished</span></h4>
		                @else
		                	<h4><span class="badge badge-success">Finished</span></h4>
		                @endif
		            </div>
	            </div>
          	</div>
      	</div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- page script -->

<!-- Image Modal -- >
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <img src="{{'/image/'.$report_task->photo}}" width="1100" height="500">
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
    $("#example1").DataTable();
</script>
@endsection