@extends('master')
@section('title','SubCategory List')
@section('link','SubCategory List')
@section('content')
<head>
  <link rel="stylesheet" href="//unpkg.com/bootstrap-select@1.12.4/dist/css/bootstrap-select.min.css" type="text/css" />
  <link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.css" rel="stylesheet"/>
</head>
<div class="row">
        <div class="col-12">
          	<div class="card">
              <div class="card-header">
              <div class="row justify-content-between">
              	<h3 class="card-title">SubCategory List</h3>
              	<button type="button" data-toggle="modal" data-target="#category" class="btn btn-primary"><i class="fas fa-plus"></i> Add SubCategory</button>
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
                  @foreach($subcategories as $subcategory)
                  <tr class="text-center">  
                  	<td>{{$i++}}</td>
                  	<td>{{$subcategory->category->name}}</td>
                  	<td>{{$subcategory->name}}</td>
                  	<td>{{$subcategory->description}}</td>
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
                <label for="message-text"  class="float-left">Choose Category:</label>
                <select class="form-control" name="category_id" id="category">
                  @foreach($categories as $cate)
                  <option value="{{$cate->id}}">{{$cate->name}}</option>
                  @endforeach
                </select>
                <span class="text-danger">{{ $errors->first('category') }}</span>
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
                <label for="message-text"  class="float-left">Description:</label>
                <select class="selectpicker countrypicker" data-flag="true" ></select>
            </div>
		        
	            <input type="submit" name="btnsubmit" class="btn btn-primary float-right btn-submit" value="Create Category">
	        </form>

        </div>
      </div>
    </div>
  </div>
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- page script -->
<script src="//unpkg.com/bootstrap-select@1.12.4/dist/js/bootstrap-select.min.js"></script>
  <script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/js/bootstrap-formhelpers.js"></script>

<script type="text/javascript">
  $('.countrypicker').countrypicker();
</script>
<script type="text/javascript">
	 
	$(".btn-submit").click(function(e){

        e.preventDefault();

        var category_id = $("select[name=category_id]").val();

        var name = $("input[name=name]").val();

        var description = $("textarea[name=description]").val();

        $.ajax({

           type:'POST',

           url:'/ajaxSubCategory',

           data:{
           	"_token":"{{csrf_token()}}",
           	"category_id":category_id,
           	"name":name, 
           	"description":description, 
           },

           success:function(data){
           	
           		swal({

             		title:"Success!",
             		text:"You Have Successfully Added Sub Category",
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