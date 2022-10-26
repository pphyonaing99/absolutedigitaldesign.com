@extends('master')
@section('title','Check Warehouse Transfer')
@section('link','Check Warehouse Transfer')
@section('content')
<style type="text/css">
	span{
		user-select: none;	
	}
</style>
<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Check Warehouse Transfer</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center bg-info">
                	<th>#</th>
					<th>Material Issue No</th>
                	<th>Project Name</th>
					<th>Phase Name</th>
                	<th>Customer Name</th>
                	<th>Phone</th>
                	<th>Transfer Date</th>
                  	<th>Approval</th>
                	<th>Regional Warehouse Transfer</th>
                	<th>Site Delivery Order</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($material_issues as $material_issue)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
					<td>{{$material_issue->material_issue_no}}</td>
					<td>{{$material_issue->project->project_name}}</td>
                  	<td>{{$material_issue->phase->phase_name}}</td>
                  	@if($material_issue->purchase_order_id != null)
                  	<td>{{$material_issue->purchase_order->customer_name}}</td>
                  	<td>{{$material_issue->purchase_order->phone}}</td>
                  	<td>{{$material_issue->purchase_order->request_date}}</td>
                  	@else
                  	<td>{{$material_issue->material_request->user->name}}</td>
					  <td>Not Yet</td>
                  	<!-- <td>{{$material_issue->material_request->user->phone}}</td> -->
                  	<td>{{$material_issue->material_request->request_date}}</td>
                    @endif
                    
                    <!-- Showing Process for warehoue Transfer and Delivery Order and Site Done -->
                    @if( $material_issue->approve == 1 )
                    <td><span class="badge badge-success p-2"><i class="fas fa-check text-light pr-1 rounded-circle"></i>Approved</span></td>
                    @else
                    <td><a href="#" onclick="ApproveWarehouseTransfer('{{$material_issue->id}}')" class="btn btn-primary"><i class="fas fa-share-square"></i>&nbsp;&nbsp;Approve </a></td>
                    @endif

                    <!-- Showing Process for warehoue Transfer and Delivery Order and Site Done -->
                    @if( $material_issue->status == 1 )
                    <td>
                    	<span class="badge badge-success p-2 mt-2"><i class="fas fa-check text-light pr-1 rounded-circle"></i>Accepted</span>
                    </td>
                    @else
                    <td><span  class="badge badge-warning text-white p-2 pt-2 mt-2"><i class="fas fa-exclamation-circle text-white pr-1 rounded-circle"></i>Pending...</span></td>
                    @endif

                    <!-- Showing Process for warehoue Transfer and Delivery Order and Site Done -->
                    @if( $material_issue->approve_delivery_order == 1 )
                    <td>
                    	<span class="badge badge-success p-2 mt-2"><i class="fas fa-check text-light pr-1 rounded-circle"></i>Accepted Delivery Order</span>
                    </td>
                    @elseif($material_issue->status == 0 )
                    <td><span class="badge badge-danger p-2 mt-2"><i class="fas fa-exclamation-circle pr-1 rounded-circle"></i>Pending...</span></td>
                    @elseif($material_issue->status == 1 && $material_issue->delivery_order_status == 0)
                    <td><span class="badge badge-info p-2 mt-2"><i class="fas fa-exclamation-circle pr-1 rounded-circle"></i>Pending...</span></td>
                    @elseif($material_issue->status == 1 && $material_issue->delivery_order_status == 1 )
                    <!-- <td><span class="badge badge-secondary p-2 mt-2"><i class="fas fa-exclamation-circle pr-1 rounded-circle"></i>Wating Delivery Order</span></td> -->
					<td><span class="badge badge-success p-2 mt-2"><i class="fas fa-truck"></i>&nbsp;&nbsp; Delivered </span></td>
                    @else
                    <td><a href="#" onclick="ApproveDeliveryOrder('{{$material_issue->id}}')" class="btn btn-primary"><i class="fas fa-share-square"></i> Approve </a></td>
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
						        @if($material_issue->purchase_order_id != null)
						        <div class="form-group">
						            <label for="message-text"  class="float-left">Customer Name:</label>
						            <input type="text" class="form-control" disabled value="{{$material_issue->purchase_order->customer_name}}" id="recipient-name">
						        </div>
						        <div class="form-group">
						            <label for="message-text"  class="float-left">Phone:</label>
						            <input type="text" class="form-control" disabled value="{{$material_issue->purchase_order->phone}}" id="recipient-name">
						        </div>
						        @endif
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
	
	function ApproveWarehouseTransfer(material_issue_id){


    	swal({
		    title: "Are you sure you want to Approve?",
		    icon:'warning',
			buttons: ["Cancel", "Approve"]
	  	})

	  	.then((isConfirm)=>{
		  	
		  	if(isConfirm){

		  		$.ajax({
		        	type:'POST',
		           	url:'ApproveWarehouseTransfer',
		           	dataType:'json',
		           	data:{  "_token": "{{ csrf_token() }}","material_issue_id":material_issue_id,},

		        	success: function(data){
                    	console.log(data);
                    	swal({
                            title: "Success!",
                            text : "Approved Warehouse Transfer \n Click OK to refresh the page",
                            icon : "success",
                        });

                        setTimeout(function(){
						   window.location.reload();
						}, 1000);

                        
                   	},       			
                });
		  	}
	  	});


    }
	function ApproveDeliveryOrder(material_issue_id){


    	swal({
		    title: "Are you sure you want to Approve?",
		    icon:'warning',
			buttons: ["Cancel", "Approve"]
	  	})

	  	.then((isConfirm)=>{
		  	
		  	if(isConfirm){

		  		$.ajax({
		        	type:'POST',
		           	url:'ApproveDeliveryOrder',
		           	dataType:'json',
		           	data:{  "_token": "{{ csrf_token() }}","material_issue_id":material_issue_id,},

		        	success: function(data){
                    	console.log(data);
                    	swal({
                            title: "Success!",
                            text : "Approved Warehouse Transfer \n Click OK to refresh the page",
                            icon : "success",
                        });

                        setTimeout(function(){
						   window.location.reload();
						}, 1000);

                        
                   	},       			
                });
		  	}
	  	});


    }

</script>

@endsection