@extends('master')
@section('title','Handtool List')
@section('link','Handtool List')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<div class='row'>
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h1>Handtool Assignment</h1>
            </div>
            <div class="card-body">
                <form id="form" action="{{route('assign-handtool')}}" method="post"> 
                @csrf
            		@if ($message = Session::get('success'))
    	               <div class="alert alert-success alert-block">
    	                  <button type="button" class="close" data-dismiss="alert">×</button>
    	                  <strong>{{ $message }}</strong>
    	               </div>
    	               <br>
                   @endif
    		        <div class="form-group" style="display:flex;flex-direction:column;">
    		            <label for="message-text"  class="float-left" style="align-self:flex-start;">Project:</label>
    		            <select name="project_id" class="select2" onchange="getPhaseList(this.value)">
    		                <option>Select Project</option>
    		                @foreach($projects as $project)
    		                <option value="{{$project->id}}">{{$project->project_name}}</option>
    		                @endforeach
    		            </select>
    		            <span class="text-danger">{{ $errors->first('name') }}</span>
    		        </div>
    		        <div class="form-group" style="display:flex;flex-direction:column;">
    		            <label for="message-text"  class="float-left" style="align-self:flex-start;">Phase:</label>
    		            <select name="phase_id" class="select2" id="phase" onchange="getSiteEngineer(this.value)">
    		                <option>Select Phase</option>
    		            </select>
    		            <span class="text-danger">{{ $errors->first('name') }}</span>
    		        </div>
    		        <div class="form-group" style="display:flex;flex-direction:column;">
    		            <label for="message-text"  class="float-left" style="align-self:flex-start;">Site Engineer:</label>
    		            <select name="user_id" class="select2" id="user">
    		            </select>
    		            <span class="text-danger">{{ $errors->first('name') }}</span>
    		        </div>
    		        <div class="form-group" style="display:flex;flex-direction:column;">
    		            <label for="message-text"  class="float-left" style="align-self:flex-start;">Handtool:</label>
    		            <select name="handtool_id[]" class="select2" multiple="multiple" onchange="getPhaseList(this.value)">
    		                <option>Select Hantool</option>
    		                @foreach($handtools as $handtool)
    		                <option value="{{$handtool->id}}">{{$handtool->name}}</option>
    		                @endforeach
    		            </select>
    		            <span class="text-danger">{{ $errors->first('name') }}</span>
    		        </div>
    	            <input type="submit" name="btnsubmit" class="btn btn-primary float-right" value="Assign Handtool">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
    
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