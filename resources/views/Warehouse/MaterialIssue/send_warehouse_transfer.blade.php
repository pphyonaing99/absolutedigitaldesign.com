@extends('master')
@section('title','Send Regional Warehouse')
@section('link','Send Regional Warehouse')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Send Regional Warehouses</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

            	<form method="post" action="{{route('storeWarehouseTransfer')}}">
            		@csrf
            		<input type="hidden" name="purchase_order_id" value="{{$material_issue->purchase_order_id}}">
            		<input type="hidden" name="material_issue_id" value="{{$material_issue->id}}">
            		<input type="hidden" name="transfer_lists[]" value="{{$material_issue_lists}}">


			        <div class="form-group">
			            <label for="recipient-name" class="float-left">Projectss:</label>
			            <input type="text" class="form-control" disabled value="{{$material_issue->project->project_name}}" id="recipient-name">
			        </div>
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Phase:</label>
			            <input type="text" class="form-control" disabled value="{{$material_issue->phase->phase_name}}" id="recipient-name">
			        </div>
			        @if($material_issue->purchase_order_id != null)
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Receiving Person:</label>
			            <input type="text" class="form-control" disabled value="{{$material_issue->purchase_order->customer_name}}" id="recipient-name">
			        </div>
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Phone:</label>
			            <input type="text" class="form-control" disabled value="{{$material_issue->purchase_order->phone}}" id="recipient-name">
			        </div>
			        @else
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Receiving Person:</label>
			            <input type="text" class="form-control" disabled value="{{$material_issue->material_request->user->name}}" id="recipient-name">
			        </div>
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Phone:</label>
			            <input type="text" class="form-control" id="recipient-name">
			        </div>
			        @endif
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Delivery Date:</label>
			            <input type="date" class="form-control" name="delivery_date" id="recipient-name">
			        </div>
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Location:</label>
			            <input type="text" class="form-control" name="location" id="recipient-name">
			        </div>
			        <div class="form-group">
			            <label for="message-text"  class="float-left">Regional Warehouse:</label>
			            <select name="regional_warehouse_id" class="form-control">
			            	@foreach($regional_warehouses as $regional)
			            		<option value=" {{ $regional->id }} ">{{ $regional->warehouse_name }}</option>
			            	@endforeach
			            </select>
			        </div>
			        <div class="col-md-12">
		                <div class="row bg-info text-center font-weight-bold p-2">
		                    <div class="col-md-6">
		                      <span>Product Name</span>
		                    </div>
		                    <div class="col-md-6">
		                      <span>Request Quantity</span>
		                    </div>
		                  </div>

		                  @foreach($material_issue_lists as $item_list)
		                  @if($item_list->material_issue_id == $material_issue->id)
		                  <div class="row mb-1 mt-3 text-center font-weight-bold" style="font-size:18px;">
		                    <div class="col-md-6">
		                      {{$item_list->product->name}}
		                    </div>
		                    <div class="col-md-6">
		                       {{$item_list->stock_qty}}
		                    </div>
		                  </div>
		                <hr>
		                  @endif
		                  @endforeach
		            </div>
		            <input type="submit" name="btnsubmit" class="btn btn-primary float-right" value="Send Regional Warehouse">
		        </form>

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

<script type="text/javascript">
	
	/*$(".btn-submit").click(function(e){

        e.preventDefault();
        var purchase_order_id = document.getElementById('purchase_order_id').value;

        // var purchase_order_id = $("input[name=purchase_order_id]").val();

        var material_issue_id = $("input[name=material_issue_id]").val();

        var delivery_date = $("input[name=delivery_date]").val();

        var location = $("input[name=location]").val();

        console.log(purchase_order_id);

        /*$.ajax({

           type:'POST',

           url:'/ajaxRequest',

           data:{name:name, password:password, email:email},

           success:function(data){

              alert(data.success);

           }

        });*/



	});*/

</script>

@endsection