@extends('master')
@section('title','Officer Purchase Order List')
@section('link','Officer Purchase Order List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Officer Purchase Order Lists</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Order No</th>
                  <th>Suppler Name</th>
                  <th>Total Qty</th>
                  <th>Item List</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($officer_purchase_orders as $order)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$order->po_no}}</td>
                    <td>{{$order->supplier->name}}</td>
                    <td>{{$order->total_qty}}</td>
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Details</a></td>
                    @if($order->approve == 0)
                    <td><a href="#" class="btn btn-primary" onclick="approveOrder({{$order->id}})">Approve</a></td>
                    @else
                    <td><span class="badge badge-success">Approved</span></td>
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

                          @if($order->item_list != null )
                          @foreach($order->item_list as $item_list)
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                            <div class="col-md-6">
                              {{$item_list->name}}
                            </div>
                            <div class="col-md-6">
                               {{$item_list->qty}}
                            </div>
                          </div>
                        <hr>
                          @endforeach
                          @endif
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
<script>
    
    function approveOrder(purchase_order_id) {
        $.ajax({
            type:'POST',
            url:'/approveOfficerOrder',
            dataType:'json',
            data:{
                '_token':'{{csrf_token()}}',
                'purchase_order_id':purchase_order_id,
            },
            success:function(data) {
                swal({
                    title:'Success',
                    text:"Successfully Approved",
                    icon:'success',
        
                })
                setTimeout(function(){
                  window.location.reload();
                },1000);
            }
        })
    }
    
    
    
    
</script>
@endsection