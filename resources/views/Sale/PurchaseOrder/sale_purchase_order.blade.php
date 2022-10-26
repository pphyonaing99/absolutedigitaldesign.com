@extends('master')
@section('title','Purchase Order List')
@section('link','Purchase Order List')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">

<div class="row">
  	<div class="col-6 col-sm-12 col-lg-6">

   <!-- ================ Purchase Order ====================== -->

    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title">Purchase Order Register</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form role="form" method="post" action="{{route('store_product')}}">
        @csrf
          <div class="card-body">
              <div class="form-group">
                  <label>Customer</label>
                  <select class="form-control" name="customer_id">
                      <option value="">Choose Customer</option>
                      @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->company_name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label>Project Name</label>
                  <input type="text" class="form-control" name="project_name">
              </div>
              <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" name="phone">
              </div>
              <div class="form-group">
                  <label>Description</label>
                  <input type="text" class="form-control" name="description">
              </div>
              <div class="form-group">
                  <label>Document</label>
                  <select name="document_id" class="form-control">
                    @foreach($documents as $document)
                      <option value="{{$document->id}}">{{$document->name}}</option>
                    @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label>Request Date</label>
                  <input type="date" class="form-control" name="request_date">
              </div>
              <div class="form-group">
                  <label>Product List : </label>


              <!-- ===== Tab For Product List and Warehouse Inventory ====== -->

                <div class="col-12" class="show_hide">

                  <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <th>Name</th>
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


        </form>
    </div>
        

	</div>
	<!-- left column -->
	    <!-- ========== Product List ================== -->
	<div class="col-md-6">
    <div class="row product_list">
        <table class="table table-bordered table-striped" id="myTable">
          <thead class="text-center">
            <th>#</th>
            <th>Model Number</th>
              <th>Name</th>
              <th>Stock Quantity</th>
              <th>Action</th>
          </thead>
          <tbody id="item_list">
            <?php $i=1; ?>
            @foreach($products as $product)
            <tr class="text-center">
              <td>{{$i++}}</td>
              <td>{{$product->model_number}}</td>
              <td>{{$product->name}}</td>
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

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- page script -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
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

	    var tr = i.parentElement.parentElement;

	    var product_id = tr.getElementsByTagName("td")[0];
	    var product_name = tr.getElementsByTagName("td")[2];

	    var string_id = product_id.innerText;

      var id = parseInt(string_id,10);
      console.log(product_id);
	    var name = product_name.innerText;

	    var item={id:id,name:name,qty:1};
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
            
            html+=`<tr>
                    <td>${name}</td>
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

        var project_name = $("input[name=project_name]").val();

        var customer_id = $("select[name=customer_id]").val();

        var description = $("input[name=description]").val();

        var document_id = $("select[name=document_id]").val();

        var phone = $("input[name=phone]").val();

        var request_date = $("input[name=request_date]").val();

        var purchase_order = localStorage.getItem('mycart');

        $.ajax({

           type:'POST',

           url:'/ajaxSalePurchaseOrder',

           dataType:'json',

           data:{
           	"_token":"{{csrf_token()}}",
           	"project_name":project_name, 
           	"customer_id":customer_id, 
           	"description":description, 
           	"document_id":document_id, 
           	"phone":phone, 
           	"request_date":request_date, 
           	"purchase_order":purchase_order,
           },

           success:function(data){

             	console.log(data);

             	swal({

             		title:"Success!",
             		text:"You Have Successfully Added for Purchase Order",
             		icon:"success",
             	})

             	setTimeout(function(){
             		window.location.reload();
             	},1000);
             	localStorage.clear();
           }

        });



	});

</script>
@endsection