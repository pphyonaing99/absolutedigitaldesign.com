@extends('master')
@section('title','Regional Warehouse List')
@section('link','Regional Warehouse List')
@section('content')
<style type="text/css">
  
  .card-style{
    border-radius: 50px;
  }
  img{
    border-radius: 50px 0 0 50px;
  }

</style>
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Regional Warehouse Lists</h3>
              	<!-- <button type="button" data-toggle="modal" data-target="#category" class="btn btn-primary shadow" style="border-radius: 50px;"><i class="fas fa-plus"></i> Add Regional Warehouse</button> -->
                <a href="{{route('add_regional')}}" class="btn btn-primary" style="border-radius: 50px;"><i class="fas fa-plus"></i>&nbsp;Add Regional Warehouse</a>
              </div>
            </div>
            <!-- /.card-header -->
            <!-- <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                  <th>Location</th>
                  	<th>Region</th>
                  	<th>Employee Name</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($regional_warehouses as $regional)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$regional->warehouse_name}}</td>
                    <td><iframe src="{{ $regional->location_address }}" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></td>
                  	<td>{{$regional->region}}</td>
                  	<td>{{$regional->employee->name}}</td>
                  </tr>

                  
                  @endforeach
                </tbody>
              </table>
            </div> -->

            <div class="row">
              @foreach($regional_warehouses as $regional)
                <div class="col-md-6">
                  <div class="card card-style m-3 text-white bg-info shadow" style="max-height: 180px;" >
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <img src="{{ 'image/'.$regional->employee->photo }}" width="180" height="180" style="cursor: pointer;" alt="...">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold" style="margin-left: 70px;">Regional Warehouse</h5>
                          <p class="card-text mt-1"><span class="ml-2">Warehouse Name</span> <span class="float-right"> {{ $regional->warehouse_name }} </span></p>
                          <p class="card-text mt-1"><span class="ml-2">Employee Name</span> <span class="float-right"> {{ $regional->employee->name }} </span></p>
                          <p class="card-text ml-2 mb-0"><small class="text-white">{{ $regional->region }}</small><i class="fas fa-map-marker float-right mt-2" data-toggle="modal" data-target="#map_{{ $regional->id }}" style="cursor: pointer;"></i></p>
                          <p class="card-text ml-2"><small class="text-white">Check Inventory</small><a href="{{route('regional_inventory',$regional->id)}}" class='text-white'><i class="fas fa-chevron-right float-right mt-2" style="cursor: pointer;"></i></a></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="map_{{ $regional->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-body text-center">

                        <iframe src="{{ $regional->location_address }}" width="750" height="450" frameborder="0" style="border:0;padding:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>

<!-- Add Regional Modal -->


<!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
    </div>
  </div>
</div> -->


<!-- End Regional Modal -->
<!--Add category Modal -->
  
  <div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Regional Warehouse Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">

          <!-- <form id="form">  -->
          <form action="{{route('store_regional_warehouse')}}" method="post">
          @csrf
            @if ($message = Session::get('success'))
                 <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                 </div>
                 <br>
            @endif
            <div class="form-group">
                <label for="message-text"  class="float-left">Warehouse Name:</label>
                <input type="text" class="form-control" id="warehouse_name" name="warehouse_name">
                <span class="text-danger">{{ $errors->first('warehouse_name') }}</span>
            </div>
            <div class="form-group">
                <label for="message-text"  class="float-left">Region:</label>
                <input type="text" class="form-control" id="region" name="region">
                <span class="text-danger">{{ $errors->first('warehouse_name') }}</span>
            </div>
            <div class="form-group">
                <label for="message-text"  class="float-left">Country:</label>
                <input type="text" class="form-control" id="country" name="country">
                <span class="text-danger">{{ $errors->first('country') }}</span>
            </div>
            <div class="form-group">
                <label for="message-text"  class="float-left">Location Address:</label>
                <textarea class="form-control" id="location_address" name="location_address"></textarea>
                <span class="text-danger">{{ $errors->first('location_address') }}</span>
            </div>
            <div class="form-group">
                <label for="message-text"  class="float-left">Area:</label>
                <input type="text" class="form-control" id="area" name="area">
                <span class="text-danger">{{ $errors->first('area') }}</span>
            </div>
            <div class="form-group">
                <label for="message-text"  class="float-left">Capacity:</label>
                <input type="text" class="form-control" id="capacity" name="capacity">
                <span class="text-danger">{{ $errors->first('capacity') }}</span>
            </div>
            <div class="form-group">
                <label for="message-text"  class="float-left">Employee:</label>
                <select class="form-control" name="employee_id">
                  @foreach($employees as $employee)
                  <option value="{{$employee->id}}">{{$employee->name}}</option>
                  @endforeach
                </select>
                <span class="text-danger">{{ $errors->first('employee') }}</span>
            </div>
            <div class="form-group">
            <label class="control-label">Project</label>
                <!-- <select class="" name="project_id">
                  @foreach($projects as $project)
                  <option value="{{$project->id}}">{{$project->project_name}}</option>
                  @endforeach
                </select> -->
                <select class="select2 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder=" Select" name="proj[]">
                        <option value="">Select</option>
                        @foreach($projects as $project)
                        <option value="{{$project->id}}">{{$project->project_name}}</option>
                        @endforeach
                </select>
                <span class="text-danger">{{ $errors->first('employee') }}</span>
            </div>
              <button type="submit" class="btn btn-primary float-right" value="Save">Save</button>
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
	
	$(".btn-submit").click(function(e){
        // alert("hollo");
        e.preventDefault();

        // var name = $("input[name=name]").val();

        // var description = $("textarea[name=description]").val();

        // var measuring_unit = $("input[name=measuring_unit]").val();

        $.ajax({

           type:'POST',

           url:'/ajaxCategory',

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

  $( document ).ready(function() {
    $(".select2").select2();
  });

</script>

@endsection