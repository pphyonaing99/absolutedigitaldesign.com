@extends('master')
@section('title','Project List')
@section('link','Project List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Project List</h3>
              <a href="{{route('create_project')}}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Project</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Project Name</th>
                	<th>Description</th>
                	<th>Start Date</th>
                	<th>End Date</th>
                	<th>Add Phase</th>
                	<th>Phase List</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($projects as $project)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$project->project_name}}</td>
                  	<td>{{$project->description}}</td>
                  	<td>{{$project->start_date}}</td>
                  	<td>{{$project->end_date}}</td>
                  	<td><a href="#" data-toggle="modal" data-target="#project_{{$project->id}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Phase</a></td>
                  	<td><a href="{{route('check_phase_list',$project->id)}}" class="btn btn-primary"><i class="fas fa-align-justify"></i>  Check Phase List</a></td>
                  </tr>

                  <!-- Modal -->
					<div class="modal fade" id="project_{{$project->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div class="card card-primary">
							  	<div class="card-header">
							    	<h3 class="card-title">Phase Register</h3>
								</div>
							  <!-- /.card-header -->
							  <!-- form start -->
							  	<form method="post" action="{{route('store_phase_now')}}">
								  	@csrf
								  	<input type="hidden" name="project_id" value="{{$project->id}}">
								    <div class="card-body">
									    <div class="form-group">
									        <label for="phase_name">Phase Name</label>
									        <input type="text" class="form-control" name="phase_name" id="phase_name" placeholder="Enter Phase Name">
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
								    	<div class="form-group">
					                        <label>Supervisor</label>
					                        <select class="custom-select" name="user_id"
					                        >
					                        	@foreach($users as $user)
					                        	@if($user->hasrole('Site Supervisor'))
					                          	<option value="{{$user->id}}">{{$user->name}}</option>
					                          	@endif
					                          	@endforeach
					                        </select>
					                      </div>
					                    </div>
								    </div>
								    <!-- /.card-body -->

							    	<div class="card-footer">
								      <button type="submit" class="btn btn-primary">Submit</button>
								    </div>
						  		</form>
							</div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="button" class="btn btn-primary">Save changes</button>
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