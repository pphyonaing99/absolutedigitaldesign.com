@extends('master')
@section('title','Discount List')
@section('link','Discount List')
@section('content')
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Discount List</h3>
              	<button type="button" data-toggle="modal" data-target="#discount" class="btn btn-primary"><i class="fas fa-plus"></i> Add Discount</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                  	<th>Description</th>
                  	<th>Discount Percent</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($discount_types as $dicount)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$dicount->name}}</td>
                  	<td>{{$dicount->description}}</td>
                  	<td>{{$dicount->discount_percent}}</td>
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
  <div class="modal fade" id="discount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Category Form</h5>
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
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Discount Percent:</label>
		            <input type="text" class="form-control" id="discount_percent" name="discount_percent" id="recipient-name">
		            <span class="text-danger">{{ $errors->first('discount_percent') }}</span>
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
<script type="text/javascript">
	
	$(".btn-submit").click(function(e){

        e.preventDefault();

        var name = $("input[name=name]").val();

        var description = $("textarea[name=description]").val();

        var discount_percent = $("input[name=discount_percent]").val();
        
        $.ajax({

           type:'POST',

           url:'/ajaxDiscountType',

           data:{
           	"_token":"{{csrf_token()}}",
           	"name":name, 
           	"description":description, 
           	"discount_percent":discount_percent,
           },

           success:function(data){
           	
           		swal({

             		title:"Success!",
             		text:"You Have Successfully Added Dicount",
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