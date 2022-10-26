@extends('master')
@section('title','Supplier List')
@section('link','Supplier List')
@section('content')
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Supplier List</h3>
              	<button type="button" data-toggle="modal" data-target="#supplier" class="btn btn-primary"><i class="fas fa-plus"></i> Add Supplier</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                  	<th>Phone</th>
                  	<th>Address</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($suppliers as $supplier)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$supplier->name}}</td>
                  	<td>{{$supplier->phone}}</td>
                  	<td>{{$supplier->address}}</td>
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
  <div class="modal fade" id="supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Supplier Form</h5>
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
		            <label for="message-text"  class="float-left">Email:</label>
		            <input type="email" class="form-control" id="email" name="email">
		            <span class="text-danger">{{ $errors->first('name') }}</span>
		        </div>
		        <div class="form-group">
 		            <label for="message-text"  class="float-left">Address:</label>
		            <textarea class="form-control" id="address" name="address"></textarea>
		            <span class="text-danger">{{ $errors->first('description') }}</span>
		        </div>
		        <div class="form-group">
		            <label for="message-text"  class="float-left">Phone:</label>
		            <input type="text" class="form-control" id="phone" name="phone" id="recipient-name">
		            <span class="text-danger">{{ $errors->first('phone') }}</span>
		        </div>
            <div class="form-group">
              <label for="message-text" style="margin-right: 500px;">Brand:</label>
              <div class="select2-purple">                
                <select class="select2" multiple="multiple" name="brands[]" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">
                  @foreach($brands as $brand)
                  <option value="{{$brand->id}}">{{$brand->name}}</option>
                  @endforeach
                </select>
              </div>

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
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">
	$('.select2').select2()
	$(".btn-submit").click(function(e){

        e.preventDefault();
        var categories = [];
        var name = $("input[name=name]").val();

        var brands = $("select[name='brands[]']").val();

        var address = $("textarea[name=address]").val();
        var email = $("input[name=email]").val();
        var phone = $("input[name=phone]").val();
        
        $.ajax({

           type:'POST',

           url:'/ajaxSupplier',

           data:{
           	"_token":"{{csrf_token()}}",
           	"name":name, 
           	"phone":phone, 
           	"address":address,
            "brands":brands,
            "email":email,
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