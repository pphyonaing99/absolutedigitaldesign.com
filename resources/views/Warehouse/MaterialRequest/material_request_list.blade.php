@extends('master')
@section('title','Material Request List')
@section('link','Material Request List')
@section('content')

<div class="row">
        <input type="hidden" id="request" value="{{$material_requests}}">
        <input type="hidden" id="products" value="{{$products}}">
        <div class="col-12">
          <div class="card">
            <div>
                  <div class="row">
                    <div class="col-md-9">
                    <h3 class="card-title mr-5 ml-3">Material Request Lists</h3>
                    </div>
                    <div class="col-md-3">
                    <label >Prefix Syntax -</label><span class="p-2 ml-2 mr-3 badge badge-danger text-center">{{$prefix}}</span>
                    <label >Syntax Digit -</label><span class="p-2 ml-2 badge badge-danger text-center">{{$digit}}</span>
                    </div>
                  </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <input type="hidden" id="prefix" value="{{$prefix}}">
              <input type="hidden" id="digit" value="{{$index}}">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center bg-info">
                	<th>#</th>
                	<th>Request Code</th>
                	<th>Request Date</th>
                  	<th>Stock Check</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($material_requests as $request)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$request->request_code}}</td>
                  	<td>{{$request->request_date}}</td>
                  	@if($request->warehouse_status == 0 && $request->purchase_flag != 1)
                    <td><a href="#" data-toggle="modal" onclick="dismiss_button('{{$request->id}}')" data-target="#item_{{$request->id}}" class="btn btn-primary">Check Stock</a></td>
                    @elseif($request->warehouse_status != 0 && $request->purchase_flag != 1)
                    <td><span class="p-2 badge badge-success">Finished Material issued</span></td>
                    @elseif($request->purchase_flag == 1)
                    <td><a href="#" data-toggle="modal" data-target="#pureq_{{$request->id}}"><span class="p-2 badge badge-danger">Purchase Requested</span></a></td>
                    @endif
                   
                  </tr>
                  
                  <!--Check Stock -->
                  <div class="modal fade" id="item_{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <?php $required_qty = 0;$required =0; ?>
                          @foreach($products as $product)
                          @foreach($material_request_lists as $request_list)
                          @if($request->id == $request_list->material_request_id && $product->id == $request_list->product_id)
                          <?php
                            $stock_qty = $product->stock_qty - $request_list->request_qty;
                            $new_qty = $request_list->request_qty - $product->stock_qty;
                            if ($request_list->request_qty < $product->stock_qty) {
                              $required_qty = 0;
                             
                            }elseif($request_list->request_qty > $product->stock_qty){
                               $required_qty  = $request_list->request_qty - $product->stock_qty;
                            }
                            
                          ?>
                          <input type="hidden" id="req" value="{{$required_qty}}">
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                            <div class="col-md-3">
                              {{$request_list->product->name}}
                            </div>
                            <div class="col-md-3">
                               {{$request_list->request_qty}}
                            </div>
                            <div class="col-md-3">
                               {{$product->stock_qty}}
                            </div>
                            <div class="col-md-3">
                              @if( $new_qty > 0 )
                               <span class="badge badge-danger">{{$new_qty}}</span>
                              @else
                              <span class="badge badge-success">0</span>
                              @endif
                            </div>
                          </div>
                          <hr>
                          <?php $required += $required_qty; ?>
                          @endif
                          @endforeach
                          @endforeach
                           
                           <a href="{{route('warehouse_pr_create',$request->id)}}" id="por{{$request->id}}" class="btn btn-danger preq">Purchase Request</a>
                           
                           <a href="#" onclick="sale_order('{{$request->id}}')" class="btn btn-primary pull-right" id="mis{{$request->id}}">Material Issue</a>
                           
                        </div>
                      </div>
                    </div>
                  </div>
                  @if($request->purchase_flag == 1)
                  
                  <div class="modal fade" id="pureq_{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Purchase Request</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        
                        <div class="modal-body">
                        
                        @foreach($products as $productsss)
                       
                        @foreach($true_request as $req_pro)
                        @if($request->id == $req_pro->material_request_id)
                        @if($productsss->id == $req_pro->product_id)
                        
                        <span class="text-danger">{{$productsss->name}}</span>&nbsp;&nbsp;&nbsp;<span>product is requesting because</span><span class="text-danger">&nbsp;&nbsp;{{$req_pro->stock_qty}}</span>&nbsp;&nbsp;stocks is required!!!<br>
                        @endif
                        @endif
                        @endforeach
                        
                        @endforeach
                        
                        </div>
                        
                        
                      </div>
                    </div>
                  </div>
                 
                  @endif
                  
                  <!-- end purchase req for only show -->
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <!-- Purchase req for only show modal -->
     
      </div>
<!-- page script -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
    

  // function dismiss_button(request_id){

  //   var required_qty = {!! json_encode($required) !!};
  // //  var re = $('#reqq').val();
  // console.log(required_qty);

    
  //   // alert(required_qty);
  //   if(required_qty == 0){
  //     $('#po_'+request_id).remove();
  //   }

  // }


  function dismiss_button(request_id){

    $.ajax({
      type:'POST',
      url:'/ajaxEachStockCheck',
      dataType:'json',
      data:{"_token": "{{ csrf_token() }}",
      "request_id":request_id,
    },

      success:function(data){
        console.log(data);
        alert(data);
       if(data == "l")
       {
        $('#por'+request_id).show();
        $('#mis'+request_id).hide();
       }
       
       
      
       

       
      }
    });


  }

  function sale_order(material_request_id){
    
    var prefix = $('#prefix').val();
    var digit = $('#digit').val();
    
    $.ajax({
      type:'POST',
      url:'/ajaxSendMaterialIssue',
      dataType:'json',
      data:{"_token": "{{ csrf_token() }}",
      "material_request_id":material_request_id,
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
      }
    });

  }


  /*$("#sale_order").on('click','.check_stock',function(){

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
                text:"Item Name : "+product.name+"\n Request Qty : "+sale_order.stock_qty+"\n In Stock Qty : "+product.stock_qty+"\n Required Qty : "+required_qty,
                icon:"success",
              })

          }
        })
      }
    })


  })*/

  $( document ).ready(function() {
    $('.preq').hide();
});

</script>
@endsection