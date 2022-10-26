@extends('master')
@section('title','Document List')
@section('link','Document List')
@section('content')
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Document List</h3>
              	<button type="button" data-toggle="modal" data-target="#document" class="btn btn-primary"><i class="fas fa-plus"></i> Add Document</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                  	<th>Description</th>
                  	<th>Phase</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @if(count($documents) == 0)
                  <tr>
                    <td colspan="4" class="text-center">There is no Data!</td>
                  </tr>
                  @else
                  @foreach($documents as $document)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$document->name}}</td>
                  	<td>{{$document->description}}</td>
                  	<td>{{$document->phase->phase_name}}</td>
                  </tr>
                  @endforeach
                  @endif
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
  <div class="modal fade" id="document" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Document Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">

          <form method="post" action="{{route('store-document')}}"> 
            @csrf
        		@if ($message = Session::get('success'))
	               <div class="alert alert-success alert-block">
	                  <button type="button" class="close" data-dismiss="alert">×</button>
	                  <strong>{{ $message }}</strong>
	               </div>
	               <br>
               @endif
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Name:</label>
		            <input type="text" class="form-control" id="name" name="name">
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
 		            <label for="message-text"  class="float-left">Description:</label>
		            <textarea class="form-control" id="description" name="description"></textarea>
		            <span class="text-danger">{{ $errors->first('description') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Project:</label>
		            <select name="project_id" class="form-control" id="project_id" onchange="getPhaseList(this.value)">
                        <option value="">Select Project</option>
                        @foreach ($projects as $project)
                            <option value="{{$project->id}}">{{$project->project_name}}</option>
                        @endforeach
                    </select>
		            <span class="text-danger">{{ $errors->first('measuring_unit') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Phase:</label>
		            <select name="phase_id" class="form-control" id="phase_id">
                    </select>
		            <span class="text-danger">{{ $errors->first('measuring_unit') }}</span>
		        </div>
	            <input type="submit" name="btnsubmit" class="btn btn-primary float-right" value="Create Document">
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
<script type="text/javascript">
	function getPhaseList(project_id){
        $.ajax({

            type:'POST',

            url:'/ajaxPhase',

            data:{
                "_token":"{{csrf_token()}}",
                "id":project_id,
            },

            success:function(data){
                $.each(data,function(i,phase){
                    $('#phase_id').append($('<option>').attr('value',phase.id).text(phase.phase_name));
                })
            }

        });
    }

</script>

@endsection