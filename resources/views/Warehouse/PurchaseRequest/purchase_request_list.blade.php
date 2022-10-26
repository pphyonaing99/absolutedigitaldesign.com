@extends('master')
@section('title','Purchase Request List')
@section('link','Purchase Request List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Purchase Request Listsssss</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Supplier Name</th>
                	<th>Delivery Address</th>
	                <th>Stock Check</th>
	                <th>Action</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($purchase_orders as $order)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$order->supplier->name}}</td>
                  	<td>{{$order->delivery_address}}</td>
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Check Stock</a></td>
                    <td><a href="#" onclick="acceptedWarehouseRequest({{$order->id}})" class="btn btn-primary">Accept</a></td>
                  </tr>

                  <!--Check Stock -->
                  <div class="modal fade" id="item_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Material Request</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                          <div class="row bg-info font-weight-bold p-2">
                            <div class="col-md-3">
                              <span>Product Name</span>
                            </div>
                            <div class="col-md-3">
                              <span>Request Quantity</span>
                            </div>
                            <div class="col-md-3">
                              <span>Instock Quantity</span>
                            </div>
                            <div class="col-md-3">
                              <span>Required Quantity</span>
                            </div>
                          </div>
                          <?php $required_qty = 0; ?>
                          @foreach($products as $product)
                          @foreach($purchase_request_lists as $requests)
                          @if($order->purchase_request_id == $requests->warehouse_purchase_order_id && $product->id == $requests->product_id)
                          <?php
                            $stock_qty = $product->stock_qty - $requests->stock_qty;
            
                            if ($requests->stock_qty > $product->stock_qty) {
                              $required_qty = $requests->stock_qty - $product->stock_qty;
                            }else{
                              $required_qty = 0;
                            }
                          ?>
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                            <div class="col-md-3">
                              {{$requests->product->name}}
                            </div>
                            <div class="col-md-3">
                               {{$requests->stock_qty}}
                            </div>
                            <div class="col-md-3">
                               {{$product->stock_qty}}
                            </div>
                            <div class="col-md-3">
                              @if( $required_qty > 0 )
                               <span class="badge badge-danger">{{$required_qty}}</span>
                              @else
                              <span class="badge badge-success">{{$required_qty}}</span>
                              @endif
                            </div>
                          </div>
                          <hr>
                          @endif
                          @endforeach
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>

                  <!--purchase Order Modal -->
                  <div class="modal fade" id="purchase_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Purchase Order</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="#">
                            @csrf
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Delivery Address :</label>
                              <input type="text" class="form-control" name="delivery_address" id="recipient-name">
                            </div>
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Delivery Address :</label>
                              <select class="form-control" name="supplier_id">
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <input type="submit" name="btnsubmit" value="Send Purchase Order" class="btn btn-primary btn-submit float-right">
                          </form>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
<!-- page script -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
	function acceptedWarehouseRequest(purchase_request_id){

		var purchase_request_lists = {!! json_encode($purchase_request_lists) !!}

		var purchase_orders = {!! json_encode($purchase_orders) !!}

		var products = {!! json_encode($products) !!}

		var product_id = [];

		$.each(purchase_request_lists,function(i,purchase_request){
			$.each(purchase_orders,function(i,purchase_order){
				if(purchase_request.warehouse_purchase_order_id == purchase_order.purchase_request_id){
					$.each(products,function(i,product){
						if(product.id == purchase_request.product_id){
							product.stock_qty = product.stock_qty - purchase_request.stock_qty;
							
							var product = {id:parseInt(product.id),stock_qty:parseInt(purchase_request.stock_qty)
							};
							product_id.push(product)
						}
					});
				}
			});
		});
			$.ajax({
		      type:'POST',
		      url:'/ajaxAcceptedWarehouseRequest',
		      dataType:'json',
		      data:{"_token": "{{ csrf_token() }}","product_id":product_id},

		      success:function(data){
		        console.log(data);

		        swal({
		          'title':"Successful!",
		          'text':"Accepted Purchase Order.",
		          'icon':"success",

		        })
		      }
	    	});
	}
</script>
@endsection