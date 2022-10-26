@extends('master')
@section('title','Material Request List')
@section('link','Material Request List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Material Request List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Request Code</th>
                	<th>Request Date</th>
	                <th>Customer</th>
	                <th>Request Item</th>
	                <!-- <th>Action</th> -->
                </thead>
                <tbody id="material_request">
                	
	                  <?php $i = 1;?>
	                  @foreach($material_requests as $order)

                	 <form method="post" action="{{route('send_material_request',$order->id)}}">
                    @csrf
	                  <tr class="text-center">
	                  	<td>{{$i++}}</td>
	                  	<td>{{$order->request_code}}</td>
	                  	<td>{{$order->request_date}}</td>
                      <td>{{$order->user->name}}</td>
                      <td><a href="" class="btn btn-info">Detail</a></td>
	                    <!-- <td>
                       

                        @foreach($material_request_lists as $material_request_list)
                        @if($order->id == $material_request_list->material_request_id)
                        <div class="row mb-1 mt-3 font-weight-bold" style="font-size:18px;">
                          <div class="col-md-6">
                            {{$material_request_list->product->name}}
                          </div>
                          <div class="col-md-6"> <span id="request_qty">  
                              {{$material_request_list->request_qty}}</span>
                          </div>
                        </div>
                        @endif
                        @endforeach 
                      </td> -->
                      <!-- @if($order->warehouse_status == 1)
                      <td>{{$order->remark}}</td>
                      <td><span class="badge badge-warning p-2">Already Sent</span></td>
                      @elseif($order->warehouse_status == 1 && $order->status == 1)
                      <td><span class="badge badge-success p-2">Done</span></td>
                      @else
	                    <td>
	                    	<input type="text" name="remark" class="form-control">
	                    </td>
	                    <td><input type="submit" name="btnsubmit" data-id="{{$order->id}}" class="btn btn-primary"></td>
                      @endif -->
	                  </tr>
                  	</form>
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
<script type="text/javascript">
  
 $(".btn-submit").click(function(e){
    
    var id=$(this).data('id');

   console.log(id);

  })
  

</script>
@endsection