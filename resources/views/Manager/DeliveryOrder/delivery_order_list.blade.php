@extends('master')
@section('title','Site Delivery Order List')
@section('link','Site Delivery Order List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title"><b><i>Site Delivery Order List</i></b></h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center bg-info">
                	<th>#</th>
                  <th>DO_NO</th>
                	<th>Customer Name</th>
                  	<th>Project Name</th>
                    <th>Phase Name</th>
                    
                	<th>Delivery Date</th>
                	<th>location</th>
                  @if(session()->get('user')->hasRole('Regional Warehouse'))
                  	<th>Update / Required Item</th>
                    <th>Status</th>
                  @endif
                  @if(session()->get('user')->hasRole('Project Manager'))
                  	<th>Action</th>
                  @endif
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($site_delivery_orders as $order)
                  <tr class="text-center">
                    
                  	<td>{{$i++}}</td>
                    <td>{{$order->do_no}}</td>
                    <input type="hidden" value="{{$order->id}}">
                    @if($order->purchase_order_id == null)
                    <input type="hidden" value="{{$order->material_request->user->name}}">
                    <input type="hidden" value="0">
                    <td>{{$order->material_request->user->name}}</td>
                    @else
                    <input type="hidden" value="{{$order->purchase_order->customer_name}}">
                    <input type="hidden" value="{{$order->purchase_order->phone}}">
                  	<td>{{$order->purchase_order->customer_name}}</td>
                    @endif
                    <td>{{$order->project->project_name}}</td>
                    <td>{{$order->phase->phase_name}}</td>
                    @if($order->delivery_date == null)
                    <td class="text-danger"><b>not yet</b></td>
                    <td class="text-danger"><b>not yet</b></td>
                    @else
                    <td>{{$order->delivery_date}}</td>
                    <td>{{$order->location}}</td>
                    @endif
                    @if(session()->get('user')->hasRole('Regional Warehouse'))
                    <td>
                    <a href="#" data-toggle="modal" onclick="getmidate('{{$order->id}}')" data-target="#updatedo{{$order->id}}" class="btn btn-warning">Add Info</a>
                    
                    <a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Details</a>
                  
                    <a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-success">Go to Reject List</a>
                  
                  </td>
                    @endif
                    @if(session()->get('user')->hasRole('Project Manager'))
                    
                    <td><a href="#" data-toggle="modal" data-target="#manager_item_{{$order->id}}" class="btn btn-primary">Details</a>
                    @if($order->status == 0)
                    <a href="{{route('approve_do',$order->id)}}" class="btn btn-danger">Approve</a></td>
                    @else
                    <span class="badge badge-success">Approved</span></td>
                    @endif
                    @endif
                    @if(session()->get('user')->hasRole('Regional Warehouse'))
                    @if($order->status == 0)
                    <td><span class="badge badge-warning">Pending</span></td>
                    @else
                    <td><span class="badge badge-success">Done</span></td>
                    @endif
                    @endif
                  </tr>
                  <!-- Update Modal -->
                  <div class="modal fade" id="updatedo{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Receiving Person Information</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          
                        </div>
                        <label class="offset-md-3">Material Issue Date - <span id="mi_date{{$order->id}}"> </span></label>
                        <div class="modal-body">
                          <form id="deliupdate" action="{{route('update_do_customer')}}" method="post">
                            @csrf
                            <input type="hidden" name="DOid" id="DOid" value="{{$order->id}}">
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label"><span class=""><b>Receiving Person</b></span>:</label>
                              <input type="text" class="form-control" id="receive_person{{$order->id}}" name="receive_person">
                            </div>
                            <div class="form-group">
                              <label for="message-text" class="col-form-label">Phone:</label>
                              <input type="number" class="form-control" id="phone{{$order->id}}" name="phone">
                            </div>
                            <div class="form-group">
                              <label for="message-text" class="col-form-label">Deliver Date:</label>
                              <input type="date" class="form-control" id="deliver_date{{$order->id}}" name="deliver_date">
                            </div>
                            <div class="form-group">
                              <label for="message-text" class="col-form-label">Location:</label>
                              <textarea class="form-control" id="location{{$order->id}}" name="location" rows="3"></textarea>
                            </div>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <input type="button" onclick="checkdate('{{$order->id}}')" class="btn btn-primary" value="Submit">
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- End Update Modal -->
                  <!-- Manager Details Modal -->

                  <div class="modal fade bd-example-modal-lg" id="manager_item_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          @if($order->receive_person == null)
                          
                          <h5 class="modal-title col-md-8 text-success" id="exampleModalLabel">Receive Person - <span class="text-danger">Not Yet</span></h5>
                        
                        
                          <h5 class="modal-title text-success" id="exampleModalLabel">Phone - <span class="text-danger">Not Yet</span></h5>
                          
                          @else
                          <h5 class="modal-title col-md-8 text-success" id="exampleModalLabel">Receive Person - <span class="text-dark">{{$order->receive_person}}</span></h5><br>
                          <h5 class="modal-title text-success" id="exampleModalLabel">Phone - <span class="text-dark">{{$order->phone}}</span></h5>
                          @endif
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
                            <div class="col-md-2">
                              <span>Modal</span>
                            </div>
                            <div class="col-md-2">
                              <span>Stock Quantity</span>
                            </div>
                            <div class="col-md-2">
                              <span>Reject Qty</span>
                            </div>
                            
                            
                          </div>
                          <?php $i=1; ?>
                          @foreach($delivery_order_lists as $product_list)
                          @if($order->id == $product_list->delivery_order_id)
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                            <div class="col-md-1">
                              <span>{{$i++}}</span>
                            </div>
                            <div class="col-md-3">
                              {{$product_list->product->name}}
                            </div>
                            <div class="col-md-2">
                            {{$product_list->product->brand->name}}
                            </div>
                            <div class="col-md-2">
                            {{$product_list->product->model_number}}
                            </div>
                            <div class="col-md-2">
                               
                               <span class="badge badge-success">{{$product_list->stock_qty}}</span>
                               
                            </div>
                            <div class="col-md-2">
                              @if($product_list->reject_qty == 0)
                              not yet
                              @else
                              {{$product_list->reject_qty}}
                              @endif
                            </div>
                            
                                        
                          </div>
                        <hr>
                          @endif
                          @endforeach
                        </div>
                                     
                      </div>

                    </div>
                  </div>


                  <!-- End Details Modal -->
                  <!--Details Modal -->
                  <div class="modal fade bd-example-modal-lg" id="item_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          @if($order->receive_person == null)
                          
                          <h5 class="modal-title col-md-8 text-success" id="exampleModalLabel">Receive Person - <span class="text-danger">Not Yet</span></h5>
                        
                        
                          <h5 class="modal-title text-success" id="exampleModalLabel">Phone - <span class="text-danger">Not Yet</span></h5>
                          
                          @else
                          <h5 class="modal-title col-md-8 text-success" id="exampleModalLabel">Receive Person - <span class="text-dark">{{$order->receive_person}}</span></h5><br>
                          <h5 class="modal-title text-success" id="exampleModalLabel">Phone - <span class="text-dark">{{$order->phone}}</span></h5>
                          @endif
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                          <div class="row bg-info font-weight-bold p-2">
                            <div class="col-md-2">
                              <span>Product Name</span>
                            </div>
                            <div class="col-md-2">
                              <span>Brand</span>
                            </div>
                            <div class="col-md-2">
                              <span>Modal</span>
                            </div>
                            <div class="col-md-2">
                              <span>Stock Quantity</span>
                            </div>
                            <div class="col-md-2">
                              <span>Reject Qty</span>
                            </div>
                            
                            <div class="col-md-2">
                              <span>Action</span>
                            </div>
                          </div>

                          @foreach($delivery_order_lists as $product_list)
                          @if($order->id == $product_list->delivery_order_id)
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                            <div class="col-md-2">
                              {{$product_list->product->name}}
                            </div>
                            <div class="col-md-2">
                            {{$product_list->product->brand->name}}
                            </div>
                            <div class="col-md-2">
                            {{$product_list->product->model_number}}
                            </div>
                            <div class="col-md-2">
                               <input type="hidden" id="stockqty{{$product_list->product_id}}{{$product_list->id}}" value="{{$product_list->stock_qty}}">
                               <span class="badge badge-success"><span id="stoqty{{$product_list->product_id}}{{$product_list->id}}">{{$product_list->stock_qty}}</span></span>
                               <i class="fa fa-minus-circle btnminus"  onclick="minuslist('{{$order->id}}','{{$product_list->id}}','{{$product_list->product_id}}','{{$product_list->product->brand->name}}','{{$product_list->product->model_number}}','{{$product_list->product->name}}')" id=""></i>
                            </div>
                            <div class="col-md-2">
                              @if($product_list->reject_qty == 0)
                              not yet
                              @else
                              {{$product_list->reject_qty}}
                              @endif
                            </div>
                            <div class="col-md-2">
                            
                            <button class="btn btn-danger btn-sm" onclick="deleteone('{{$order->id}}','{{$product_list->id}}','{{$product_list->product_id}}','{{$product_list->product->brand->name}}','{{$product_list->product->model_number}}','{{$product_list->product->name}}')">Delete</button>   
                                
                                
                            
                            </div>
                                        
                          </div>
                        <hr>
                          @endif
                          @endforeach
                        </div>
                                      <div class="modal-footer">
                                      
                                      <a href="#" data-toggle="modal" onclick="fillrejectitem('{{$order->id}}','{{$product_list->id}}')" data-target="#rejectitem_{{$order->id}}" class="btn btn-primary">Show Reject Product</a></td>
                                      
                                      </div>
                      </div>

                    </div>
                  </div>
                  <!-- End Detail Modal -->
                  <!-- Begin Reject Item Modal -->
                  <div class="modal fade offset-md-4" id="rejectitem_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-danger text-light">
                          <h5 class="modal-title" id="exampleModalLongTitle">Reject Items</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="row bg-info font-weight-bold p-2">
                                <div class="col-md-3">
                                  <span>Product Name</span>
                                </div>
                                <div class="col-md-2">
                                  <span>Brand</span>
                                </div>
                                <div class="col-md-2">
                                  <span>Modal</span>
                                </div>
                                <div class="col-md-4">
                                  <span>Reject Quantity</span>
                                </div>
                                
                            </div>
                            <form action="{{route('reduce_do_stock')}}" method="post">
                              @csrf
                              <input type="hidden" name="do_ID" value="{{$order->id}}">
                            <input type="hidden" name="rej_do_list_id" id="rej_do_list_id{{$order->id}}{{$product_list->id}}">
                            <input type="hidden" name="rej_product_id" id="rej_product_id{{$order->id}}{{$product_list->id}}">
                            <input type="hidden" name="rej_stock_qty" id="rej_stock_qty{{$order->id}}{{$product_list->id}}">
                            <div class="row mb-1 mt-3 font-weight-bold" id="fillreject{{$order->id}}{{$product_list->id}}" style="font-size:18px;">
                            
                            
                            </div>
                        </div>
                        <div class="modal-footer">
                          
                          <button type="submit" class="btn btn-danger" onclick="save_to_reject()">Save</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- End Reject Item -->
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

@section('js')
<script>

function deleteone(do_id,do_list_id,product_id,brand,model,product_name)
{
  var do_stock = $('#stockqty'+product_id+do_list_id).val();
  // alert(do_id+" - "+do_list_id+" - "+product_id+" - "+do_stock);
  var rejectcart = localStorage.getItem('rejectcart');
  var myrejectcartobj = JSON.parse(rejectcart);
  var rejectitemsdelete = {do_id:do_id,do_list_id:do_list_id,product_id:product_id,product_name:product_name,brand:brand,model:model,do_stock:0,reject_stock:parseInt(do_stock)};
  if(!rejectcart){
    rejectcart = '[]';
        }
         var myrejectcartobj=JSON.parse(rejectcart);
        var hasid = false;
        
        
            $.each(myrejectcartobj,function(i,v){
                // v.total_amount = total_amount;
            
                if(v.product_id == product_id)
                {
                hasid = true;
                
                if(v.do_stock == 0)
                {
                  swal({
                        'title':"Reducing Product Error!",
                        'text':"Stock Quantity is zero!",
                        'icon':"warning",

                      })
                }
                else
                {
                  v.do_stock = 0;
                  v.reject_stock = do_stock;
                }
                }
            })
            if(!hasid){
              myrejectcartobj.push(rejectitemsdelete);
            }
            localStorage.setItem('rejectcart',JSON.stringify(myrejectcartobj));
            var htmlstock = "";
            $.each(myrejectcartobj,function(i,v){
              if(v.product_id == product_id && v.do_list_id == do_list_id)
              {
              htmlstock +=`
              ${v.do_stock}
              `;
              }

            });
            $('#stoqty'+product_id+do_list_id).html(htmlstock);
}

function minuslist(do_id,do_list_id,product_id,brand,model,product_name)
{
  var do_stock = $('#stockqty'+product_id+do_list_id).val();
  // alert(do_id+" - "+do_list_id+" - "+product_id+" - "+do_stock);
  var rejectcart = localStorage.getItem('rejectcart');
  var myrejectcartobj = JSON.parse(rejectcart);
  
  
  
  var rejectitems = {do_id:do_id,do_list_id:do_list_id,product_id:product_id,product_name:product_name,brand:brand,model:model,do_stock:parseInt(do_stock) -1,reject_stock:parseInt(do_stock) - (parseInt(do_stock) -1)};
  if(!rejectcart){
    rejectcart = '[]';
        }
        var myrejectcartobj=JSON.parse(rejectcart);
        var hasid = false;
        
        
            $.each(myrejectcartobj,function(i,v){
                // v.total_amount = total_amount;
            
                if(v.product_id == product_id)
                {
                hasid = true;
                
                if(v.do_stock == 0)
                {
                  swal({
                        'title':"Reducing Product Error!",
                        'text':"Stock Quantity is zero!",
                        'icon':"warning",

                      })
                }
                else
                {
                  v.do_stock --;
                  v.reject_stock ++;
                }
                }
            })
            if(!hasid){
              myrejectcartobj.push(rejectitems);
            }
            localStorage.setItem('rejectcart',JSON.stringify(myrejectcartobj));
            
            //for only show
            var htmlstock = "";
            $.each(myrejectcartobj,function(i,v){
              if(v.product_id == product_id && v.do_list_id == do_list_id)
              {
              htmlstock +=`
              ${v.do_stock}
              `;
              }

            });
            // alert(product_id+" /// "  +do_list_id+" ---"+htmlstock);
            $('#stoqty'+product_id+do_list_id).html(htmlstock);
            //end show
}

function minus(do_list_id,product_id)
{
  // alert(product_id);
  $.ajax({
           type:'POST',
           url:'/minus_do_list_stockqty',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "do_list_id":do_list_id,
          "product_id" : product_id,
          },

           success:function(data){
            //  alert(data.product_id);
            if(data.minuserror == 1)
            {
              swal({
		          'title':"Reducing Product Error!",
		          'text':"Stock Quantity is zero!",
		          'icon':"warning",

		        })
            }
            var html = "";
            html +=`${data.stock}`;
            $('#stoqty'+data.product_id+do_list_id).html(html);
           }
          });

}

function checkdate(do_id)
{
  // alert(wto_id);
  var do_id = do_id;
  var deliver_date = $('#deliver_date'+do_id).val();
  $.ajax({
           type:'POST',
           url:'/check_deliver_date',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "do_id":do_id,
          "deliver_date" : deliver_date,
          },

           success:function(data){
             if(data.checked == "success")
             {
                $('#deliupdate').submit();
             }
             else
             {
              swal({

                  title:"Date Wrong Error!",
                  text:"Delivery Order Date is "+data.diffmi+" days later than Material Issue Date! And "+data.diffwto+" days is earlier than Warehouse Transfer Order date",
                  icon:"error",

                  });
             }

           }
        });
}

function fillrejectitem(do_id,do_list_id)
{
  // alert("Reject");
  var rejectcart = localStorage.getItem('rejectcart');
  var myrejectcartobj = JSON.parse(rejectcart);
  var do_list_id_arr = [];
  var do_product_id_arr = [];
  var do_reject_stock_arr = [];
  var htmlfill = "";
  $.each(myrejectcartobj,function(i,v){
    htmlfill += `
                            <div class="col-md-3">
                            <input type="hidden" name="rej_do_list_id" value="${v.do_list_id}">
                              <input type="hidden" name="rej_product_id" value="${v.product_id}">
                              ${v.product_name}
                            </div>
                            <div class="col-md-2">
                              ${v.brand}
                            </div>
                            <div class="col-md-2">
                              ${v.model}
                            </div>
                            <div class="col-md-4">
                            <input type="hidden" name="rej_stock_qty" value="${v.reject_stock}">
                               ${v.reject_stock}
                            </div>
    
    `;
do_list_id_arr.push(v.do_list_id);
do_product_id_arr.push(v.product_id);
do_reject_stock_arr.push(v.reject_stock);

   
  });
  $('#rej_do_list_id'+do_id+do_list_id).val(JSON.stringify(do_list_id_arr));
    $('#rej_product_id'+do_id+do_list_id).val(JSON.stringify(do_product_id_arr));
    $('#rej_stock_qty'+do_id+do_list_id).val(JSON.stringify(do_reject_stock_arr));
  
  $('#fillreject'+do_id+do_list_id).html(htmlfill);
  

}
$( document ).ready(function() {
    localStorage.clear();
});

function getmidate(do_id)
{
  // alert("hellll");
  $.ajax({
           type:'POST',
           url:'/get_mi_date',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "do_id":do_id,
          
          },

           success:function(data){
              // alert(data);
              var htmldate = "";
              htmldate += `<span class="badge badge-danger">${data}</span>`;
              $('#mi_date'+do_id).html(htmldate);
           }
  });

}

function save_to_reject()
{
  
}


</script>


@endsection