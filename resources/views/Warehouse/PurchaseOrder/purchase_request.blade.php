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
          <h3 class="card-title">Purchase Request Form</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form role="form" method="post" action="{{route('ajaxSendWarehousePO')}}">
        @csrf
        <input type="hidden" name="required_product[]" id="required_product">
        <input type="hidden" name="material_request_id" value="{{$material_request->id}}">
          <div class="card-body">
              <!-- <div class="form-group">
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
              </div> -->
              <div class="form-group">
                  <label>Required Date</label>
                  <input type="date" class="form-control" name="required_date" id="forDeliveryDate">
              </div>
              <div class="form-group">
                  <label>Destination</label>
                  
                      <div class="row">
                        <div class="col-md-6">
                                  <input type="radio" id="warehouse" name="type" value="1" onclick="isWarehouse(this.value)">
                                  <label class="control-lable">Warehouse</label>
                              </div>
                              <div class="col-md-6">
                                  <input type="radio" id="site" name="type" value="2" onclick="isWarehouse(this.value)">
                                  <label class="control-label">Site</label>
                              </div>
                        </div><br>
                        <!-- Begin -->
                        <div class="row">
                            <div class="col-md-2 mt-4" id="main_radio">
                                <input type="radio" name="warehouse_flag" id="warehouse_flag" value="1">
                                <label class="control-label">Main</label>
                            </div>
                            <div class="col-md-2 mt-4" id="regional_radio">
                                <input type="radio" id="warehouse_flag" value="2" name="warehouse_flag" onclick="isregional()">
                                <label class="control-label">Regional</label>
                            </div>
                            <div class="col-md-2" id="rename">
                                <label class="control-label">Regional Name</label>
                                <select class="form-control" name="regional_id" onchange="regionalName(this.value)">
                                  <option value="">Select Regional Warehouse</option>
                                  @foreach($regionalname as $rename)
                                  <option value="{{$rename->id}}">{{$rename->warehouse_name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-2" id="project_box">
                                <label class="control-label">Project</label>
                                <select class="form-control" id="pro" name="project_id" onchange="getSiteInventoryProject(this.value)">
                                  <option value="">Select Project</option>
                                  @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->project_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" id="phase_box">
                                <label class="control-label">Phase</label>
                                <select class="form-control" id="forPhasedes" name="phase_id" >
                                </select>
                            </div>
                            <div class="col-md-3" id="site_box">
                                <label class="control-label">Site Engineer</label>
                                <select class="form-control" name="site_id">
                                <option value="">Select</option>
                                @foreach($work_sites as $site)
                                <option value="{{$site->id}}">{{$site->name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div><br>
                        <!-- end -->
                      </div>
              </div>
              <hr>
              <div class="form-group">
                  <label>Product List : </label>
                  <a href="#" onclick="checkRequiredProduct()" class="btn btn-primary mb-2">Check Required Product</a>

              <!-- ===== Tab For Product List and Warehouse Inventory ====== -->

                <div class="col-12" class="show_hide">

                  <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Modal</th>
                            <th>S/N</th>
                            <th>Stock Require Quantity</th>
                        </thead>
                        <tbody id="forProduct" class="text-center">
                          

                        </tbody>
                    </table>
                    <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>  
                </div>
              </div>

          </div>
          <!-- /.card-body -->


        
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

$( document ).ready(function() {
        
        $(".select2").select2();
        
        $('#main_radio').hide();
            
        $('#regional_radio').hide();
        
        $('#project_box').hide();
        
        $('#phase_box').hide();
        
        $('#site_box').hide();

        $('#rename').hide();
        
    });
    //Get Phase of Project
    function getPhase(value){

    	var project_id = value;
      // alert(value);
		$('#forPhase').empty();

    	 $.ajax({
           type:'POST',
           url:'/ajaxPhase',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "id":project_id,
          },
            
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
      var material_request_lists = {!! json_encode($material_request_lists) !!}
       console.log(material_request_lists);

      var products = {!! json_encode($products) !!}
      var brands = {!! json_encode($brand) !!}
      $.each(products,function(i,product){
        $.each(brands,function(i,brand){
            $.each(material_request_lists,function(i,material_request_list){

          console.log(material_request_list.request_qty);
          if (product.stock_qty < material_request_list.request_qty) {
            if (product.id == material_request_list.product_id) {
              if(product.brand_id == brand.id){
                console.log(material_request_list);
              stock_qty = material_request_list.request_qty - product.stock_qty;
              
              var required = {product_id:material_request_list.product_id,stock_qty:stock_qty};

              required_product.push(required);
              
              var required_products = JSON.stringify(required_product);
              $("input[name='required_product[]']").attr('value',required_products);
              
              html += `<tr>
                        <td>${product.name}</td>
                        <td>${brand.name}</td>
                        <td>${product.model_number}</td>
                        <td>${product.serial_number}</td>
                        <td>${stock_qty}</td>
                      </tr>`;
            }
          }
        }
        $("#forProduct").html(html);
        });
      });
      });
    }

    $(".btn-submit").click(function(e){

        e.preventDefault();

        var project_id = $("select[name=project_id]").val();
        var phase_id = $("select[name=phase_id]").val();
        var required_date = $("input[name=required_date]").val();
        var material_request_id = $("input[name=material_request_id]").val();
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
            "material_request_id":material_request_id,
            "required_product":required_product,
           },

           success:function(data){

              console.log(data);

              swal({

                title:"Success!",
                text:"You Have Successfully Added for Sales Order",
                icon:"success",
              })
              var url = "{{ route('warehouse_material_request') }}";
              setTimeout(function(){
                document.location.href = url;
              },1000);
           }

        });



  });

  function isWarehouse(value){
        
        console.log(value);
        
        if(value == 1){
            
            $('#main_radio').show();
            
            $('#regional_radio').show();
            
            $('#project_box').hide();
            
            $('#phase_box').hide();
            
            $('#site_box').hide();

            $('#rename').hide();
        }
        
        else if(value == 2){
            
            $('#main_radio').hide();
            
            $('#regional_radio').hide();
            
            $('#project_box').show();
            
            $('#phase_box').show();
            
            $('#site_box').show();

            $('#rename').hide();
        }
    }

    function isregional(){
        // alert("HEEEEEE");
        $('#rename').show();
    }

    function regionalName(value){
    var reid = value;
    console.log(reid);
    $.ajax({
           type:'POST',
           url:'/postregionalnameid',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":reid,},

           success:function(data){
            
            console.log(data);
            
            $('#regid').val(data);

            
             
           }
           
        });

}

function getSiteInventoryProject(value){
        
        console.log(value);
        
      var project_id = value;
      
      document.getElementById('forPhasedes').disabled = false;
      
      $('#forPhasedes').empty();

       $.ajax({
           type:'POST',
           url:'/getProjectSiteInventory',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":project_id,},

           success:function(data){
            
            console.log(data);
            
             $.each(data.phases, function(i, value) {

              $('#forPhasedes').append($('<option>').text(value.phase_name).attr('value', value.id));

            });
             
           }
           
        });

    }

</script>
@endsection