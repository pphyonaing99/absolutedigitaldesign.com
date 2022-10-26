@extends('master')
@section('title','Sale Purchase Order List')
@section('link','Sale Purchase Order List')
@section('content')

<div class="row">
  	<div class="col-6 col-sm-12 col-lg-6">

   <!-- ================ Purchase Order ====================== -->

    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title">Sale Order Register</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <!-- <form role="form" method="post" action="{{route('store_product')}}">
        @csrf -->
        <input type="hidden" name="purchase_order_id" value="{{$purchase_orders->id}}">
          <div class="card-body">
              <div class="form-group">
                  <label>Project</label>
                  <select class="custom-select" name="project_id" id="project_id" onchange="getPhase(this.value)" >
                    <option>Select Project</option>
                    @foreach($projects as $project)
                      <option value="{{$project->id}}">{{$project->project_name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label>Phase</label>
                  <select class="custom-select" id="forPhase" name="phase_id"
                   onchange="getDeliveryDate(this.value)">

                  </select>
              </div>
              <div class="form-group">
                  <label>Delivery Date</label>
                  <input type="date" class="form-control" name="delivery_date" id="forDeliveryDate">
              </div>
              <div class="form-group">
                  <label>Product List : </label>


              <!-- ===== Tab For Product List and Warehouse Inventory ====== -->

                <div class="col-12" class="show_hide">

                  <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <th>Name</th>
                            <th>Model Number</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Stock Quantity</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="forProduct" class="text-center">
                          <?php $i = 1;?>

                        </tbody>
                    </table>
                    <div class="card-footer">
                  <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                </div>
                    
                </div>
              </div>

          </div>
          <!-- /.card-body -->


        <!-- </form> -->
    </div>
        

	</div>
	<!-- left column -->
	    <!-- ========== Product List ================== -->
	<div class="col-md-6">
  <div class="form-group">
  
                  <select class="custom-select" name="" id="" onchange="category(this.value)" >
                  
                    <option>Select Category</option>
                    @foreach($category as $cate)
                      <option value="{{$cate->id}}">{{$cate->name}}</option>
                     @endforeach 
                  </select>
              </div>
    <div class="row product_list">
      <!-- <button type="button" class="btn btn-primary mb-2 float-right" data-toggle="modal" data-target="#po">
        Check Purchase Order
      </button> -->
        <table class="table table-hover table-bordered table-striped">
          <thead class="text-center bg-light ">
            <th>#</th>
            <th class="text-success">Model No</th>
              <th class="text-success">Name</th>
              <th class="text-success">Brand</th>
              <th class="text-success">Category</th>
              <th class="text-success">Stock Qty</th>
              <th class="text-success">Action</th>
          </thead>
          <tbody id="item_list">
            <?php $i=1; ?>
            @foreach($products as $product)
            <tr class="text-center" id="showcateitem">
              <input type="hidden" value="{{$product->id}}">
              <td>{{$i++}}</td>
              <td>{{$product->model_number}}</td>
              
              <td>{{$product->name}}</td>
              <td>{{$product->brand->name}}</td>
              <td>{{$product->category->name}}</td>
              <td>{{$product->stock_qty}}</td>
              <td><i class="btn btn-primary btn_addtocart" data-id="{{$product->id}}" data-name="{{$product->name}}" data-qty="{{$product->qty}}" onclick="tgPanel(this)" style="cursor: pointer;" ><i class="fas fa-plus"></i> Add</i></td>
            </tr>
            @endforeach
          </tbody>
      </table>
    </div>
		
	</div>
	<!-- /.card -->
</div>

<!-- Purchase Order Modal -->
<div class="modal fade" id="po" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="card-body">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Purchase Order</h3>
              </div>
              <!-- /.card-header -->

            <div class="row m-3">
              <div class="col-md-5">
                <h4>Order Code</h4>
              </div>
              <div class="col-md-1">
                :
              </div>
              <div class="col-md-6">
                  <h4>{{$purchase_orders->order_code}}</h4>
              </div>
            </div>
            <div class="row m-3">
              <div class="col-md-5">
                <h4>Customer Name</h4>
              </div>
              <div class="col-md-1">
                :
              </div>
              <div class="col-md-6">
                <h4>{{$purchase_orders->customer_name}}</h4>
              </div>
            </div>
            <div class="row m-3">
              <div class="col-md-5">
                <h4>Phone Number</h4>
              </div>
              <div class="col-md-1">
                :
              </div>
              <div class="col-md-6">
                <h4>{{$purchase_orders->phone}}</h4>
              </div>
            </div>
            <div class="row m-3">
              <div class="col-md-5">
                <h4>Request Date</h4>
              </div>
              <div class="col-md-1">
                :
              </div>
              <div class="col-md-6">
                <h4>{{$purchase_orders->request_date}}</h4>
              </div>
            </div>
            <div class="row m-3">
              <div class="col-md-3">
                <h4>Details</h4>
              </div>
              <div class="col-md-1">
                :
              </div>
              <div class="col-md-8">
                <div class="row bg-info text-center font-weight-bold p-2">
                    <div class="col-md-6">
                      <span>Product Name</span>
                    </div>
                    <div class="col-md-6">
                      <span>Request Quantity</span>
                    </div>
                  </div>

                  @foreach($product_lists as $product_list)
                  @if($purchase_orders->id == $product_list->purchase_order_id)
                  <div class="row mb-1 mt-3 text-center font-weight-bold" style="font-size:18px;">
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
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- page script -->
<script type="text/javascript">

	$("#forProduct").on('click','.btnplus',function(){

        console.log("increased");
        var id=$(this).data('id');
        console.log(id);
        count_change(id,'+');

      })
      $("#forProduct").on('click','.btnminus',function(){

        console.log("Decrease");
        var id=$(this).data('id');
        console.log(id);
        count_change(id,'-');

      })

      function count_change(id,action){
        var mycart=localStorage.getItem('mycart');
        var mycartobj=JSON.parse(mycart);


        if(action=='+'){
          mycartobj[id].qty++;
        }else{
          mycartobj[id].qty--;
          if(mycartobj[id].qty<1){
            var ans=confirm('Are you sure');
            if(ans){
              mycartobj.splice(id,1);
              setTimeout(function(){
             		window.location.reload();
             	},1000);
            }else{
              mycartobj[id].qty;            }
          }
        }
        localStorage.setItem('mycart',JSON.stringify(mycartobj));
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

	function tgPanel(i) {
    // alert()
	    var tr = i.parentElement.parentElement;
      var product_id = tr.getElementsByTagName("input")[0].value;
	    // var product_id = tr.getElementsByTagName("td")[0];
      alert(product_id);
      var model = tr.getElementsByTagName("td")[1];
	    var product_name = tr.getElementsByTagName("td")[2];
      var brand = tr.getElementsByTagName("td")[3];
      var category = tr.getElementsByTagName("td")[4];
	    var string_id = product_id.innerText;

      var id = parseInt(string_id,10);
      console.log(product_id);
	    var name = product_name.innerText;
      var real_model = model.innerText;
      var real_brand = brand.innerText;
      var real_cate = category.innerText;
	    var item={id:product_id,name:name,model:real_model,brand:real_brand,category:real_cate,qty:1};
        // console.log(item);

        var mycart = localStorage.getItem('mycart');

        if(!mycart){
          mycart = '[]';
        }
        var mycartobj=JSON.parse(mycart);

        var hasid = false;
        $.each(mycartobj,function(i,v){
          if(v.id == id){
            hasid = true;
            v.qty++;
          }
        })
        if(!hasid){
          mycartobj.push(item);
        }
        
        localStorage.setItem('mycart',JSON.stringify(mycartobj));

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
            var model = v.model;
            var brand = v.brand;
            var category = v.category;
            html+=`<tr>
                    <td>${name}</td>
                    <td>${model}</td>
                    <td>${brand}</td>
                    <td>${category}</td>
                    <td><i class="fa fa-plus-circle btnplus btn-info" data-id=${i}></i>  ${qty}  <i class="fa fa-minus-circle btnminus btn-info" data-id=${i}></i></td>
                    <td><i class="fas fa-trash btndelete data-id=${i}"></i></td>
                  </tr>`;
                  j++;
          })
          $("#forProduct").html(html);
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

      //Form Submit

       $(".btn-submit").click(function(e){

        e.preventDefault();

        var project_id = $("#project_id").children("option:selected").val();

        var phase_id = $("#forPhase").children("option:selected").val();

        var delivery_date = $("input[name=delivery_date]").val();

        var purchase_order_id = $("input[name=purchase_order_id]").val();

        var sales_order = localStorage.getItem('mycart');

        $.ajax({

           type:'POST',

           url:'/ajaxSalesOrder',

           dataType:'json',

           data:{
           	"_token":"{{csrf_token()}}",
           	"project_id":project_id, 
           	"phase_id":phase_id, 
           	"delivery_date":delivery_date, 
           	"sales_order":sales_order,
           	"purchase_order_id":purchase_order_id,
           },

           success:function(data){

             	console.log(data);

             	swal({

             		title:"Success!",
             		text:"You Have Successfully Added for Sales Order",
             		icon:"success",
             	})

             	setTimeout(function(){
             		window.location.reload();
             	},1000);
             	localStorage.clear();
           }

        });
        
	});
    //Get Phase of Project
    function getPhase(value){

    	var project_id = value;

		$('#forPhase').empty();

    	 $.ajax({
           type:'POST',
           url:'/ajaxPhase',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":project_id,},

           success:function(data){
           	
           	 $.each(data, function(i, value) {

            	$('#forPhase').append($('<option>').text(value.phase_name).attr('value', value.id));

        	});

           }

        });


    }
    // Get Date of specific Phase
    function getDeliveryDate(value){

    	var phase_id = value;

		$('#forDeliveryDate').empty();

    	$.ajax({
           type:'POST',
           url:'/ajaxDeliveryDate',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":phase_id,},

           success:function(data){
           	
            	$('#forDeliveryDate').attr('value', data.start_date)


           },

        });


    }

    function category(value)
    {
      // alert(value);
      $.ajax({
           type:'POST',
           url:'/ajax_getcategory_products',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "category_id":value,},

           success:function(data){

            // alert("success");
            var htmlitem = "";
            var i=0;j=1;k=0;
            for(i=0,j=1;i<=data.product.length,j<=data.product.length;i++,j++)
            {
              htmlitem +=`
              
              <tr>
              <input type="hidden" value="${data.product[i].id}">
              <td>${j}</td>
              <td>${data.product[i].model_number}</td>
              <td>${data.product[i].name}</td>
             <td>${data.brand[i]}</td>

              
              <td>${data.cate}</td>
              <td>${data.product[i].stock_qty}</td>
              <td><i class="btn btn-primary btn_addtocart" data-id="${data.product[i].id}" data-name="${data.product[i].name}" data-qty="${data.product[i].stock_qty}" onclick="tgPanel(this)" style="cursor: pointer;" ><i class="fas fa-plus"></i> Add</i></td>
              </tr>
              `;
            }

            $('#item_list').html(htmlitem);

           }

           });
    }

    
    
</script>
@endsection