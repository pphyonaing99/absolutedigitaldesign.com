@extends('master')
@section('title','Purchase Order List')
@section('link','Purchase Order List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Purchase Order List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Order Code</th>
                  <th>Customer Name</th>
                  <th>Phone Number</th>
                	<th>Request Date</th>
                  <th>Request Item</th>
                  <th>Sales Order</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($purchase_orders as $order)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$order->order_code}}</td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->phone}}</td>
                  	<td>{{$order->request_date}}</td>
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Details</a></td>
                    @if($order->warehouse_status == 1 && $order->status == 0 && $order->site_status == 0)
                    <td><span class="badge badge-warning p-2">Tracking Order ( Warehouse )</span></td>
                    @elseif($order->warehouse_status == 1 && $order->site_status == 1 && $order->status == 0)
                    <td><span class="badge badge-warning p-2">Tracking Order ( Site )</span></td>
                    @elseif($order->warehouse_status == 1 && $order->site_status == 1 && $order->status == 1)
                    <td><span class="badge badge-warning p-2"> Finished Order </span></td>
                    @else
                    <td><a href="{{route('sales_order',$order->id)}}" class="btn btn-primary"><i class="fas fa-plus"></i>  Add Sales Order</a></td>
                    @endif
                  </tr>

                  <!--Details Modal -->
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

                          @foreach($product_lists as $product_list)
                          @if($order->id == $product_list->purchase_order_id)
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
@endsection