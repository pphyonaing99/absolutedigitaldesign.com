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
                  <th>PO No</th>
                  <th>Supplier</th>
                 
                  <th>Total Qty</th>
                  <th>Sent Mail</th>
                  <th>Action</th>
                  <th>Status</th>
                  
                  
                 
                </thead>
                @foreach($supplier as $sup)
                <tbody>
                  <?php $i = 1;?>
                  @foreach($purchase_orders as $order)
                  @if($sup->id == $order->supplier_id)
                 
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$order->po_no}}</td>
                    <td>{{$sup->name}}</td>
                    
               
                <td>{{$order->total_qty}}</td>
                @if($order->mail_sent == 0 && $order->approve == 0)
                    <!-- <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#send_{{$order->id}}_mail">Send Email</a></td> -->
                    
                    
                    <td><span class="badge badge-warning">Waiting</span></td>
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Details</a>
                    <input type="button" class="btn btn-dark" disabled="disabled" value="Send Mail">
                   
                  </td>
                  <td><span class="badge badge-warning">Wating</span></td>
                    @elseif($order->approve == 1)
                    @if($order->mail_sent == 1)
                    <td><span class="badge badge-success">Sent</span></td>
                    @else
                    <td><span class="badge badge-warning">Wating</span></td>
                    @endif
                    <td><a href="#" data-toggle="modal" data-target="#item_{{$order->id}}" class="btn btn-primary">Details</a>
                    <a href="#" onclick="showmail('{{$order->id}}')" id="sendd" data-toggle="modal" data-target="#send_{{$order->id}}_mail" class="btn btn-success">Send Mail</a>
                    
                  </td>
                  <td><span class="badge badge-success">Done</span></td>
                    <!-- @elseif($order->approve == 1 && $order->mail_sent == 1) -->
                    <!-- <td><span class="badge badge-success">Mail Sent</span></td> -->
                    <!-- <td>b</td> -->
                    @endif
                    
                    
                    
                  </tr>
                  @endif
                  <!-- Send Mail Modal -->
                
                    <div class="modal fade bd-example-modal-lg" id="send_{{$order->id}}_mail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send Mail To Supplier</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">

                            <!-- <input type="text" id="prcheckdate{{$order->id}}" name="prcheckdate"> -->

                            <form>
                              <div class="form-group">
                              <input type="hidden" value="{{$order->id}}" id="oid">
                                <input type="hidden" id="pono" name="ponoo" value="{{$order->po_no}}">
                                <input type="hidden" id="poid" value="{{$order->id}}">
                                <label for="recipient-name" class="col-form-label">Supplier Email:</label>
                                <input type="text" class="form-control" id="email{{$order->id}}" name="email">
                              </div>
                              <div class="form-group">
                                <label for="message-text" class="col-form-label">Required Date:</label>
                              <input type="date" class="form-control" id="req_date{{$order->id}}" name="req_date" onchange="subdate('{{$order->id}}')">
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Subject:</label>
                                <input type="text" class="form-control" id="recipient-name{{$order->id}}" name="subject">
                              </div>
                              <div class="form-group">
                                 <label for="message-text" class="col-form-label">Mail Sample:</label>
                                 <div class="card">
                                      <div class="card-body">
                                  <!-- mail example -->
                                  
                                  <h3 style="text-align: center;font-weight: bold;">Dear<span id="sup_name{{$order->id}}"></span></h3>

                                  

                                  <h5 style="text-align:center"><i>We would like to Order this items</i></h5>
                                          <div class="row">
                                              <div class="col-md-2">
                                                
                                              </div>
                                              <div class="col-md-8">
                                                <div class="row bg-info font-weight-bold p-2 align-center text-center">
                                                    <div class="col-md-2">
                                                        <span>#</span>
                                                      </div>
                                                      <div class="col-md-3">
                                                        <span>Product Name</span>
                                                      </div>
                                                      <div class="col-md-3">
                                                        <span>Brand</span>
                                                      </div>
                                                      <div class="col-md-3">
                                                        <span>Quantity</span>
                                                      </div>
                                                      </div>
                                                      <?php $i=1; ?>
                                                      @if($order->item_list != null)
                                                    
                                                      @foreach($purchase_orders_lists as $product_req)
                                                      @if($product_req->officer_purchase_order_id == $order->id)
                                                      <div class="row bg-secondary font-weight-bold p-2 align-center text-center">
                                                          <div class="col-md-2">
                                                              {{$i++}}
                                                            </div>
                                                            <div class="col-md-3">
                                                              {{$product_req->product->name}}
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                            {{$product_req->product->brand->name}}
                                                            </div>
                                                            <div class="col-md-3">
                                                            {{$product_req->order_qty}}
                                                            </div>
                                                            
                                                          
                                                          </div>
                                                            
                                                        @endif
                                                       @endforeach
                                                          
                                                      @endif

                                                      <!-- endddd -->
                                                
                                              </div>
                                              <div class="col-md-2"></div>
                                          </div>
                                  <!-- end mail example -->
                                  <p style="text-align:left" class="text-info mt-3"><span id="date">Please deliver the products by this date <span id="indate{{$order->id}}" class="text-danger"></span> before!!</span></p>
                                  <h5><b>Best Regards,</b></h5>
                                        </div>
                                 </div> 
                              </div>
                              <input type="button" onclick="sending('{{$order->id}}','{{$order->po_no}}')" class="btn btn-info float-right" name="btnsubmit" value="Send">
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                  <!--Details Modal -->
                  <div class="modal fade bd-example-modal-lg" id="item_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Warehouse Purchase Order</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                          <div class="row bg-info font-weight-bold p-2">
                          <div class="col-md-1">
                              <span>#</span>
                            </div>
                            <div class="col-md-2">
                              <span>Product Name</span>
                            </div>
                            <div class="col-md-2">
                              <span>Model</span>
                            </div>
                            <div class="col-md-2">
                              <span>Brand</span>
                            </div>
                            <div class="col-md-2">
                              <span>Request Qty</span>
                            </div>
                            <div class="col-md-3">
                              <span>Purchase Request No</span>
                            </div>
                            
                          </div>
                    <?php $i=1; ?>
                          @if($order->item_list != null)
                         
                          @foreach($purchase_orders_lists as $product_req)
                          @if($product_req->officer_purchase_order_id == $order->id)
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                          <div class="col-md-1">
                              {{$i++}}
                            </div>
                            <div class="col-md-2">
                              {{$product_req->product->name}}
                            </div>
                            <div class="col-md-2">
                              {{$product_req->product->model_number}}
                            </div>
                            <div class="col-md-2">
                            {{$product_req->product->brand->name}}
                            </div>
                            <div class="col-md-2">
                            {{$product_req->order_qty}}
                            </div>
                            <div class="col-md-2 text-center">
                            {{$product_req->purchase_request_no}}
                            </div>
                           
                          </div>
                            <hr>
                          @endif
                          @endforeach
                          
                          @endif
                        </div>
                        <div class="modal-footer">
                        @if($order->mail_sent == 0 && $order->approve == 0)
                        <input type="button" class="btn btn-dark" disabled="disabled" value="Send Mail">
                            
                        @elseif($order->approve == 1)
                        <a href="#" onclick="modalclick('{{$order->id}}')" data-toggle="modal" data-target="#send_{{$order->id}}_mail" class="btn btn-success">Send Mail</a>
                        @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </tbody>
                @endforeach
              </table>
            </div>
            <!-- /.card-body -->
           
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
<!-- page script -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script>

function showmail(value) {
//   alert(value);
 
  $.ajax({
      type:'POST',
      url:'/getsupplieremail',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'po_id' : value,
      },
      success:function(data){
        // $('#prcheckdate'+value).val(data.prcheckdate);
        // alert(data);
        $('#email'+value).attr('value',data.supplier_email);
       
        var htmlsup = "";
        htmlsup += `
        ${data.supplier_name}
        `;
        $('#sup_name'+value).html(htmlsup);
      }

      });
  
  
  
  
};


$("#sendd").click(function(){
 
});

function subdate(value){
var mail_date = $('#req_date'+value).val();
var htmldate = "";
htmldate +=`
${mail_date}
`;
$('#indate'+value).html(htmldate);

}


function modalclick(value){
//   alert("are you sure!");
  $('#item_'+value).hide();
  $('.modal-backdrop').hide();
  $.ajax({
      type:'POST',
      url:'/getsupplieremail',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'po_id' : value,
      },
      success:function(data){

        // alert(data);
        $('#email'+value).attr('value',data);
       
      }

      });
  
  
  
  
};
    
    function sending(pid,po_no){
       
      
        
      
        
       
        // var check_pr_date = $('#prcheckdate'+pid).val();
        var email = $('#email'+pid).val();
        // alert(email);
        // var subject = $.trim($("#subject").val());
        var subject = $('#recipient-name'+pid).val();
        var req_date = $('#req_date'+pid).val();
        // var body = $.trim($("#body").val());
        var body = $('#message-text'+pid).val();
        console.log(email);
        $.ajax({
          type:"POST",
          url:"/SendMailSupplier",
          dataType:"json",
          data:{
            "_token":"{{csrf_token()}}",
            "po_id" : pid,
            "po_no" : po_no,
            "email" : email,
            "subject" : subject,
            "body" : body,
            "req_date":req_date,
            
          },
          success:function(data){
            console.log(data);
            if(data.latee == 1)
            {
              swal({
              title:'error',
              text:"Your PO date is "+data.late+" days later than PR's date",
              icon:'error',

            })
            }
            else
            {
              $('#sendEmail').hide();
            $('.modal-backdrop').hide();
            swal({
              title:'Success',
              text:"Successfully Send Email",
              icon:'success',

            })
            localStorage.clear();
            // setTimeout(function(){
            //   window.location.reload();
            // },1000);
          }
        }
        })
    }
    
    
    
    
</script>
@endsection







