@extends('master')
@section('title','Phase List')
@section('link','Phase List')
@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Phase List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead class="text-center">
            	<th>#</th>
				<th>Phase id</th>
            	<th>Phase Name</th>
            	<th>Description</th>
            	<th>Start Date</th>
            	<th>End Date</th>
            	<th>Add Phase</th>
            	<th>Phase List</th>
            	<th>Document List</th>
            </thead>
            <tbody>
              <?php $j = 1;?>
              @foreach($phases as $phase)
              <tr class="text-center">
			  <td>{{$phase->id}}</td>
              	<td>{{$j++}}</td>
              	<td>{{$phase->phase_name}}</td>
              	<td>{{$phase->description}}</td>
              	<td>{{$phase->start_date}}</td>
              	<td>{{$phase->end_date}}</td>
              	<td><a href="#" data-toggle="modal" data-target="#phase_{{$phase->id}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Task</a></td>
              	<td><a href="{{route('check_detail',$phase->id)}}"><button class="btn btn-primary"><i class="fas fa-align-justify"></i> Check Task List</button></a></td>
              	<td><button  data-toggle="modal" data-target="#document_{{$phase->id}}" class="btn btn-primary"><i class="fas fa-align-justify"></i> Check Document List</button></td>
              </tr>

              <!-- Task Register Modal -->
				<div class="modal fade" id="phase_{{$phase->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-body">
				        <div class="card card-primary">
						  	<div class="card-header">
						    	<h3 class="card-title">Task Register</h3>
							</div>
						  <!-- /.card-header -->
						  <!-- form start -->
						  	<form role="form" method="post" action="{{route('store_task')}}">
							  	@csrf
							  	<input type="hidden" name="phase_id" value="{{$phase->id}}">
							  	<input type="hidden" name="project_id" value="{{$phase->project_id}}">
							    <div class="card-body">
								    <div class="form-group">
								        <label for="task_name">Task Name</label>
								        <input type="text" class="form-control" name="task_name" id="task_name" placeholder="Enter Task Name">
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
				  </div>
				</div>

				<!-- Task Check Modal -->
				<div class="modal fade" id="document_{{$phase->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-body">
				        <div class="row">
						    <div class="col-12">
						      <div class="card">
						        <div class="card-header">
						          <h3 class="card-title">Document List</h3>
						        </div>
						        <!-- /.card-header -->
						        <div class="card-body">
						        	<div class="row text-center mb-4 bg-dark p-2">
						        		<div class="col-md-1">
						        			#
						        		</div>
						        		<div class="col-md-5">
						        			Name
						        		</div>
						        		<div class="col-md-6">
						        			Description
						        		</div>
						        	</div>
						        	<?php $i = 1;?>
						        	@foreach($documents as $document)
						        	@if($document->phase_id == $phase->id)
							        	<div class="row text-center mb-4">
							        		<div class="col-md-1">
							        			{{$i++}}
							        		</div>
							        		<div class="col-md-5">
							        			{{$document->name}}
							        		</div>
							        		<div class="col-md-6">
							        			{{$document->description}}
							        		</div>
							        	</div><hr>
							        @endif
						        	@endforeach
						        </div>
						        <!-- /.card-body -->
						      </div>
						      <!-- /.card -->
						    </div>
						    <!-- /.col -->
						</div>
				      </div>
				    </div>
				  </div>
				</div>

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
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
</script>
@endsection