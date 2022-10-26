@extends('master')
@section('title','Purchase Request List')
@section('link','Purchase Request List')
@section('content')
<style type="text/css">
  i{
    cursor: pointer;
  }

</style>
<div class="card shadow">
    <div class="row">
      <div class="col-6">
          <div class="card-header">
            <h3 class="card-title"><span class="bg-light">Purchase Request </span><b>To</b> <span class="text-danger">Purchase Order</span></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>PR No</th>
                  <th>Required Date</th>
                  <th>Warehouse</th>
                  <th>Priority</th>
                </tr>
              </thead>
                
              <tbody>
                @foreach($purchase_requests as $request)
               
                  <tr data-toggle="collapse" data-target="#accordion_{{ $request->id }}" class="clickable" style="cursor: pointer;user-select: none;">
                      <td>{{ $request->pr_no }}</td>
                      <td>{{ $request->required_date }}</td>
                      @if($request->destination_flag == 1)
                      <td>Main</td>
                      @endif
                      @if($request->destination_flag == 2)
                      <td>{{$request->regional_name}}</td>
                      @endif
                      @if($request->destination_flag == null)
                      <td>Site</td>
                      @endif
                      <td>{{ $request->priority }} <span class="float-right"><i class="fas fa-arrow-circle-down text-primary"></i></span></td>
                  </tr>
                  
                  <tr>
                      <td colspan="4">
                          <div id="accordion_{{ $request->id }}" class="collapse">
                            <h4>Product List</h4>
                            
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th>Product Name</th>
                                  <th>Brand</th>
                                  
                                  <th>Quantity</th>
                                  
                                  <th>Action</th>
                                </tr>
                              </thead>
                            <tbody>
                            <?php $i=1; ?>
                           
                            @foreach($purchase_request_lists as $request_list)
                            
                              @if($request->id == $request_list->warehouse_purchase_order_id )
                              
                              
                             
                              <tr>
                                <input type="hidden" class="ID" value="{{$request_list->product->id}}">
                                <input type="hidden" value="{{$request_list->product->minimum_order_qty}}">
                                <input type="hidden" value="{{explode('-',$request_list->product->purchase_price)[0]}}">
                                <input type="hidden" value="{{$request->id}}">
                                <input type="hidden" value="{{$request_list->stock_qty}}">
                                <input type="hidden" id="check">
                                
                                <input type="hidden" value="{{$request->pr_no}}">
                                <input type="hidden" value="{{$request->destination_flag}}">
                                <input type="hidden" value="{{$request->regional_name}}">
                                <input type="hidden" value="{{$request->project_id}}">
                                <input type="hidden" value="{{$request->phase_id}}">
                                <input type="hidden" value="{{$request->destination_regional_id}}">
                                <input type="hidden" value="{{$request->pr_no}}">
                                <input type="hidden" value="{{$request->required_date}}">
                                <th scope="row">{{$i++}}</th>
                                <td scope="row">{{ $request_list->product->name }}</td>
                                <td scope="row">{{$request_list->product->brand->name}}</td>
                               
                                @if($request_list->officer_sent_status == null)
                                <td scope="row" class="text-center">{{ $request_list->stock_qty }}</td>
                                
                               
                                <td><i class="btn btn-primary btn_addtocart" data-id="{{$request->id}}" data-name="{{$request_list->product->id}}" data-qty="${subitem.stock_qty}" id="tgPanel{{$request->id}}{{$request_list->product->id}}" onclick="tgPanel(this)" style="cursor: pointer;" ><i class="fas fa-plus"></i> Add</i></td>
                                @else
                                <td scope="row" class="text-center">{{ $request_list->now_qty }}</td>
                                <td scope="row"><span class="text-success">Ordered</span></td> 
                                @endif
                              </tr>
                             
                              
                              @endif
                              
                           
                             
                             @endforeach
                            </tbody>
                          </table>
                          
                        </div>
                      </td>
                  </tr>
                  
                  @endforeach
              </tbody>
             
              </table>

          </div>

          
          <!-- /.card-body -->
        </div>
        <div class="col-md-6">
          <div class="card shadow mt-3 mr-3">
            <div class="card-header">
                <div class="alert alert-warning" role="alert" id="errr" class="text-center">
                  <span id="shower"></span>
                  
                </div>
              <div class="row">

                <div class="col-md-6">
                  <h3 class="font-weight-bold mt-3 text-info">Choose Supplier : </h3>
                </div>
                
                <input type="hidden" id="totalqty" name="totalqty">
                <input type="hidden" name="parr[]" id="parray">
                <div class="col-md-6">
                  <select class="form-control mt-3" name="supplier_id" onchange="getSupplierProductList(this.value)">
                  <option value="0">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                      <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                    @endforeach
                  </select>
                  <div class="row p-2 m-2 float-right" id="supplierProductList">
                  
                </div>
                </div>
              </div>
              
              <a href="#" class="btn btn-primary btn-sm float-right mb-3" onclick="NewPO()">Open New PO</a>
              <div class="row" id="new_po"></div>
              
              
           
            </div>
           
           
          
            <div class="card-body">
              <table id="SupplierProduct" class="table table-bordered">
                <thead class="text-center">
                  <th>Product Name</th>
                  <th>Stock Quantity</th>
                  <th>Min Order Qty</th>
                  <th>Price</th>
                  <th>Total Price</th>
                  
                </thead>
                <tbody id="supplier_product" class="text-center">
                </tbody>
              </table>
              <div class="row mt-3 justify-content-between">
                <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#sendEmail">Send Mail</a> -->
                <!-- <a href="#" class="btn btn-primary btn-email">Send Email</a> -->
                <a href="#" class="btn btn-secondary offset-md-5" id="checkDetailclone">Check Details</a>
                <a href="#" class="btn btn-danger btn-check offset-md-5" id="checkDetail">Check Details</a>
                <!-- <a href="#" class="btn btn-success btn-save float-right">Save Order</a> -->
                <a href="#" class="btn btn-success btn-submit offset-md-5">Save Order</a>
              </div>
            </div>
            
          </div>
        </div>
        <!-- /.card -->
      </div>
    <!-- /.col -->
</div>
<!-- page script -->
<!-- jQuery -->

<!-- supplier Proddut Modal -->
<div class="modal fade" id="supplierProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="supplier_name"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row bg-info font-weight-bold p-2">
          <div class="col-md-4">
            <span>Product Name</span>
          </div>
          <div class="col-md-4">
            <span>Brand Name</span>
          </div>
          <div class="col-md-4 text-center">
            <span>Minimum Order Quantity</span>
          </div>
          <hr class="bg-white">
        </div>

        <div class="row p-2 m-2" id="productList">
          
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
@foreach($purchase_requests as $request)
<div class="modal fade emailsend" id="sendEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Mail To Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Supplier Email:</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
          <!-- <input type="hidden" id="test_date" name="test_pr_date"> -->
            <label for="message-text" class="col-form-label">Required Date:</label>
           <input type="date" class="form-control" id="req_date" name="req_date">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Subject:</label>
            <input type="text" class="form-control" id="recipient-name" name="subject">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Body Text:</label>
            <textarea class="form-control" id="message-text" name="body_text"></textarea>
          </div>
          <input type="submit" class="btn btn-primary btn-mail float-right" name="btnsubmit" value="Send">
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection
@section('js')
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="text/javascript">

$( document ).ready(function() {
    $('.btn-submit').hide();
    $('#errr').hide();
    $('#checkDetail').hide();
})

    getSupplierProductList = (supplier_id) => {

      if(supplier_id == 0)
      {
        $('#checkDetail').hide();
        $('#checkDetailclone').show();
        $('.btn-submit').hide();
      }
        $('#supplierProductList').empty();
        let html = '';
        let html2 = '';
        
        $.ajax({
            type:'POST',
            url:'/getSupplierProduct',
            dataType:'json',
            data:{
                "_token":"{{csrf_token()}}",
                'supplier_id' : supplier_id,
            },
            success:function(data) {
             $('#checkDetail').show();
             $('#checkDetailclone').hide();
              var parray = [];
              var mysupplier = localStorage.getItem('mysupplier');
              
                html += `<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#supplierProduct" >Product</a>`;
                $('#supplierProductList').html(html);
                
                $.each(data.products, function(i, product) {
                
                  $.each(data.brands, function(i, brand) {
                    if (brand.id == product.brand_id) {
                
                      html2 += `<div class="col-md-4 p-2">
                                  
                                  <span>${product.name}</span>
                                </div>
                                <div class="col-md-4 p-2">
                                  
                                  <span>${brand.name}</span>
                                </div>
                                <div class="col-md-4 p-2 text-center">
                                  <span>${product.minimum_order_qty}</span>
                                </div><hr class="text-dark">`;
                      $('#productList').html(html2);
                      
                      // console.log(html2);
                      var pname = product.name;
                      parray.push(pname);
                     
                    }
                });
        
              });
              console.log(parray);
              $('#parray').val(supplier_id);
            }
        })
    }
  
  function NewPO(){
    var html = '';
    var html2 = '';
    var supplier_id = $("select[name=supplier_id]").val();
    
    $.ajax({
      type:'POST',
      url:'/createNewPO',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'supplier_id' : supplier_id,
        
      },
      success:function(data){
        
        $('#email').attr('value',data.supplier_email);
        $('#supplier_name').text(data.supplier_name);


        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        html += `<div class="col-md-6">
                  <label>PO NO</label><input class="form-control" name="po_no" disabled="disabled" type='text' value="${data.purchase_order.po_no}" >
                </div>
                
                
                `;
        $('#new_po').html(html);

        $.each(data.products, function(i, product) {

          $.each(data.brands, function(i, brand) {
            if (brand.id == product.brand_id) {

              html2 += `<div class="col-md-6 p-2">
                          <span>${product.name}</span>
                        </div>
                        <div class="col-md-6 p-2 text-center">
                          <span>${product.minimum_order_qty}</span>
                        </div><hr class="text-dark">`;
              $('#productList').html(html2);
              
            }
        });

      });


      }    
    })

  }

 



  $("#supplier_product").on('click','.btnplus',function(){

        console.log("increased");
        var id=$(this).data('id');
        console.log(id);
        count_change_plus(id,'+');

    })
    $("#supplier_product").on('click','.btnminus',function(){

        console.log("Decrease");
        var id=$(this).data('id');
        console.log(id);
        count_change_minus(id,'-');

    })

    function count_change_plus(id,action){
        var mycart=localStorage.getItem('mycart');
        var myprcart=localStorage.getItem('prcart');
        var mycartobj=JSON.parse(mycart);
        var myprcartobj=JSON.parse(myprcart);

       
        

        
          if(myprcartobj[id].qty >= myprcartobj[id].request_qty)
           {
            swal({
           title:'Error',
           text: "Request Quantity is "+myprcartobj[id].request_qty+" Request Qty is less than Order Qty",
           icon:'error',

         })
          return false;

           }

            myprcartobj[id].qty++;
        
           
           


       
            mycartobj[id].amount+=mycartobj[id].purchase_price;

            mycartobj[id].qty++;
      
        localStorage.setItem('mycart',JSON.stringify(mycartobj));
        localStorage.setItem('prcart',JSON.stringify(myprcartobj));
            count_item();
            showmodal();
      
      }

      function count_change_minus(id,action){
        var mycart=localStorage.getItem('mycart');
        var myprcart=localStorage.getItem('prcart');
        var mycartobj=JSON.parse(mycart);
        var myprcartobj=JSON.parse(myprcart);

       
        // alert(myprcartobj.length);

        
           
            
            myprcartobj[id].qty--;
            if(myprcartobj[id].qty<1){
              // alert("one");
                var ans=confirm('Are you sure from '+myprcartobj[id].req_name);
            if(ans){
              if(myprcartobj.length == 1)
                {
                  setTimeout(function(){
              window.location.reload();
            },1000);
                }
                myprcartobj.splice(id,1);
              
            }else{
                myprcartobj[id].qty;           
            }
          }
        


       
            mycartobj[id].amount-=mycartobj[id].purchase_price;
            mycartobj[id].qty--;
            if(mycartobj[id].qty<1){
              // alert("two");
                // var ans=confirm('Are you sure');
                
            // if(ans){
              if(mycartobj.length == 1)
              setTimeout(function(){
              window.location.reload();
            },1000);
                mycartobj.splice(id,1);
              
            // }else{
                // mycartobj[id].qty;           
            // }
          }
        
        localStorage.setItem('mycart',JSON.stringify(mycartobj));
        localStorage.setItem('prcart',JSON.stringify(myprcartobj));
            count_item();
            showmodal();
      
      }


    $("#item_list").on('click','.btndelete',function(data){
        var id=$(this).data('id');

        var ans=confirm('Are you Sure?');
        if(ans){
          var mycart = localStorage.getItem('mycart');
          var mycartobj = JSON.parse(mycart);
          mycartobj.splice(id,1);
          localStorage.setItem('mycart',JSON.stringify(mycartobj));
          count_item();

          showmodal();
        }
    })

    var sub_total = 0;
    var total_amount = 0;

    function tgPanel(i) {
        
        var tr = i.parentElement.parentElement;
        // var item_id = tr.getElementsByTagName("td")[0];
        var id = tr.getElementsByTagName("input")[0].value;
        
        var min = tr.getElementsByTagName("input")[1].value;
        var purchase_request_id = tr.getElementsByTagName("input")[3].value;
        var request_qty = tr.getElementsByTagName("input")[4].value;
        var pr_no = tr.getElementsByTagName("input")[6].value;
        // alert("hello");
        var ware_flag = tr.getElementsByTagName("input")[7].value;
        var regional_name = tr.getElementsByTagName("input")[8].value;
        var proj_id = tr.getElementsByTagName("input")[9].value;
        var phase_id = tr.getElementsByTagName("input")[10].value;
        var regional_id = tr.getElementsByTagName("input")[11].value;
        var request_name = tr.getElementsByTagName("input")[12].value;
        var request_date = tr.getElementsByTagName("input")[13].value;
        //  alert(request_date);
        var purchase_price = parseInt(tr.getElementsByTagName("input")[2].value);
        var name = tr.getElementsByTagName("td")[0].innerText;
        console.log(name);
        console.log(id);
        console.log(min);
        console.log(purchase_price);
        total_amount += purchase_price;
        var mycart = localStorage.getItem('mycart');
        var prcart = localStorage.getItem('prcart');
        var mycartobj=JSON.parse(mycart);
        var myprcartobj=JSON.parse(prcart);
   //begin 
   var hasid = false;
   $.each(myprcartobj,function(i,v){
      if(myprcartobj[i].id == id && myprcartobj[i].requestID == purchase_request_id && myprcartobj[i].qty == myprcartobj[i].request_qty)
      {
        // alert("hello1");
        hasid = true;
        v.qty-1;
        swal({
           title:'Error',
           text: "Request Quantity is "+myprcartobj[i].request_qty+" Request Qty is less than Order Qty",
           icon:'error',

         })
         document.getElementById('tgPanel'+req_id+pro_id).onclick = null;
        
      }
    

    });
     
        //end
       var items = {id:id,name:name,requestID:purchase_request_id,req_name:request_name,request_date:request_date,ware_flag,regional_id:regional_id,reg_name:regional_name,project_id:proj_id,phase_id:phase_id,prno:pr_no,request_qty:request_qty,qty:1};
        var item={id:id,name:name,min_order_qty:min,purchase_price:purchase_price,amount:purchase_price,total_amount:total_amount,qty:1};
        var mycart = localStorage.getItem('mycart');
        var prcart = localStorage.getItem('prcart');
        
        if(!mycart){
          mycart = '[]';
        }
        if(!prcart){
          prcart = '[]';
        }
        var mycartobj=JSON.parse(mycart);
        var myprcartobj=JSON.parse(prcart);

     
        var hasid = false;
        $.each(myprcartobj,function(i,v){
            // v.total_amount = total_amount;
            if(v.requestID == purchase_request_id && v.id == id)
            {
              hasid = true;
              v.qty++;
            }
        })
        if(!hasid){
          myprcartobj.push(items);
        }
      
        
        var hasid = false;
        $.each(mycartobj,function(i,v){
            v.total_amount = total_amount;
            
            if(v.id == id){
                hasid = true;
                v.amount+=purchase_price
                v.qty++;
            }
        })
        if(!hasid){
          mycartobj.push(item);
        }

        var total = 0;
          $.each(mycartobj,function(i,v){

                 total += parseInt(v.qty);

          });
         console.log(total);
         $('#totalqty').val(total);
        
        
        localStorage.setItem('mycart',JSON.stringify(mycartobj));
        localStorage.setItem('prcart',JSON.stringify(myprcartobj));
        showmodal();
    }

    
    function showmodal(){
        
        var mycart = localStorage.getItem('mycart');
        
        if(mycart){
          var mycartobj = JSON.parse(mycart);
          var html=''; var j=1; var total=0;

            if(mycartobj.length>0){

            $.each(mycartobj,function(i,v){
                var id=v.id;
                var name=v.name;
                var qty=v.qty;
                var mini = v.min_order_qty

            html+=`<tr class="text-center">
                    <td><span id="errorname${id}">${name}</span></td>
                    <td><i class="fa fa-plus-circle btnplus" data-id=${i}></i>  ${qty}  <i class="fa fa-minus-circle btnminus" data-id=${i}></i></td>
                    <td class="bg-light in1"><span id="error${id}">${mini}</span></td>
                    <td>${v.purchase_price}</td>
                    <td>${v.amount}</td>
                    </tr>`;
                    j++;
              });

              $("#supplier_product").html(html);

            }
        }

    }
    function count_item(){

        var mycart = localStorage.getItem('mycart');

        if(mycart){
            
            var mycartobj = JSON.parse(mycart);
            var total_count = 0;

            $.each(mycartobj,function(i,v){

                total_count+=v.qty;

            })

            $(".item_count_text").html(total_count);

        }else{

            $(".item_count_text").html(0);

        }
    }

    $('.btn-check').click(function(e){
      e.preventDefault();
      var psup = $('#parray').val();
      
      
      console.log(psup);
      // Begin
      $.ajax({
            type:'POST',
            url:'/getSupplierProduct',
            dataType:'json',
            data:{
                "_token":"{{csrf_token()}}",
                'supplier_id' : psup,
            },
            success:function(data) {
             
              var parray = [];
             
              
               
                
                $.each(data.products, function(i, product) {
                
                  $.each(data.brands, function(i, brand) {
                    if (brand.id == product.brand_id) {
                
                   
                      
                      // console.log(html2);
                      var pname = product.name;
                      parray.push(pname);
                     
                    }
                });
        
              });
            
              console.log(parray);
              
              // sub begin
              $.each(mycartobj,function(i,v){
        if(parray.includes(v.name))
        {
         
         $('#errr').hide();
         document.getElementById('errorname'+v.id).style.color = 'black';
        }
        else{
          var html = "";
          html += `The ${v.name} product is not support by this supplier`;
          $('#shower').html(html);
          console.log(v.name);
          $('#errr').show();
          $('.btn-submit').hide();
          $('.btn-check').show();
          document.getElementById('errorname'+v.id).style.color = 'red';
         
          return false;
        }
        
       
      });
              // end 
            }
          });
          
         

      //End
      
      
      var mycart = localStorage.getItem('mycart');
      var mycartobj = JSON.parse(mycart);
      
      $.each(mycartobj,function(i,v){
        if(v.qty < v.min_order_qty)
        {
         
          var j = true;
          document.getElementById('error'+v.id).innerHTML=v.min_order_qty+"  is required";
          document.getElementById('error'+v.id).style.color = 'red';
          // console.log(i);
          $('.btn-submit').hide();
          $('.btn-check').show();
          return false;
         
        }
        else{
          
          document.getElementById('error'+v.id).style.color = 'black';
          $('.btn-submit').show();
          $('.btn-check').hide();
        }
        
       
      });
    


    })

    $('.btn-submit').click(function(e){
      // return false;
      e.preventDefault();
      // mycart
      $arr =[];
      var mycart = localStorage.getItem('mycart');
      var mycartobj = JSON.parse(mycart);
      var prcart = localStorage.getItem('prcart');
      var myprcartobj = JSON.parse(prcart);
      // alert(myprcartobj);
     var i = false;
     var total_qty = $('#totalqty').val();
      
      // console.log(j);
      console.log(i);
      var mycart = localStorage.getItem('mycart');
     
     var mycartobj=JSON.parse(mycart);
     var po_no = $('input[name=po_no]').val();
    
     console.log(po_no);
     $.ajax({
       type:"POST",
       url:"/SendOfficerPurchaseOrder",
       dataType:"json",
       data:{
         "_token":"{{csrf_token()}}",
         "item_list" : mycartobj,
         "pr_list":myprcartobj,
         "po_no" : po_no,
         "total" : total_qty,
       },
       success:function(data){
         console.log(data);
        //  $('#test_date').val(data);
         swal({
           title:'Success',
           text:"Successfully Sent Purchase Order",
           icon:'success',

         })
          localStorage.clear();
         $('#supplier_product').html('');
         setTimeout(function(){
              window.location.reload();
            },1000);
       }
     })
        
      // alert($arr);

      //endmycart
    

     });
    

    $('.btn-save').click(function(e){
        e.preventDefault();
        var purchase_request_id = [];
        var purchase_requests = {!! json_encode($purchase_requests) !!};

        $.each(purchase_requests,function(i,purchase_request){
          purchase_request_id.push(purchase_request.id);
        })

        $.ajax({
          type:"POST",
          url:"/SaveAllOrder",
          dataType:"json",
          data:{
            "_token":"{{csrf_token()}}",
            "purchase_request_id" : purchase_request_id,
          },
          success:function(data){
            
            setTimeout(function(){
              window.location.reload();
            },1000);
            localStorage.clear();
          }
        })
    });

    $('.btn-mail').click(function(e){
        e.preventDefault();

        var po_no = $('input[name=po_no]').val();
        var req_date = $('input[name=req_date]').val();
        var pr_req_date = $('input[name=test_pr_date]').val();
        var email = $('input[name=email]').val();
        var subject = $('input[name=subject]').val();
        var body = $('input[name=body]').val();
        var mycart = localStorage.getItem('mycart');
        var mycartobj=JSON.parse(mycart);

        $.ajax({
          type:"POST",
          url:"/SendMailSupplier",
          dataType:"json",
          data:{
            "_token":"{{csrf_token()}}",
            "po_no" : po_no,
            "item_list" : mycartobj,
            "email" : email,
            "subject" : subject,
            "body" : body,
            "req_date":req_date,
            // "pr_req_date":pr_req_date,
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
            }
           
          }
        })
    });

  

</script>
@endsection