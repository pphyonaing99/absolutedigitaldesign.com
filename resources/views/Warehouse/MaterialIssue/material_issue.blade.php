@extends('master')
@section('title','Material Issue List')
@section('link','Material Issue List')
@section('content')
<div class="card">
    <div class="card-body">
        <form id="storewtorder" action="{{route('storewtorder')}}" method="POST">
            @csrf
           
            
            <div class="row">
            
                
                 
                <div class="col-md-6">
                <label for="recipient-name" class="">Warehouse Transfer No:</label>
                  <div class="input-group">
                    
                    <div class="input-group-prepend">
                      <input type="hidden" value="{{$prefix_syntax}}" id="syntax">
                      <input type="hidden" value="{{$index_digit}}" id="index">
                    <span class="input-group-text  bg-dark">{{$prefix_syntax}}</span>
                    <span class="input-group-text  bg-secondary">{{$digit}}</span>
                  </div>
                  <input type="hidden" id="wtoid" name="wto_ID">
                  <input type="text" class="form-control" id="wtono" name="wtono" readonly>
                  <input type="button" class="btn-warning" value="Generate" onclick="generateno('{{$prefix_syntax}}','{{$index_digit}}')">
                  </div>
                  
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="recipient-name" class="">Project:</label>
                        <input type="text" class="form-control" disabled value="" id="proj" name="project_id">
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="recipient-name" class="">Phase:</label>
                          <input type="text" class="form-control" disabled value="" id="phase" name="phase_id">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="recipient-name" class="">Order Date:</label>
                    <input type="date" class="form-control" value="" id="order_date" name="date">
                  </div>
                  <div class="form-group">
                  <div class="row">
                    <div class="col-md-9">
                          <label for="recipient-name" class="">Regional Warehouse:</label>
                          <select name="regional_warehouse_id" id="selectreg" class="form-control" name="regional_id" onchange="supported_project()" required>
                            <option value="0">Select Regional Warehouse</option>
                          @foreach($regionals as $regional)
                            
                            <option value=" {{ $regional->id }} ">{{ $regional->warehouse_name }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mt-4 pt-2" id="supportproj">
                            <button class="btn btn-dark" id="fakesupp" disabled >Support Projects</button>
                            <button type="button" id="realsupp" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">
                            Support Projects</button>

                    </div>
                  </div>
                  </div>
                </div>
            </div>
            <span id="showsupportpj"></span>
            <div class="row">
                <!-- Begin -->
                <div class="col-md-6">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th>No</th>
                        <th>Material Issue No</th>
                        <th>Receiving Person</th>
                        <th>Phone<th>
                        
                        <th>Total Qty</th>
                        <th>Action</th>
                        <th></th>
                        </tr>
                    </thead>
                
              <tbody>
              <?php $i=1; ?>
                  @foreach($material_issues as $mais) 
                  <tr onclick="showrelate('{{$mais->id}}')">
                
                    <!-- tgPanel Data -->
                    <input type="hidden"  value="{{$mais->id}}">
                    <input type="hidden"  value="{{$mais->project_id}}">
                    <input type="hidden"  value="{{$mais->total_qty}}">
                    <input type="hidden"  value="{{$mais->material_issue_no}}">












                  <td>{{$i++}}.</td>
                  <td class="text-center">{{$mais->material_issue_no}}</td>
                @if($mais->purchase_order_id <= 0)
                @foreach($material_request as $mareq)
                @if($mais->material_request_id == $mareq->id)
                <input type="hidden"  value="{{$mareq->user->name}}">
                <input type="hidden"  value="not yet">
                <td>{{$mareq->user->name}}</td>
                <td colspan="2">not yet</td>
                @endif
                @endforeach
                @else
                  @foreach($blur_po as $opo)
                  @if($mais->purchase_order_id == $opo->id)
                 
                  
                  
                  <input type="hidden"  value="{{$opo->customer_name}}">
                      <td>{{$opo->customer_name}}</td>
                      
                      @endif
                   
                  @endforeach
                  @foreach($blur_po as $opo)
                  @if($mais->purchase_order_id == $opo->id)
                  <input type="hidden"  value="{{$opo->phone}}">
                      <td colspan="2">{{$opo->phone}}</td>
                      @endif
                  @endforeach
                @endif    
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$mais->total_qty}}</td>
                     
                      
                      <td colspan="2"><i class="btn btn-primary btn_addtocart btn-sm" data-id="" data-name="" data-qty="" id="" onclick="tgPanel(this)" style="cursor: pointer;" ><i class="fas fa-plus"></i>Add</i><span class="float-right" data-toggle="collapse" data-target="#accordion_{{$mais->id}}" class="clickable" style="cursor: pointer;user-select: none;"><i class="fas fa-arrow-circle-down text-primary"></i></span></td>
                     
                      
                  </tr>
                
                  <tr>
                      <td colspan="7">
                          <div id="accordion_{{$mais->id}}" class="collapse">
                            <h4 class="text-success">Product List</h4>
                            
                            <table class="table">
                              <thead>
                                <tr>

                                  <th scope="col">#</th>
                                  <th>Product Name</th>
                                  <th>Brand</th>
                                  
                                  <th>Order Qty</th>
                                  
                                  
                                  
                                </tr>
                              </thead>
                            <tbody>
                            <?php $i=1; ?>
                            
                              @foreach($material_issue_list as $mali)
                              @if($mais->id == $mali->material_issue_id)
                            
                              <tr>
                             
                                
                            
                              
                                



                                <th scope="row">{{$i++}}</th>
                              
                                <td scope="row">{{$mali->product->name}}</td>
                                <td scope="row">{{$mali->product->brand->name}}</td>
                                <td scope="row" class="text-center">{{$mali->stock_qty}}</td>
                              
                             
                                
                                
                              
                                
                               
                                
                               
                                
                               
                               
                                
                                
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
                <!-- sub begin -->
                <div class="col-md-6">
                    
                     <div class="card shadow mt-3 mr-3">
                        <div class="card-header">
                           
                        
                        <span id="arra_mat_id"></span>
                        
                        
                    


                
            <div class="card-body">
              <table id="SupplierProduct" class="table table-bordered">
                <thead class="text-center bg-dark">
                  <th>Material Issue No</th>
                  <th>Receiving Person</th>
                  <th>phone</th>
                  <th>total Qty</th>
                  <th>Action</th>
                </thead>
                <tbody  class="text-center" id="wto_product">


               
                 

                </tbody>
              </table>
              <div class="row mr-3 ml-5 mt-3 text-center">
              <input type="hidden" id="total_qty" name="total_qty">
               <label>Total Quantity:</label><span id="showtotal" class="ml-2"></span>
              </div>
            </div>
            
          </div>
          
        </div>
        <input type="button"  onclick="checkdate()" class="btn btn-info offset-md-8 text-light" value="Send Regional Warehouse">
                <!-- End -->
            </div>
            </div>
            <div class="row">
               
              
            </div>
        </form>
    </div>
</div>







@endsection
@section('js')
<script>

function showrelate(value)
{
  // alert(value);
    
  $.ajax({
      type:'POST',
      url:'/maishowproj',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'material_issue_id' : value,
        
      },
      success:function(data){
        // alert(data.phase_name);
        
        $('#proj').val(data.project_name);
        $('#phase').val(data.phase_name);
      
      }
  });

}

function generateno(syntax,digit)
{
  // alert("not yet!!!");
  $.ajax({
      type:'POST',
      url:'/generate_wto_no',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'syntax' : syntax,
        'digit' : digit,
      },
      success:function(data){
        
        $('#wtono').val(data.wto_no);
        $('#wtoid').val(data.wto_id);
      }
    });

}

function tgPanel(i)
{
  var selectReg = $('#selectreg').val();
  if(selectReg == 0)
  {
    swal({

        title:"Something Wrong!",
        text:"You must select Regional Warehouse Firstly",
        icon:"error",
        timer: 3000,
        });
  }
  else
  {
  
 
  var tr = i.parentElement.parentElement;
  var mais_id = tr.getElementsByTagName("input")[0].value;
  var project_id = tr.getElementsByTagName("input")[1].value;
  var total_qty = tr.getElementsByTagName("input")[2].value;
  var mi_no = tr.getElementsByTagName("input")[3].value;
  var cust_name = tr.getElementsByTagName("input")[4].value;
  var cust_ph = tr.getElementsByTagName("input")[5].value;
  // var user = tr.getElementsByTagName("input")[6].value;
  // alert(cust_name);
  $.ajax({
      type:'POST',
      url:'/material_item_list',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'material_issue_id' : mais_id,
        'regional_id' : selectReg,
      },
      success:function(data){
        var mi_num = mi_no;
        var pro_array = data.product_id;
        var stock_array = data.stock_qty;
       var pro_brand = data.brand
;        var pro_array_len = pro_array.length;
        var stock_array_len = stock_array.length;
        var pro_name = data.product_name;
        //localstorage declare begin
        var reg_projectID = data.reg_project_id;
        // alert(reg_projectID);
       if(data.reg_project_id == 0)
       {
                  swal({

                      title:"Regional Warehouse Error!",
                      text:"Please Check Regional Warehouse that supported project !",
                      icon:"error",
                      timer: 3000,
                      });
       }
      else
      {
      
       
       
        

       
        var wtocart = localStorage.getItem('wtocart');

        var mywtocartobj = JSON.parse(wtocart);
       


       
        if(!wtocart){
            wtocart = '[]';
        }
        
        var wto_item = {mat_is_id:mais_id,mi_no:mi_num,project_id:project_id,rece_per:cust_name,phone:cust_ph,mi_total:total_qty,pro_id:pro_array,product_name:pro_name,brand:pro_brand,stock:stock_array};

        
        
        var mywtocartobj = JSON.parse(wtocart);
       var hasid = false;
        $.each(mywtocartobj,function(i,v){
               
                if(v.mat_is_id == mais_id)
                {
                hasid = true;
              
                }
            })
            if(!hasid){
            mywtocartobj.push(wto_item);
            }
//check destination before adding 
             var i = 0;
             var j=0;
               var wto_length = mywtocartobj.length;
                  // alert(mywtocartobj[j].project_id);
                  
                  if(reg_projectID.includes(parseInt(mywtocartobj[wto_length-1].project_id)))
                  {
                    // alert("ok");
                    localStorage.setItem('wtocart',JSON.stringify(mywtocartobj));
                  }
                  else
                  {
                    swal({

                        title:"Destination Not Match!",
                        text:"Please Check Your Material Issue Destination !",
                        icon:"error",
                        timer: 3000,
                        });
                  }
                
                  
                }     
           
        
//end check destination     
        //Data
    
        
                        
                        
          
        var html_mat_id = "";
       

        $.each(mywtocartobj,function(i,v){
           
           html_mat_id += `<input type="hidden" name="mat_ID[]" value="${v.mat_is_id}">`
          
        })       
        $('#arra_mat_id').html(html_mat_id);  


        //Data end
        //Total total Quantity
        var total = 0;
        var html1 = "";
        $.each(mywtocartobj,function(i,v){
            total += parseInt(v.mi_total);
        })
        var html1 = "";
            html1 = `<b><i>${total}</i></b>`;
            $('#showtotal').html(html1);
            
        //end total total
        showmodal();

      }//ajax success end
  });// ajax end 


}//regional error esle

}

function showmodal(){
        
        var mywtocart = localStorage.getItem('wtocart');
        
        if(mywtocart){
          var mywtocartobj = JSON.parse(mywtocart);
          var html=''; var j=1; var total=0;
          var htmlnext = "";
          var htmlin = "";
           
            if(mywtocartobj.length>0){

            $.each(mywtocartobj,function(i,v){
                // alert(i);
                // var i = 0;
                // for(i=0;i<v.pro_id.length;i++)
                // {
                //   html+=`<tr class="text-center">
                //     <td>${v.pro_id[i]}</td>
                    
                    
                //     </tr>`;
                //     j++;
                // }
                var mi_no = v.mi_no;
                var mais_id=v.mat_is_id;
                var rece_name=v.rece_per;
                var phone = v.phone;
                var total_qty=v.mi_total;
                var pro_name = v.product_name;
                var order = v.po_id;
                var pro_brand = v.brand;
               
            
               
            html+=`<tr>
                    <td>${mi_no}</td>
                    <td>${rece_name}</td>
                    <td>${phone}</td>
                    <td>${total_qty}</td>
                    <td><i class="btn btn-danger mr-2" id="" onclick="removelocal('${i}')" style="cursor: pointer;" ><i class="fas fa-trash"></i></i><span data-toggle="collapse" data-target="#wtocolll${mais_id}" style="cursor: pointer;user-select: none;"><i class="fas fa-arrow-circle-down text-primary"></i></span></td>
                    </tr>
                    
              
                   
                   
                    
                    
                    `;
                    

                  //Start
                 
                       html +=`
                       <tr>
                       <td colspan="6">
                          <div id="wtocolll${mais_id}" class="collapse">
                              <div class="row">
                              <div class="col-md-3">
                                  <label class="text-success">No</label>`
                                  for(k=1;k<=v.pro_id.length;k++)
                                  {
                                        html += ` <div class="md-4">
                                        ${k}
                                  </div>`
                                  }
                      html += ` </div>
                                <div class="col-md-3">
                                  <label class="text-success">Product</label>
                                      `
                                      for(k=0;k<v.pro_id.length;k++)
                                      {
                                          html +=`<div class="md-4">${pro_name[k]}</div>`;
                                      }
                        html += `
                        
                                </div>
                                <div class="col-md-3">
                                  <label class="text-success">Brand</label>`
                                  for(k=0;k<v.pro_id.length;k++)
                                      {
                                      html += `<div class="md-4">
                                      ${pro_brand[k]}
                                      </div>`
                                      }
                                      
                   html += `</div>
                                <div class="col-md-3">
                                  <label class="text-success">Order Qty</label>`
                                  for(k=0;k<v.pro_id.length;k++)
                                      {
                                     html += `<div class="md-4">
                                     ${v.stock[k]}
                                      </div>`;
                                      }
                          html +=  ` </div>
                              </div>
                          </div>
                      </td>
                        </tr>
                        `;
                  
                  //End
            
                  j++;
                
              
              });
             
              $("#wto_product").html(html);
              
             
            

            }
            
        }

    }

    function removelocal(value)
    {
        alert(value);
        var mywtocart = localStorage.getItem('wtocart');
      

        var mywtocartobj = JSON.parse(mywtocart);
        if(value == 0)
        {
            
             setTimeout(function(){
              window.location.reload();
            },1000);
            localStorage.clear();
        }
        else
        {
        mywtocartobj.splice(value, 1);
       
      
        localStorage.setItem('wtocart',JSON.stringify(mywtocartobj));
        }
        

        showmodal();

    }
function checkdate()
{
  // alert("check Now");
  var mywtocart = localStorage.getItem('wtocart');
  var mywtocartobj = JSON.parse(mywtocart);
  var matisID = [];
  $.each(mywtocartobj,function(i,v){
    matisID.push(v.mat_is_id);

  });
  // alert(matisID);
  var date = $('#order_date').val();
  $.ajax({
      type:'POST',
      url:'/check_waretransfer_date',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'ware_transfer_date' : date,
        'matis_idarr' : matisID,
      },
      success:function(data){
        // alert(data.check);
        if(data.check == "success")
        {
          // alert("success");
            $('#storewtorder').submit();
        }
        else
        {
          swal({

              title:"Date Wrong Error!",
              text:"Warehouse Transfer Date is "+data.late+" days later than Material Issue Date!",
              icon:"error",
              
              });
        }
      }
  });
}

$( document ).ready(function() {
    $('#realsupp').hide();
});

function supported_project()
{
  // alert(reg_id);
  var e = document.getElementById("selectreg");
var value = e.options[e.selectedIndex].value;
var htmlpjname = "";
var htmlexam = "";
// alert(value);
$.ajax({
      type:'POST',
      url:'/get_supported_reg_projects',
      dateType:'json',
      data:{
        "_token":"{{csrf_token()}}",
        'regional_id' : value,
        
      },
      success:function(data){
        $('#fakesupp').hide();
        $('#realsupp').show();
       
        
        
        htmlpjname += `
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Support this following Projects</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row bg-info">
            <div class="col-md-6 text-center">
            No
            </div>
            <div class="col-md-6">
            Project Name
            </div>

        </div>
        `;
        if(data == "not")
          {
            htmlpjname += ` 
           <div class="col-md-12 text-center mt-3">
           <span class="badge badge-danger">Nothing</span>
            </div>
           
            
            `;
          }
          else
          {
              var i = 0;var j=1;
              for(i=0,j=1;i<= data.length,j<=data.length;i++,j++)
              {
                
              
                  
                  htmlpjname += ` <div class="row">
                <div class="col-md-6 text-center">
                      ${j}
                  </div>
                  <div class="col-md-6">
                      ${data[i]}
                  </div>
                  </div>
                  `;

              }
           }

        htmlpjname += `
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
        
      </div>
    </div>
  </div>
</div>
        
        `;

        
        $('#showsupportpj').html(htmlpjname);
      }
      
    });
    
}
   


</script>
@endsection