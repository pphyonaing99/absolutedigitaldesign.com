@extends('master')
@section('title','Purchase Order Form')
@section('link','Purchase Order Form')
@section('content')

<div class="row">
  	<div class="col-12 col-sm-12 col-lg-12">

   <!-- ================ Purchase Order ====================== -->

    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title">Purchase Order Form</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <!-- <form role="form" method="post" action="{{route('store_product')}}"> -->
        @csrf
        <input type="hidden" name="required_product[]" id="required_product">
        <input type="hidden" name="sale_order_id" value="{{$sale_order->id}}">
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
                  <select class="custom-select" id="forPhase" name="phase_id">

                  </select>
              </div>
              <div class="form-group">
                  <label>Required Date</label>
                  <input type="date" class="form-control" name="required_date" id="forDeliveryDate">
              </div>
              <div class="form-group">
                  <label>Product List : </label>
                  <a href="#" onclick="checkRequiredProduct()" class="btn btn-primary mb-2">Check Required Product</a>

              <!-- ===== Tab For Product List and Warehouse Inventory ====== -->

                <div class="col-12" class="show_hide">

                  <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <th>Name</th>
                            <th>Stock Quantity</th>
                        </thead>
                        <tbody id="forProduct" class="text-center">
                          

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
</div>


<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- page script -->
<script type="text/javascript">
    //Get Phase of Project
    function getphasenow(value)
    {
      alert(value);
    }
    function getPhase(value){
console.log(value);
    	var project_id = value;

		$('#forPhase').empty();

    	 $.ajax({
           type:'POST',
           url:'/ajaxPhase',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "id":project_id,},
            
           success:function(data){
           	
           	 $.each(data, function(i, value) {

            	$('#forPhase').append($('<option>').text(value.phase_name).attr('value', value.id));

        	});

           }

        });


    }

    function checkRequiredProduct(){
      var html = ''; var stock_qty=0;
      var required_product = [];
      var sale_order_lists = {!! json_encode($sale_order_lists) !!}

      var products = {!! json_encode($products) !!}

      $.each(products,function(i,product){
    
        $.each(sale_order_lists,function(i,sale_order_list){

          if (product.stock_qty < sale_order_list.stock_qty) {
            if (product.id == sale_order_list.product_id) {
                console.log(sale_order_list);
              stock_qty = sale_order_list.stock_qty - product.stock_qty;
              
              var required = {product_id:sale_order_list.product_id,stock_qty:stock_qty};

              required_product.push(required);
              
              var required_products = JSON.stringify(required_product);
              $("input[name='required_product[]']").attr('value',required_products);
              
              html += `<tr>
                        <td>${product.name}</td>
                        <td>${stock_qty}</td>
                      </tr>`;
            }
          }
        $("#forProduct").html(html);
        });
      });
    }
    $(".btn-submit").click(function(e){

        e.preventDefault();

        var project_id = $("select[name=project_id]").val();
        var phase_id = $("select[name=phase_id]").val();
        var required_date = $("input[name=required_date]").val();
        var sale_order_id = $("input[name=sale_order_id]").val();
        var required_product = $("input[name='required_product[]']").val();
        // console.log(required_product);
        $.ajax({
           type:'POST',

           url:'/ajaxSendWarehousePO',

           dataType:'json',

           data:{
            "_token":"{{csrf_token()}}",
            "project_id":project_id, 
            "phase_id":phase_id, 
            "required_date":required_date,
            "sale_order_id":sale_order_id,
            "required_product":required_product,
           },

           success:function(data){

              console.log(data);

              swal({

                title:"Success!",
                text:"You Have Successfully Added for Sales Order",
                icon:"success",
              })
              var url = "{{ route('warehouse_sale_orders') }}";
              setTimeout(function(){
                document.location.href = url;
              },1000);
           }

        });



  });

</script>
@endsection