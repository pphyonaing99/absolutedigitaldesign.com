<?php $i = 1;?>
  @foreach($purchase_requests as $order)
  <tr class="text-center">
  	<td>{{$i++}}</td>
  	<td>{{$order->project->project_name}}</td>
  	<td>{{$order->required_date}}</td>
    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Check Stock</a></td>
    @if($order->sent_status == 1)
    <td><span class="badge badge-success p-2">Sent</span></td>
    @else
    <td><a href="#" data-toggle="modal" data-target="#purchase_{{$order->id}}" class="btn btn-primary"><i class="fas fa-plus"></i> Send Purchase Order</a></td>
    @endif
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
            <div class="col-md-4">
              <span>Product Name</span>
            </div>
            <div class="col-md-4">
              <span>Request Quantity</span>
            </div>
            <div class="col-md-4">
              <span>Instock Quantity</span>
            </div>
          </div>
          <?php $required_qty = 0; ?>
          @foreach($products as $product)
          @foreach($purchase_request_lists as $requests)
          @if($order->id == $requests->warehouse_purchase_order_id && $product->id == $requests->product_id)
          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
            <div class="col-md-4">
              {{$requests->product->name}}
            </div>
            <div class="col-md-4">
               {{$requests->stock_qty}}
            </div>
            <div class="col-md-4">
               {{$product->stock_qty}}
            </div>
          </div>
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
          <form method="post" action="{{route('send_purchase_order',$order->id)}}">
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