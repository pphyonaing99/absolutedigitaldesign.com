@extends('master')
@section('title','Purchase Request List')
@section('link','Purchase Request List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Purchase Request Lists</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                  <th>PR No</th>
                  <th>Material Request/Sale Order</th>
                	<th>Project/Regional</th>
                  
                	<th>Require Date</th>
	                <th>Stock Check</th>
	                <th>Status</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($purchase_orders as $order)
                  <tr class="text-center">
                    <td>{{$i++}}</td>
                    @if($order->pr_no != null)
                    <td>{{$order->pr_no}}</td>
                    
                    
                    @endif
                    @if($order->material_request_id == null)
                    @foreach($sale_order as $salor)
                    @if($salor->id == $order->sale_order_id)
                    <td>{{$salor->sale_no}}</td>
                    @endif
                    @endforeach
                    @else
                    @foreach($material_request as $mareq)
                    @if($mareq->id == $order->material_request_id)
                    <td>{{$mareq->request_code}}</td>
                    @endif
                    @endforeach
                    @endif
                    @if($order->project_id != null)
                    @foreach($project as $proj)
                    @if($proj->id == $order->project_id)
                  	<td>{{$proj->project_name}}</td>
                    @endif
                    @endforeach
                    @else
                    @foreach($regional as $eachreg)
                    @if($eachreg->id == $order->destination_regional_id)
                    <td>{{$eachreg->warehouse_name}}</td>
                    @endif
                    @endforeach
                    @endif
                  	<td>{{$order->required_date}}</td>
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Request List</a></td>
                    @if($order->status == 0)
                    <td><span class="badge badge-warning p-1">Pending</span></td>
                    @else
                    <td><span class="badge badge-success p-1">Purchase Ordered</span></td>
                    @endif
                  </tr>

                  <!--Check Stock -->
                  <div class="modal fade" id="item_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          @foreach($products as $product)
                          @foreach($purchase_request_lists as $requests)
                          @if($order->id == $requests->warehouse_purchase_order_id && $product->id == $requests->product_id)
                          
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                            <div class="col-md-6">
                              {{$requests->product->name}}
                            </div>
                            <div class="col-md-6">
                               {{$requests->stock_qty}}
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