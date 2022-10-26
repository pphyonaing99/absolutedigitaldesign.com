@extends('master')
@section('title','Warehouse Transfer Order')
@section('link','Warehouse Transfer Order')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Warehouse Transfer List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Project Name</th>
                	<th>Phase Name</th>
                	<th>Customer Name</th>
                	<th>Phone</th>
                	<th>Transfer Date</th>
                  <th>Condition</th>
                	<th>Action</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($material_issues as $material_issue)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$material_issue->project->project_name}}</td>
                  	<td>{{$material_issue->phase->phase_name}}</td>
                  	<td>{{$material_issue->purchase_order->customer_name}}</td>
                  	<td>{{$material_issue->purchase_order->phone}}</td>
                  	<td>{{$material_issue->purchase_order->request_date}}</td>

                    <!-- Showing Process for warehoue Transfer and Delivery Order and Site Done -->
                    @if( $material_issue->warehouse_transfer_status == 1 && $material_issue->delivery_order_status == 0 )
                    <td><span class="badge badge-success p-2">Accepted</span></td>
                    @elseif( $material_issue->delivery_order_status == 1 && $material_issue->status == 0 )
                    <td><span class="badge badge-info p-2">Sending</span></td>
                    @else
                    <td><span class="badge badge-warning p-2">Pending</span></td>
                    @endif

                    @if( $material_issue->warehouse_transfer_status == 1 && $material_issue->delivery_order_status == 0 )
                    <td><a href="{{route('send_delivery_order',$material_issue->id)}}" class="btn btn-primary"><i class="fas fa-share-square"></i> Send Delivery Order</a></td>
                    @elseif( $material_issue->delivery_order_status == 1 && $material_issue->status == 0 )
                    <td><span class="badge badge-info p-2">Sent Delivery Order</span></td>
                    @elseif( $material_issue->status == 1 )
                    <td><span class="badge badge-success p-2">Done</span></td>
                    @else
                    <td><a href="{{route('AcceptWarehouseTransfer',$material_issue->id)}}" class="btn btn-primary"><i class="fas fa-share-square"></i> Accept Transfer</a></td>
                    @endif

                  </tr>

                  <!--Check Stock -->
                  <div class="modal fade" id="issue_{{$material_issue->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Delivery Order Form</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center">

                        	<form>
                        		<input type="hidden" id="purchase_order_id" name="purchase_order_id" value="{{$material_issue->purchase_order_id}}">
                        		<input type="hidden" name="material_issue_id" value="{{$material_issue->id}}">
						        <div class="form-group">
						            <label for="recipient-name" class="float-left">Project:</label>
						            <input type="text" class="form-control" disabled value="{{$material_issue->project->project_name}}" id="recipient-name">
						        </div>
						        <div class="form-group">
						            <label for="message-text"  class="float-left">Phase:</label>
						            <input type="text" class="form-control" disabled value="{{$material_issue->phase->phase_name}}" id="recipient-name">
						        </div>
						        <div class="form-group">
						            <label for="message-text"  class="float-left">Customer Name:</label>
						            <input type="text" class="form-control" disabled value="{{$material_issue->purchase_order->customer_name}}" id="recipient-name">
						        </div>
						        <div class="form-group">
						            <label for="message-text"  class="float-left">Phone:</label>
						            <input type="text" class="form-control" disabled value="{{$material_issue->purchase_order->phone}}" id="recipient-name">
						        </div>
						        <div class="form-group">
						            <label for="message-text"  class="float-left">Delivery Date:</label>
						            <input type="date" class="form-control" name="delivery_date" id="recipient-name">
						        </div>
						        <div class="form-group">
						            <label for="message-text"  class="float-left">Location:</label>
						            <input type="text" class="form-control" name="location" id="recipient-name">
						        </div>
						        <div class="col-md-12">
					                <div class="row bg-info text-center font-weight-bold p-2">
					                    <div class="col-md-6">
					                      <span>Product Name</span>
					                    </div>
					                    <div class="col-md-6">
					                      <span>Request Quantity</span>
					                    </div>
					                  </div>

					                  @foreach($material_issue_list as $item_list)
					                  @if($item_list->material_issue_id == $material_issue->id)
					                  <div class="row mb-1 mt-3 text-center font-weight-bold" style="font-size:18px;">
					                    <div class="col-md-6">
					                      {{$item_list->product->name}}
					                    </div>
					                    <div class="col-md-6">
					                       {{$item_list->stock_qty}}
					                    </div>
					                  </div>
					                <hr>
					                  @endif
					                  @endforeach
					            </div>
					            <input type="submit" name="btnsubmit" class="btn btn-primary float-right btn-submit" value="Send Delivery Order">
					        </form>

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

<script type="text/javascript">
	
	$(".btn-submit").click(function(e){

        e.preventDefault();
        var purchase_order_id = document.getElementById('purchase_order_id').value;

        // var purchase_order_id = $("input[name=purchase_order_id]").val();

        var material_issue_id = $("input[name=material_issue_id]").val();

        var delivery_date = $("input[name=delivery_date]").val();

        var location = $("input[name=location]").val();

        console.log(purchase_order_id);

        /*$.ajax({

           type:'POST',

           url:'/ajaxRequest',

           data:{name:name, password:password, email:email},

           success:function(data){

              alert(data.success);

           }

        });*/



	});

</script>

@endsection