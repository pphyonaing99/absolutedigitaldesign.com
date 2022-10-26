@extends('master')
@section('title','Create Product')
@section('link','Create Product')
@section('content')
<style type="text/css">
	.error{
        outline: 1px solid red;
    }   
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<div class="row">
<!-- left column -->
	<div class="col-md-12">
	<!-- general form elements -->
	<div class="card card-primary">
	  <div class="card-header">
	    <h3 class="card-title">Product Register</h3>
	  </div>
	  <!-- /.card-header -->
	  <!-- form start -->
	  <form role="form" method="post" action="{{route('store_product')}}" id="product">
	  	@csrf
	  	<input type="hidden" name="extra_unit[]" id="add_extra_unit">
	  	<input type="hidden" name="shelve_id" value={{$shelve_id}}>
	    <div class="card-body">
	     <div class="row">
	     	<div class="col-md-6">
	     		 <div class="form-group">
			        <label>Category</label>
			        <select class="form-control select2" name="category_id" onchange="getSubCategory(this.value)">
			          <option selected="selected">Select Category</option>
			          @foreach($categories as $category)
			            <option value="{{$category->id}}">{{$category->name}}</option>
			          @endforeach
			        </select>
			     </div>
	     		 <div class="form-group">
			        <label>Sub Category</label>
			        <select class="form-control select2" name="subcategory_id" id="subcategory">
			          <option selected="selected">Select SubCategory</option>
			        </select>
			     </div>
	     		 <div class="form-group">
			        <label>Brand</label>
			        <select class="form-control select2" name="brand_id">
			          <option selected="selected">Select Brand</option>
			          @foreach($brands as $brand)
			            <option value="{{$brand->id}}">{{$brand->name}}</option>
			          @endforeach
			        </select>
			      </div>
				  <div class="form-group">
			        <label for="serial_number">Serial Number</label>
			        <input type="text" class="form-control" name="serial_number" id="serial_number" placeholder="Enter Serial Number">
			      </div>
			      <div class="form-group">
			        <label for="model_number">Model</label>
			        <input type="text" class="form-control" name="model_number" id="model_number" placeholder="Enter Model Number">
			      </div>
			      <div class="form-group">
			        <label for="name">Name</label>
			        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Product Name">
			      </div>
			      <div class="form-group">
			        <label for="location">Location</label>
			        <input type="text" class="form-control" name="location" id="location" placeholder="Enter Your warehouse Location">
			      </div>
			      <div class="form-group">
			      <label>Register Date:</label>

			      <div class="input-group">
			        <div class="input-group-prepend">
			          <span class="input-group-text">
			            <i class="far fa-calendar-alt"></i>
			          </span>
			        </div>
			        <input type="date" name="reg_date" class="form-control float-right">
			      </div>
			      <!-- /.input group -->
			    </div>
			      <div class="card-footer">
			      	<button type="submit" class="btn btn-primary btn-submit">Submit</button>
			      </div>
	     	</div>
	     	<div class="col-md-6">
			    <a class="btn btn-primary text-white" id="add_basic_unit" onclick="add_basic_unit()"><i class="fas fa-plus"></i> Base Unit</a>
		    	<div class="form-group" id="basic_unit">
		    	</div>

			    <!--<a class="btn btn-primary" id="extraModal" data-toggle="modal" data-target="#extraUnit" onclick="extra_unit()"><i class="fas fa-plus"></i> Extra Unit</a>-->
			    <div id="extra_unit_list"></div>
			    <div class="form-group" id="extra_unit">
			    </div>
			   </div>  	
			</div>
	     </div>
	    	
	    <!-- /.card-body -->

    
  </form>
</div>
<!-- /.card -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">

$('.select2').select2()
$("input[data-bootstrap-switch]").each(function(){
  $(this).bootstrapSwitch('state', $(this).prop('checked'));
});
</script>

<script type="text/javascript">
	
	function getSubCategory(category_id){
	    
	    $.ajax({

           type:'POST',

           url:'/getSubCategory',

           data:{
           	"_token":"{{csrf_token()}}",
           	"category_id":category_id, 
           },

           success:function(data){
             $('#subcategory').empty();
           	$.each(data.subcategories,function(i,sub){
           	    
           	    $('#subcategory').append($('<option>').attr('value',sub.id).text(sub.name));
           	})
           }

        });
	}
	
	function add_basic_unit(){
		var discount_types = {!! json_encode($discount_types) !!}
		$('#basic_unit').slideDown('slow');
		$('#basic_unit').append($('<label>').text('Mearsuring Unit'));
		$('#basic_unit').append($('<input>').attr('type','text').addClass('form-control').attr('name','measuring_unit').attr('placeholder','Enter Unit Name').attr('id','measuring_unit'));

		$('#basic_unit').append($('<label>').text('Quantity'));
		$('#basic_unit').append($('<input>').attr('type','number').addClass('form-control').attr('name','stock_qty').attr('placeholder','1').attr('id','stock_qty'));

		$('#basic_unit').append($('<label>').text('Minimum Order Quantity'));
		$('#basic_unit').append($('<input>').attr('type','number').addClass('form-control').attr('name','minimum_order_qty').attr('placeholder','1').attr('id','minimum_order_qty'));

		$('#basic_unit').append($('<label>').text('Reorder Quantity'));
		$('#basic_unit').append($('<input>').attr('type','number').addClass('form-control').attr('name','reorder_qty').attr('placeholder','1').attr('id','reorder_qty'));

		//Purchase Price Form
		$('#basic_unit').append($('<label>').text('Purchase Price'));
		$('#basic_unit').append($('<div>').addClass('row').attr('id','row'));
		$('#row').append($('<div>').addClass('col-md-6').attr('id','row2'));
		$('#row').append($('<div>').addClass('col-md-6').attr('id','row3'));
		$('#row2').append($('<input>').attr('type','number').addClass('form-control').attr('name','purchase_price').attr('placeholder','10000').attr('id','purchase_price'));
		$('#row3').append($('<select>').addClass('form-control').attr('name','purchase_price_currency').attr('id','purchase_price_currency'));
		$('#purchase_price_currency').append($('<option>').attr('value','USD').text('USD'));
		$('#purchase_price_currency').append($('<option>').attr('value','MMK').text('MMK'));


		//Retail Price Form
		$('#basic_unit').append($('<label>').text('Retail Price'));
		$('#basic_unit').append($('<div>').addClass('row').attr('id','retail_row'));
		$('#retail_row').append($('<div>').addClass('col-md-6').attr('id','retail_row2'));
		$('#retail_row').append($('<div>').addClass('col-md-6').attr('id','retail_row3'));
		$('#retail_row2').append($('<input>').attr('type','number').addClass('form-control').attr('name','retail_price').attr('placeholder','11000').attr('id','retail_price'));
		$('#retail_row3').append($('<select>').addClass('form-control').attr('name','retail_price_currency').attr('id','retail_price_currency'));
		$('#retail_price_currency').append($('<option>').attr('value','USD').text('USD'));
		$('#retail_price_currency').append($('<option>').attr('value','MMK').text('MMK'));

		//Wholesale Price Form
		$('#basic_unit').append($('<label>').text('Wholesale Price'));
		$('#basic_unit').append($('<div>').addClass('row').attr('id','wholesale_row'));
		$('#wholesale_row').append($('<div>').addClass('col-md-6').attr('id','wholesale_row2'));
		$('#wholesale_row').append($('<div>').addClass('col-md-6').attr('id','wholesale_row3'));
		$('#wholesale_row2').append($('<input>').attr('type','number').addClass('form-control').attr('name','wholesale_price').attr('placeholder','10500').attr('id','wholesale_price'));
		$('#wholesale_row3').append($('<select>').addClass('form-control').attr('name','wholesale_price_currency').attr('id','wholesale_price_currency'));
		$('#wholesale_price_currency').append($('<option>').attr('value','USD').text('USD'));
		$('#wholesale_price_currency').append($('<option>').attr('value','MMK').text('MMK'));

		$.each(discount_types,function(i,v){
			$('#discount_type').append($('<option>').attr('value',v.id).text(v.name));
		});

	};

	function extra_unit(){
		var discount_types = {!! json_encode($discount_types) !!}
		$('#extra_unit').empty();
		var html = '';
		var measuring_unit = $("input[name=measuring_unit]").val();
		var stock_qty = $("input[name=stock_qty]").val();
		var reorder_qty = $("input[name=reorder_qty]").val();
		var purchase_price = $("input[name=purchase_price]").val();
		var retail_price = $("input[name=retail_price]").val();
		var wholesale_price = $("input[name=wholesale_price]").val();

		    if($.trim(measuring_unit) == '' || $.trim(stock_qty) == '' || $.trim(reorder_qty) == '' || $.trim(purchase_price) == '' || $.trim(retail_price) == '' || $.trim(wholesale_price) == '' ) {
		          	
		          	swal({
		          		title:"Failed!",
	             		text:"Please fill all basic unit Field",
	             		icon:"info",
		          	});
		          
		    }else{
		    	// $('#extra_unit').empty();
		    	
		    	$('#extra_unit').append($('<label>').text('Mearsuring Unit'));
				$('#extra_unit').append($('<input>').attr('type','text').addClass('form-control').attr('name','extra_measuring_unit').attr('placeholder','Enter Unit Name').attr('id','extra_measuring_unit'));

				$('#extra_unit').append($('<label>').text('Basic Unit Quantity'));
				$('#extra_unit').append($('<input>').attr('type','number').addClass('form-control').attr('name','basic_unit_qty').attr('placeholder','1').attr('id','basic_unit_qty'));

				$('#extra_unit').append($('<label>').text('Quantity'));
				$('#extra_unit').append($('<input>').attr('type','number').addClass('form-control').attr('name','extra_stock_qty').attr('placeholder','1').attr('id','extra_stock_qty'));

				$('#extra_unit').append($('<label>').text('Reorder Quantity'));

				$('#extra_unit').append($('<input>').attr('type','number').addClass('form-control').attr('name','extra_reorder_qty').attr('placeholder','1').attr('id','reorder_qty'));

				//Extra Purchase Price Form
				$('#extra_unit').append($('<label>').text('Purchase Price'));
				$('#extra_unit').append($('<div>').addClass('row').attr('id','extra_row'));
				$('#extra_row').append($('<div>').addClass('col-md-6').attr('id','extra_row_row2'));
				$('#extra_row').append($('<div>').addClass('col-md-6').attr('id','extra_row_row3'));
				$('#extra_row_row2').append($('<input>').attr('type','number').addClass('form-control').attr('name','extra_purchase_price').attr('placeholder','10000').attr('id','extra_purchase_price'));
				$('#extra_row_row3').append($('<select>').addClass('form-control').attr('name','extra_purchase_price_currency').attr('id','extra_purchase_price_currency'));
				$('#extra_purchase_price_currency').append($('<option>').attr('value','USD').text('USD'));
				$('#extra_purchase_price_currency').append($('<option>').attr('value','MMK').text('MMK'));

				//Extra Retail Price Currency
				$('#extra_unit').append($('<label>').text('Retail Price'));
				$('#extra_unit').append($('<div>').addClass('row').attr('id','extra_retail_row'));
				$('#extra_retail_row').append($('<div>').addClass('col-md-6').attr('id','extra_retail_row2'));
				$('#extra_retail_row').append($('<div>').addClass('col-md-6').attr('id','extra_retail_row3'));
				$('#extra_retail_row2').append($('<input>').attr('type','number').addClass('form-control').attr('name','extra_retail_price').attr('placeholder','11000').attr('id','extra_retail_price'));
				$('#extra_retail_row3').append($('<select>').addClass('form-control').attr('name','extra_retail_price_currency').attr('id','extra_retail_price_currency'));
				$('#extra_retail_price_currency').append($('<option>').attr('value','USD').text('USD'));
				$('#extra_retail_price_currency').append($('<option>').attr('value','MMK').text('MMK'));

				//Extra Wholesale Currency
				$('#extra_unit').append($('<label>').text('Wholesale Price'));
				$('#extra_unit').append($('<div>').addClass('row').attr('id','extra_wholesale_row'));
				$('#extra_wholesale_row').append($('<div>').addClass('col-md-6').attr('id','extra_wholesale_row2'));
				$('#extra_wholesale_row').append($('<div>').addClass('col-md-6').attr('id','extra_wholesale_row3'));
				$('#extra_wholesale_row2').append($('<input>').attr('type','number').addClass('form-control').attr('name','extra_wholesale_price').attr('placeholder','10500').attr('id','extra_wholesale_price'));
				$('#extra_wholesale_row3').append($('<select>').addClass('form-control').attr('name','extra_wholesale_price_currency').attr('id','extra_wholesale_price_currency'));
				$('#extra_wholesale_price_currency').append($('<option>').attr('value','USD').text('USD'));
				$('#extra_wholesale_price_currency').append($('<option>').attr('value','MMK').text('MMK'));

				$('#extra_unit').append($('<label>').text('Discount Type'));
				$('#extra_unit').append($('<select>').addClass('form-control').attr('name','extra_discount_type').attr('id','extra_discount_type'));
				$.each(discount_types,function(i,v){
					$('#extra_discount_type').append($('<option>').attr('value',v.id).text(v.name));
				});

				/*$('#extra_unit').append($('<label>').text('Discount'));
				$('#extra_unit').append($('<input>').attr('type','checkbox').attr('name','extra_discount_flag').attr('checked').attr('data-bootstrap-switch').attr('id','extra_discount_flag'));*/

				$('#extra_unit').append($('<a>').attr('type','submit').addClass('form-control btn btn-primary mt-2 btn-submit').attr('value','Add Extra Unit').text('Add Extra Unit').attr('onclick','addExtraUnit()'));

				
				
		    }
	}
	var extra_units = [];

	function addExtraUnit(){
		
		if(extra_units.length < 5){
			var extra_measuring_unit = $('input[name=extra_measuring_unit]').val();
			var basic_unit_qty = $('input[name=basic_unit_qty]').val();
			var extra_stock_qty = $('input[name=extra_stock_qty]').val();
			var extra_reorder_qty = $('input[name=extra_reorder_qty]').val();
			var extra_purchase_price = $('input[name=extra_purchase_price]').val();
			var extra_retail_price = $('input[name=extra_retail_price]').val();
			var extra_wholesale_price = $('input[name=extra_wholesale_price]').val();
			var extra_retail_price_currency = $('select[name=extra_retail_price_currency]').val();
			var extra_wholesale_price_currency = $('select[name=extra_wholesale_price_currency]').val();

			var extra = {extra_measuring_unit:extra_measuring_unit,basic_unit_qty:basic_unit_qty,extra_stock_qty:extra_stock_qty,extra_reorder_qty:extra_reorder_qty,extra_purchase_price:extra_purchase_price,extra_retail_price:extra_retail_price,extra_wholesale_price:extra_wholesale_price,extra_retail_price_currency:extra_retail_price_currency,extra_wholesale_price_currency:extra_wholesale_price_currency};

			extra_units.push(extra);
				$('#extra_unit_list').append($('<span>').text('Mearsuring Unit : '));
				$('#extra_unit_list').append($('<span>').text(extra.extra_measuring_unit).addClass('mr-5'));

				$('#extra_unit_list').append($('<span>').text('Stock Quantity : '));
				$('#extra_unit_list').append($('<span>').text(extra.extra_stock_qty));
				$('#extra_unit_list').append($('<br>'));
			var unit = JSON.stringify(extra_units);
			$('#add_extra_unit').attr('value',unit);
		}else{
			swal({

				title : "Notice !",
				text : "You can't add more than 5 Extra Unit",
				icon : "info",

			});
		}

	}

	$(".btn-submit").click(function(e){

		swal({

				title : "Successful",
				text : "Added Product",
				icon : "success",

			});

	})

</script>

@endsection