@extends('master')
@section('title','Sale Order List')
@section('link','Sale Order List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div>
              <div class="row">
              @if(session()->get('user')->hasRole('Project Manager'))
                  <div class="col-md-6">
                    <h3 class="card-title">Sale Order List</h3>
                  </div>
              @endif
                  <div class="col-md-9">
                    <h3 class="card-title">Sale Order List</h3>
                  </div>
                  <div class="col-md-3">
                    <label >Prefix Syntax -</label><span class="p-2 ml-2 mr-3 badge badge-danger text-center">{{$prefix}}</span>
                    <label >Syntax Digit -</label><span class="p-2 ml-2 badge badge-danger text-center">{{$digit}}</span>
                  <div>
                  @if(session()->get('user')->hasRole('Project Manager'))
                  <div class="col-md-6">
                    <label >Prefix Syntax -</label><span class="p-2 ml-2 mr-3 badge badge-danger text-center">{{$prefix}}</span>
                    <label >Syntax Digit -</label><span class="p-2 ml-2 badge badge-danger text-center">{{$digit}}</span>
                    
                    <a href="{{route('sales_order_manual')}}" class="btn btn-primary float-right"><i class="fas fa-plus"></i>  Add Sales Order</a>
                    
                  </div>
                  @endif
              </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
            <input type="hidden" id="prefix" value="{{$prefix}}">
              <input type="hidden" id="digit" value="{{$index}}">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center bg-primary">
                	<th>#</th>
                  <th>Sale Order No</th>
                	<th>Project Name</th>
                  <th>Phase Name</th>
                	<th>Delivery Date</th>
                  <th>Product Lists</th>
                  @if(session()->get('user')->hasRole('Warehouse Supervisor'))
                  
                  <th>Stock Check</th>
                  @endif
                  
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($sale_orders as $order)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                    <td>{{$order->sale_no}}</td>
                  	<td>{{$order->project->project_name}}</td>
                    <td>{{$order->phase->phase_name}}</td>
                  	<td>{{$order->delivery_date}}</td>
                    <td><a href="#" data-toggle="modal" data-target="#orderitem_{{$order->id}}" class="btn btn-primary">Detail</a></td>
                    @if(session()->get('user')->hasRole('Warehouse Supervisor'))
                  	@if($order->material_issue_status == 1)
                    <td><span class="badge badge-success p-2">Finished Mateiral Issued</span></td>
                    @else
                    <!-- <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary" onclick="check_stock('{{$order->id}}')">Check Stock</a></td> -->
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary" onclick="dismiss_button('{{$order->id}}')">Check Stock</a></td>
                    @endif
                    @endif
                  </tr>
                  <!-- Begin sale order List product Modal -->

                  <div class="modal fade bd-example-modal-lg" id="orderitem_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Sale Order Products</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="row bg-info font-weight-bold p-2">
                                <div class="col-md-1">
                                  <span>No</span>
                                </div>
                                <div class="col-md-3">
                                  <span>Product Name</span>
                                </div>
                                <div class="col-md-2">
                                  <span>Brand</span>
                                </div>
                                <div class="col-md-3">
                                  <span>Model Number</span>
                                </div>
                                <div class="col-md-3">
                                  <span>Request Stock Qty</span>
                                </div>
                            </div>
                            <?php $i=1 ?>
                            @foreach($sale_order_lists as $itemlist)
                            @if($order->id == $itemlist->sale_order_id)
                            <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                                
                                
                                <div class="col-md-1">
                                  <span>{{$i++}}<span>
                                </div>
                                <div class="col-md-3">
                                  <span>{{$itemlist->product->name}}</span>
                                </div>
                                <div class="col-md-2">
                                  <span>{{$itemlist->product->brand->name}}</span>
                                </div>
                                <div class="col-md-3">
                                  <span>{{$itemlist->product->model_number}}</span>
                                </div>
                                <div class="col-md-3">
                                  <span>{{$itemlist->stock_qty}}</span>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                  </div>
                </div>

                  <!-- End sale order list -->
                  <!--Check Stock -->
                  <div class="modal fade" id="item_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Stock Check</h5>
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
                          @foreach($sale_order_lists as $sale_order)
                          @if($order->id == $sale_order->sale_order_id && $product->id == $sale_order->product_id)
                          <input type="hidden" id="moq_{{$order->id}}" value="{{$product->minimum_order_qty}}">
                          <?php
                            $stock_qty = $product->stock_qty - $sale_order->stock_qty;
            
                            if ($sale_order->stock_qty > $product->stock_qty) {
                              $required_qty = $sale_order->stock_qty - $product->stock_qty;
                            }else{
                              $required_qty = 0;
                            }
                          ?>
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                            <div class="col-md-3">
                              {{$sale_order->product->name}}
                            </div>
                            <div class="col-md-3">
                               {{$sale_order->stock_qty}}
                            </div>
                            <div class="col-md-3">
                               {{$product->stock_qty}}
                            </div>
                            <div class="col-md-3">
                              @if( $required_qty > 0 )
                                <input type="hidden" id="required_{{$order->id}}_qty" value="{{$required_qty}}">
                               <span class="badge badge-danger">{{$required_qty}}</span>
                              @else
                              <input type="hidden" id="norequired_{{$order->id}}" value="{{$required_qty}}">
                              <span class="badge badge-success">{{$required_qty}}</span>
                              @endif
                            </div>
                          </div>
                          <hr>
                          @endif
                          @endforeach
                          @endforeach
                          
                           <span id="purchase_request"></span>
                           <a href="{{route('warehouse_po_create',$order->id)}}" id="por{{$order->id}}" class="btn btn-danger preq">Purchase Request</a>
                           <span><a href="#" onclick="sale_order('{{$order->id}}')" class="btn btn-primary pull-right" id="mis{{$order->id}}">Material Issue</a></span>
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
  
  function check_stock(order_id){
    $('#purchase_request').empty();
    var sale_orders = {!! json_encode($sale_orders) !!};
    var required = $('#required_'+order_id+'_qty').val();
    var norequired = $('#norequired_'+order_id).val();
    var moq = $('#moq_'+order_id).val();
  console.log(required);
    
    $.each(sale_orders,function(i,sale_order){
      if(sale_order.id == order_id){
        if(norequired != 0){
          var custom_url = "{{ url('/warehouse_po_create') }}/"+order_id;
          
          /*if(moq >= required){
            swal({
              title:"Notice !",
              text:"You Can Request if Required Qty is under MOQ.",
              icon:"success",
            })
          }*/
          console.log(moq>=required);
          if(moq >= required){
            $('#purchase_request').append($('<a>').addClass('btn btn-primary').attr('href',custom_url).attr('id','purchase_request').text('Purchase Request'));
          }else{

            $('#purchase_request').append($('<a>').addClass('btn btn-primary').attr('href',custom_url).attr('id','purchase_request').text('Purchase Request'));
          }
          
        }
          
      }
    });
  }

  function sale_order(sale_order_id){
    var prefix = $('#prefix').val();
    var digit = $('#digit').val();
    alert(digit);
    $.ajax({
      type:'POST',
      url:'/ajaxSendMaterialIssue',
      dataType:'json',
      data:{"_token": "{{ csrf_token() }}",
      "sale_order_id":sale_order_id,
      "prefix": prefix,
      "digit":digit,
    
    },

      success:function(data){
        console.log(data);

        swal({
          'title':"Successfully Send Sale Order!",
          'text':"Successfully Send Sale Order!",
          'icon':"success",
        })
        setTimeout(function(){
		   window.location.reload();
		}, 1000);
      }
    });

  }


  /*$("#sale_order").on('click','.check_stock',function(){

    var sale_order_list = {!! json_encode($sale_order_lists->toArray()) !!};
    var product_list = {!! json_encode($products->toArray()) !!};

    var sale_order_id=$(this).data('id');
    var required_qty = 0;
    $.each(sale_order_list,function(i,sale_order){
      if (sale_order.sale_order_id == sale_order_id) {
        // console.log(sale_order);
        $.each(product_list,function(i,product){
          if(product.id == sale_order.product_id){
            var stock_qty = product.stock_qty - sale_order.stock_qty;
            
            if (sale_order.stock_qty < product.stock_qty) {
              required_qty = 0;
            }else{
              required_qty=1;
            }

            $('#myModal').on('shown.bs.modal', function () {
              $('#myInput').trigger('focus')
            })
            swal({
                title:"Running Stock Check!",
                text:"Item Name : "+product.name+"\n Request Qty : "+sale_order.stock_qty+"\n In Stock Qty : "+product.stock_qty+"\n required Qty : "+required_qty,
                icon:"success",
              })

          }
        })
      }
    })


  })*/

function dismiss_button(value){

$.ajax({
  type:'POST',
  url:'/ajaxEachStockCheckSale',
  dataType:'json',
  data:{"_token": "{{ csrf_token() }}",
  "order_id":value,
},

  success:function(data){
    console.log(data);
   if(data == "l")
   {
    $('#por'+value).show();
    $('#mis'+value).hide();
   }
   
   
  
   

   
  }
});


}

$( document ).ready(function() {
    $('.preq').hide();
});
</script>
@endsection