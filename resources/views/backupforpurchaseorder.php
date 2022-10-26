@extends('master')
@section('title','Purchase Order List')
@section('link','Purchase Order List')
@section('content')

<div class="row">
  	<div class="col-6 col-sm-12 col-lg-6">

   <!-- ================ Purchase Order ====================== -->

	    <div class="card-body">
	        <div class="card">
	            <div class="card-header">
	              <h3 class="card-title">Purchase Order</h3>
	            </div>
	            <!-- /.card-header -->

	        	<div class="row m-3">
	        		<div class="col-md-5">
	        			<h4>Order Code</h4>
	        		</div>
	        		<div class="col-md-1">
	        			:
	        		</div>
	        		<div class="col-md-6">
	        			<h4>{{$purchase_orders->order_code}}</h4>
	        		</div>
	        	</div>
	        	<div class="row m-3">
	        		<div class="col-md-5">
	        			<h4>Customer Name</h4>
	        		</div>
	        		<div class="col-md-1">
	        			:
	        		</div>
	        		<div class="col-md-6">
	        			<h4>{{$purchase_orders->customer_name}}</h4>
	        		</div>
	        	</div>
	        	<div class="row m-3">
	        		<div class="col-md-5">
	        			<h4>Phone Number</h4>
	        		</div>
	        		<div class="col-md-1">
	        			:
	        		</div>
	        		<div class="col-md-6">
	        			<h4>{{$purchase_orders->phone}}</h4>
	        		</div>
	        	</div>
	        	<div class="row m-3">
	        		<div class="col-md-5">
	        			<h4>Request Date</h4>
	        		</div>
	        		<div class="col-md-1">
	        			:
	        		</div>
	        		<div class="col-md-6">
	        			<h4>{{$purchase_orders->request_date}}</h4>
	        		</div>
	        	</div>
	        	<div class="row m-3">
	        		<div class="col-md-5">
	        			<h4>Details</h4>
	        		</div>
	        		<div class="col-md-1">
	        			:
	        		</div>
	        		<div class="col-md-6">
	        			<a href="#" data-toggle="modal" data-target="#item_{{$purchase_orders->id}}" class="btn btn-primary">Details</a>
	        		</div>
	        	</div>
	        </div>
	    </div>

	</div>
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="card card-primary">
			<div class="card-header">
			    <h3 class="card-title">Sale Order Register</h3>
			</div>
			<!-- /.card-header -->
			<!-- form start -->
			<form role="form" method="post" action="{{route('store_product')}}">
		  	@csrf
			    <div class="card-body">
			      	<div class="form-group">
			            <label>Project</label>
			            <select class="custom-select" name="project_id"
			           onchange="getPhase(this.value)" >
			           		<option>Select Project</option>
			            	@foreach($projects as $project)
			              	<option value="{{$project->id}}">{{$project->project_name}}</option>
			              	@endforeach
			            </select>
		        	</div>
			      	<div class="form-group">
			            <label>Phase</label>
			            <select class="custom-select" id="forPhase" name="phase_id"
			             onchange="getDeliveryDate(this.value)">

			            </select>
		        	</div>
			      	<div class="form-group">
			            <label>Delivery Date</label>
			            <input type="text" class="form-control" name="delivery_date" id="forDeliveryDate">
		        	</div>
			      	<div class="form-group">
			            <label>Product List : </label>
			            <input type='button' class="btn btn-primary mb-1" onClick='javascript:showTable();' value='Show Warehouse Inventory'>
						<input type='button' class="btn btn-primary mb-1" onClick='javascript:hideTable();' value='Hide'>


		        	<!-- ===== Tab For Product List and Warehouse Inventory ====== -->

				        <div class="col-12" class="show_hide">

				        	<table class="table table-bordered table-striped">
				                <thead class="text-center">
				                  	<th>Name</th>
				                  	<th>Stock Quantity</th>
				                </thead>
				                <tbody id="forProduct" class="text-center">
				                  <?php $i = 1;?>

				              	</tbody>
				            </table>
				            <div class="card-footer">
						      <button type="submit" class="btn btn-primary">Submit</button>
						    </div>
				            <!-- ========== Product List Show And Hide ================== -->
		                 	<table id="example1" class="table table-bordered table-striped">
				                <thead class="text-center">
				                	<th>#</th>
				                	<th>Model Number</th>
				                  	<th>Name</th>
				                  	<th>Stock Quantity</th>
				                  	<th>Action</th>
				                </thead>
				                <tbody id="item_list">
				                  @foreach($products as $product)
				                  <tr class="text-center">
				                  	<td>{{$i++}}</td>
				                  	<td>{{$product->model_number}}</td>
				                    <td>{{$product->name}}</td>
				                    <td>{{$product->stock_qty}}</td>
				                    <td><i class="btn btn-primary" onclick="tgPanel(this)" style="cursor: pointer;" ><i class="fas fa-plus"></i> Add</i></td>
				                  </tr>
				                  @endforeach
				              	</tbody>
				            </table>
				        </div>
			        </div>

			    </div>
			    <!-- /.card-body -->


		  	</form>
		</div>
	</div>
	      <!-- /.card -->
</div>

	<!--Details Modal -->
  <div class="modal fade" id="item_{{$purchase_orders->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Material Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <div class="row bg-info font-weight-bold p-2">
            <div class="col-md-6">
              <span>Product Name</span>
            </div>
            <div class="col-md-6">
              <span>Request Quantity</span>
            </div>
          </div>

          @foreach($product_lists as $product_list)
          @if($purchase_orders->id == $product_list->purchase_order_id)
          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
            <div class="col-md-6">
              {{$product_list->product->name}}
            </div>
            <div class="col-md-6">
               {{$product_list->stock_qty}}
            </div>
          </div>
        <hr>
          @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>


<!-- page script -->
<script>
    function getPhase(value){

    	var project_id = value;

		$('#forPhase').empty();

    	 $.ajax({
           type:'POST',
           url:'/ajaxPhase',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":project_id,},

           success:function(data){
           	console.log(data);
           	 $.each(data, function(i, value) {

            	$('#forPhase').append($('<option>').text(value.phase_name).attr('value', value.id));

        	});

           }

        });


    }

    function getDeliveryDate(value){

    	var phase_id = value;

		$('#forDeliveryDate').empty();

    	$.ajax({
           type:'POST',
           url:'/ajaxDeliveryDate',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":phase_id,},

           success:function(data){
           	console.log(data.start_date)
            	$('#forDeliveryDate').attr('value', data.start_date)


           },

        });


    }

    function tgPanel(i) {
    	var html = '';
	    var tr = i.parentElement.parentElement;

	    var name = tr.getElementsByTagName("td")[2];
	    var qty = tr.getElementsByTagName("td")[3];
	    var quantity = 0;
	    var product_name = name.innerText;
	    var stock_qty = qty.innerText;
	    console.log(product_name);

	        var table = document.getElementById("forProduct");

			var row = table.insertRow(-1);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			cell1.innerHTML = product_name;
			cell2.innerHTML = "<i class='fas fa-plus-square btnplus' onclick='increaseQty(this)'></i> 0 <i class='fas fa-minus-square'></i>";



	}
	//Increase Quantity
	function increaseQty(value){

		var table = value.parentElement.parentElement;

		var table_td = table.getElementsByTagName("td")[1];

		var count = 1;

		count_change(table_td,'+');

		table_td.innerHTML = "<i class='fas fa-plus-square btnplus' onclick='increaseQty(this)'></i> "+plus+" <i class='fas fa-minus-square'></i>"

		console.log(count);
	}
    function addProduct(text){
    	var product_id = text;
    	console.log(product_id)
    }
</script>
<script>
document.getElementById('example1').style.visibility = "hidden";
function showTable(){
	document.getElementById('example1').style.visibility = "visible";
	}
	function hideTable(){
	document.getElementById('example1').style.visibility = "hidden";
}
</script>
@endsection