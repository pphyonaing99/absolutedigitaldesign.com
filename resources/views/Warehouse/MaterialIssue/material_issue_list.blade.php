@extends('master')
@section('title','Material Issue List')
@section('link','Material Issue List')
@section('content')

<div class="row">
        <input type="hidden" id="request" value="">
        <input type="hidden" id="products" value="">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Material Issue Lists</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center bg-info">
                	<th>#</th>
                	<th>Material Issue No</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                	<th>Project</th>
                  	<th>Phase</th>
                    <th>Action</th>
                    <th>Status</th>
                </thead>
                @foreach($material_issue as $matis)
                <tbody>
                  <?php $i = 1;?>
                 
                  <tr class="text-center">
                  <td>{{$i++}}</td>
                  <td>{{$matis->material_issue_no}}</td>
                  @if($matis->purchase_order_id == null)
                  <td>{{$matis->material_request->user->name}}</td>
                  <td> - </td>
                  @else
                  <td>{{$matis->purchase_order->customer_name}}</td>
                  <td>{{$matis->purchase_order->phone}}</td>
                  @endif
                  <td>{{$matis->project->project_name}}</td>
                  <td>{{$matis->phase->phase_name}}</td>
                  <td><a href="" class="btn btn-info" data-toggle="modal" data-target="#show_product_{{$matis->id}}"><span class="ml-2 mr-2">Detail</span></a></td>
                  @if($matis->delivery_order_status == 0)
                   <td><span class="badge badge-warning p-1">Pending</span></td>
                   @else
                   <td><span class="badge badge-success p-1">Delivery Oredered</span></td>
                   @endif
                  </tr>
                  
                  <!--Check Stock -->
                  <div class="modal fade" id="show_product_{{$matis->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Material's Issue Product Details</h5>
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
                            <div class="col-md-2">
                              <span>Instock Qty</span>
                            </div>
                            <div class="col-md-2">
                              <span>Request Qty</span>
                            </div>
                            
                          </div>
                         
                          <input type="hidden" id="req" value="">
                          @foreach($material_issue_list as $matlist)
                          @if($matis->id == $matlist->material_issue_id)
                          <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                         
                            
                            <div class="col-md-3">
                             {{$matlist->product->name}}
                            </div>
                            
                            <div class="col-md-2">
                            {{$matlist->product->brand->name}}  
                            </div>
                            <div class="col-md-2">
                            {{$matlist->product->model_number}}  
                            </div>
                            <div class="col-md-2">
                              
                            {{$matlist->product->stock_qty}}
                             
                            </div>
                            <div class="col-md-2">
                              
                            {{$matlist->stock_qty}}
                             
                            </div>

                          </div>
                          @endif
                            @endforeach
                          <hr>
                          
                          
                           
                            
                        </div>
                      </div>
                    </div>
                  </div>
                  
                        
                   
                </tbody>
                @endforeach
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
    

 
</script>
@endsection