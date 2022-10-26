@extends('master')
@section('title','Zone List')
@section('link','Zone List')
@section('content')
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Zone List</h3>
              	<button type="button" data-toggle="modal" data-target="#zone" class="btn btn-primary"><i class="fas fa-plus"></i> Add Zone</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                  	<th>Description</th>
                  	<th>Action</th>
                  	<th>Action</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($zones as $zone)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$zone->name}}</td>
                  	<td>{{$zone->description}}</td>
                  	<td><a href="#" data-toggle="modal" data-target="#zone{{$zone->id}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Shelve</a></td>
                  	<td><a href="{{route('shelve',$zone->id)}}" class="btn btn-primary">Check Shelve List</a></td>
                  	
                  	<!-- Modal -->
					<div class="modal fade" id="zone{{$zone->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-body">
					        <div class="card card-primary">
							  	<div class="card-header">
							    	<h3 class="card-title">Shelve Register</h3>
								</div>
							  <!-- /.card-header -->
							  <!-- form start -->
							  	<form role="form" method="post" action="{{route('store_shelve')}}">
								  	@csrf
								  	<input type="hidden" name="zone_id" value="{{$zone->id}}">
								    <div class="card-body">
									    <div class="form-group">
									        <label for="name">Shelve Name</label>
									        <input type="text" class="form-control" name="shelve_name" id="name" placeholder="Enter Shelve Name">
									    </div>
									    <div class="form-group">
								            <label for="description">Description</label>
								            <textarea class="form-control" name="shelve_description" id="description" rows="3" placeholder="Enter description"></textarea>
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
					    </div>
					  </div>
					</div>
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
  <div class="modal fade" id="zone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Zone Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">

        	<form id="form"> 
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
	            <input type="submit" name="btnsubmit" class="btn btn-primary float-right btn-submit" value="Create Zone">
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

        e.preventDefault();

        var name = $("input[name=name]").val();
        console.log(name)

        var description = $("textarea[name=description]").val();

        $.ajax({

           type:'POST',

           url:'/ajaxStoreZone',

           data:{
           	"_token":"{{csrf_token()}}",
           	"name":name, 
           	"description":description, 
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