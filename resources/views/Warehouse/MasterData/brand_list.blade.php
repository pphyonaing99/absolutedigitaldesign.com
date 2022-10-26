@extends('master')
@section('title','Brand List')
@section('link','Brand List')
@section('content')
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">Brand List</h3>
              	<button type="button" data-toggle="modal" data-target="#category" class="btn btn-primary"><i class="fas fa-plus"></i> Add Brand</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                  	<th>Description</th>
                  	<th>Measuring Unit</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($brands as $brand)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$brand->name}}</td>
                  	<td>{{$brand->description}}</td>
                  	<td>{{$brand->country_of_origin}}</td>
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
  <div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Brand Form</h5>
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
    			        <label for="message-text"  class="float-left">Category</label>
    			        <select class="form-control" name="category_id" onchange="getsubCategory(this.value)">
    			          <option>Select Category</option>
    			          @foreach($categories as $cate)
    			            <option value="{{$cate->id}}">{{$cate->name}}</option>
    			          @endforeach
    			        </select>
      			    </div>
    			    
              <div class="form-group">
                <label for="message-text" class="pull-left">Sub Category</label>
                <div class="select2-purple">                
                  <select class="select2" multiple="multiple" name="sub_category[]" id="subCategory" data-placeholder="Select Sub Categories" data-dropdown-css-class="select2-purple" style="width: 100%;">
                  </select>
                </div>
              </div>
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
		            <label for="message-text"  class="float-left">Country of Region:</label>
		            <input type="text" class="form-control" id="country_of_origin" name="country_of_origin" id="recipient-name">
		            <span class="text-danger">{{ $errors->first('country_of_origin') }}</span>
		        </div>
	            <input type="submit" name="btnsubmit" class="btn btn-primary float-right btn-submit" value="Add Brand">
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
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">
	$('.select2').select2();
	function getsubCategory(category_id){
    
		$('#subCategory').empty();
		$('#suppliers').empty();

		$.ajax({

           type:'POST',

           url:'/getSubCategory',

           data:{
           	"_token":"{{csrf_token()}}",
           	"category_id":category_id,
           },

           success:function(data){
           	$.each(data.subcategories,function(i,subCategory){
           		$('#subCategory').append($('<option>').attr('value',subCategory.id).text(subCategory.name));
               
           	});

           }

        });

	}

	$(".btn-submit").click(function(e){

        e.preventDefault();

        var name = $("input[name=name]").val();

        var description = $("textarea[name=description]").val();

        var category_id = $("select[name=category_id]").val();

        var sub_category = $("select[name='sub_category[]']").val();

        var suppliers = $("select[name='suppliers[]']").val();

        var country_of_origin = $("input[name=country_of_origin]").val();

        $.ajax({

           type:'POST',

           url:'/ajaxStoreBrand',

           data:{
           	"_token":"{{csrf_token()}}",
           	"name":name, 
           	"description":description, 
           	"category_id":category_id,
           	"sub_category":sub_category,
           	"suppliers":suppliers,
           	"country_of_origin":country_of_origin,
           },

           success:function(data){
            console.log(data);
           		swal({

             		title:"Success!",
             		text:"You Have Successfully Added Brand",
             		icon:"success",
             	});

             	setTimeout(function(){
             		window.location.reload();
             	},1000);

           }

        });
	});

</script>

@endsection