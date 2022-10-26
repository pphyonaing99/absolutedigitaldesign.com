@extends('master')
@section('title','Sale Purchase Order List')
@section('link','Sale Purchase Order List')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row justify-content-between">
                <h3 class="card-title">Sale Purchase Order List</h3>
                <a href="{{route('sale_purchase_order')}}" class="btn btn-primary"><i class="fas fa-plus"></i>  Add Purchase Order</a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped" id="myTable">
                <thead class="text-center">
                	<th>#</th>
                	<th>Customer Name</th>
                  	<th>Project Name</th>
                	  <th>Request Date</th>
                	  <th>Phone</th>
                  	<th>Required Item</th>
                  	<th>Action</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($purchase_orders as $order)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$order->customer_name}}</td>
                    <td>{{$order->project_name}}</td>
                    <td>{{$order->request_date}}</td>
                    <td>{{$order->phone}}</td>
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Details</a></td>
                    @if($order->status == 0)
                    <td><span class="badge badge-danger">Pending</span></td>
                    @else
                    <td><span class="badge badge-success">Done</span></td>
                    @endif
                  </tr>

                  <!--Details Modal -->
                  <div class="modal fade" id="item_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Warehouse Purchase Order</h5>
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

                          @foreach($purchase_order_lists as $product_list)
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
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- page script -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
@endsection