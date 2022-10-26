@extends('master')
@section('title','Product List')
@section('link','Product List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product List</h3>
              <a href="{{route('create-product')}}" class="btn btn-primary float-right"> <i class="fa fa-plus"></i> Create Product</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                	<tr>
                    <th>Serial Number</th>
                    <th>Product Name</th>
                    <th>Product Brand</th>
                    <th>Model Number</th>
                    <th>Product Quantity</th>
                    <th>Product Register Date</th>
                    <th>Location</th>
                  </tr>
                </thead>
                <?php $i = 1;?>
                <tbody>
                  <tr>
                    @foreach($products as $product)
                    <td>{{$product->serial_number}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->brand->name}}</td>
                    <td>{{$product->model_number}}</td>
                    <td>{{$product->stock_qty}}</td>
                    <td>{{$product->reg_date}}</td>
                    @if($product->shelve_id == null)
                    <td><a href="#" data-toggle="modal" data-target="#assign{{$product->id}}_shelve" class="btn btn-primary"><i class="fas fa-plus"></i> Add Shelve</a></td>
                    @else
                    <td>{{$product->shelve->name}}</td>
                    @endif
                  </tr>

                  <!-- Modal -->
                  <div class="modal fade" id="assign{{$product->id}}_shelve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title">Add Shelve</h3>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form role="form" method="post" action="{{route('assign-shelve')}}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="serial_number">Zone</label>
                                <select class="form-control" name="zone_id" onchange="getShelveList(this.value,{{$product->id}})">
                                    <option>Select Zone</option>
                                    @foreach($zones as $zone)
                                    <option value="{{$zone->id}}">{{$zone->name}}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="serial_number">Shelve</label>
                                <select class="form-control" name="shelve_id" id="shelve_{{$product->id}}">
                                    <option>Select Shelve</option>
                                </select>
                              </div>
                              <!-- /.input group -->
                            </div>
                            </div>
                            <!-- /.card-body -->

                          <div class="card-footer justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.card -->
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
<script type="text/javascript" >
    function getShelveList(zone_id,product_id){
        $('#shelve_'+product_id).empty();
        $.ajax({

           type:'POST',

           url:'/getShelveList',

           data:{
           	"_token":"{{csrf_token()}}",
           	"zone_id":zone_id, 
           },

           success:function(data){
               
           	$.each(data,function(i,shelve){
           	    
           	    $('#shelve_'+product_id).append($('<option>').attr('value',shelve.id).text(shelve.name));
           	})
            console.log($('#shelve_'+product_id).val());
           }

        });
    }
</script>
@endsection