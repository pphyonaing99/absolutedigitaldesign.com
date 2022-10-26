@extends('master')
@section('title','Return Handtool List')
@section('link','Return Handtool List')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Return Handtool List</h3>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>Project</th>
                	<th>Phase</th>
                  	<th>Site Engineer</th>
                  	<th>Return Date</th>
                  	<th>Detail</th>
                  	<th>Return Qty</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($handtool_assigns as $handtool)
                  <tr class="text-center">  
                  	<td>{{$handtool->phase->project->project_name}}</td>
                  	<td>{{$handtool->phase->phase_name}}</td>
                  	<td>{{$handtool->user->name}}</td>
                  	<td>{{date('d-m-Y',strtotime($handtool->return_date))}}</td>
                  	<td><button type="button" data-toggle="modal" data-target="#detail_{{$handtool->id}}" class="btn btn-primary">Details</button></button></td>
                  	@if($handtool->status == 0)
                  	<td><span class="badge badge-warning p-1"> {{$handtool->returned_qty}}</span></td>
                  	@else
                  	<td><span class="badge badge-success p-1">All Returned</span></td>
                  	@endif
                  </tr>
                    
                    <!--Assign Handtool Modal -->
                      <div class="modal fade" id="detail_{{$handtool->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">HandTool Accept</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body text-center">
                                
                            	<form>
                            	@csrf
                            	    <input type="hidden" value="{{$handtool->id}}" name="handtool_assign_id" id="handtool_assign_id" >
                            		@if ($message = Session::get('success'))
                    	               <div class="alert alert-success alert-block">
                    	                  <button type="button" class="close" data-dismiss="alert">×</button>
                    	                  <strong>{{ $message }}</strong>
                    	               </div>
                    	               <br>
                                   @endif
                                   <div class="row">
                                       <div class="col-md-3">
                                           <label>Project : </label>
                                       </div>
                                        <div class="col-md-3">
                                            <span>{{$handtool->phase->project->project_name}}</span>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-3">
                                            <label>Phase : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <span>{{$handtool->phase->phase_name}}</span>
                                        </div>
                                   </div>
                                   <div class="row">
                                       <div class="col-md-3">
                                            <label>Site Engineer : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <span>{{$handtool->user->name}}</span>
                                        </div>
                                   </div>
                                   <div class="d-flex justify-content-around bg-dark text-white">
                                       <p class="m-2">Name</p>
                                       <p class="m-2">Serial No</p>
                                       <p class="m-2">Action</p>
                                   </div>
                                  
                                    @foreach($handtool_lists as $tool_list)
                                    @if($tool_list->handtool_assign_id == $handtool->id)
                                    @foreach($handtools as $tool)
                                    @if($tool->id == $tool_list->handtool_id)
                                    <div class="d-flex justify-content-between" style="border:1px solid #eee;">
                                       <p class="m-2" flex-grow:1;>{{$tool->name}}</p>
                                       <p class="m-2" flex-grow:1;>{{$tool->serial_number}}</p>
                                       @if($tool_list->status == 0)
                                       <p class="m-2" flex-grow:1;><a href="#" class="btn btn-outline-primary" onclick="acceptHandtool({{$tool->id}},{{$handtool->id}})">Accept</a></p>
                                        @else
                                        <span class="badge badge-success align-self-center">Accepted</span>
                                        @endif
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                    	        </form>
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
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    
    function acceptHandtool(handtool_id,handtool_assign_id){
        $.ajax({

           type:'POST',

           url:'/acceptHandtool',

           data:{
           	"_token":"{{csrf_token()}}",
           	"handtool_id":handtool_id, 
           	"handtool_assign_id":handtool_assign_id,
           },

           success:function(data){
           	
           		swal({

             		title:"Success!",
             		text:"Successfully Accepted",
             		icon:"success",
             	})

             	setTimeout(function(){
             		window.location.reload();
             	},1000);

           }

        });
    }
    
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
           	    $('#phase').append($('<option>').attr('value',phase.id).text(phase.phase_name));
           	})

           }

        });
    }
    
    function getSiteEngineer(phase_id){
        $.ajax({

           type:'POST',

           url:'/getSiteEngineer',

           data:{
           	"_token":"{{csrf_token()}}",
           	"phase_id":phase_id, 
           },

           success:function(data){
           	$('#user').append($('<option>').attr('value',data.id).text(data.name));

           }

        });
    }
	
	$(".btn-submit").click(function(e){

        e.preventDefault();

        var name = $("input[name=name]").val();
        var category_id = $("input[name=category_id]").val();
        var brand_id = $("input[name=brand_id]").val();
        var supplier_id = $("input[name=supplier_id]").val();
        var model = $("input[name=model]").val();
        var serial_number = $("input[name=model]").val();

        var description = $("textarea[name=description]").val();

        var measuring_unit = $("input[name=measuring_unit]").val();

        $.ajax({

           type:'POST',

           url:'/ajaxHandtool',

           data:{
           	"_token":"{{csrf_token()}}",
           	"name":name, 
           	"description":description, 
           	"measuring_unit":measuring_unit,
           },

           success:function(data){
           	
           		swal({

             		title:"Success!",
             		text:"You Have Successfully Added Category",
             		icon:"success",
             	})

             	setTimeout(function(){
             		window.location.reload();
             	},1000);

           }

        });
	});

</script>

@endsection