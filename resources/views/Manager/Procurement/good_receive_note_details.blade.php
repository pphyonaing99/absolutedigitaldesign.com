@extends('master')
@section('title','Good Receive Note Details')
@section('link','Good Receive Note Details')
@section('content')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            
                <thead class="text-center bg-info">
                    <th>No.</th>
                	<th>Product/Handtool Name</th>
                  	<th>Qty</th>
                  	<th>Supplier</th>
                  	<th>Purchase Price</th>
                  	
                     
                  	@if(!session()->get('user')->hasRole('Project Manager'))
                    @if(session()->get('user')->hasRole('Regional Warehouse') || session()->get('user')->hasRole('Warehouse Supervisor'))
                   
                  	<th>Action</th>
                    <th>Status</th>
                    @endif
                  	@endif
                   
                </thead>
                <tbody class="text-center">
                    @if(session()->get('user')->hasRole('Project Manager'))
                        @foreach($good_receive_note->product as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{$product->pivot->quantity}}</td>
                            <td>{{$product->pivot->supplier}}</td>
                            <td>{{$product->pivot->purchase_price}}</td>
                            <td>{{$product->pivot->remark}}</td>
                        </tr>
                        @endforeach
                    @else
                     @if($good_receive_note->warehouse_flag == 1)
                     <?php $i=1; ?>
                        @foreach($good_receive_note->product as $product)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$product->name}}</td>
                                <!-- <form action="{{route('acceptproduct_main')}}" method="post">
                                @csrf -->
                                <input type="hidden" name="pid" value="{{$product->id}}">
                                <input type="hidden" name="qty" value="{{$product->pivot->quantity}}">
                                <input type="hidden" name="gid" value="{{$good_receive_note->id}}">
                                <td>{{$product->pivot->quantity}}</td>
                                <td>{{$product->pivot->supplier}}</td>
                                <td>{{$product->pivot->purchase_price}}</td>
                                
                                @if(session()->get('user')->hasRole('Warehouse Supervisor'))
                                @if($product->pivot->change_status == 0)
                                <td><button class="btn btn-info" value="Accept" onclick="accept_pro_main('{{$product->pivot->id}}')">Accept</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#main_{{$product->pivot->id}}">Reject</button>
                                <button disabled class="btn btn-secondary">Delete</button>
                            
                            </td>
                                <td><span class=" badge badge-info">stable</span></td>
                                @elseif($product->pivot->change_status == 1)
                                <td><button  disabled class="btn btn-secondary" value="Accept">Accept</button>
                                <button disabled value="Rejects" class="btn btn-secondary">Reject</button>
                                <button disabled class="btn btn-secondary">Delete</button>
                            
                            </td>
                                <td><span class=" badge badge-warning">pending</span></td>
                                @elseif($product->pivot->change_status == 3)
                                <td><button  disabled class="btn btn-secondary" value="Accept">Accept</button>
                                <button disabled value="Rejects" class="btn btn-secondary">Reject</button>
                                <a href="{{route('delete_grnproduct_main',$product->pivot->id)}}" class="btn btn-dark">Delete</a>
                            
                            </td>
                                <td><span class=" badge badge-success">rejected</span></td>
                                @else
                                <td><button disabled class="btn btn-secondary" value="Accept">Accept</button>
                                <button type="button" class="btn btn-secondary" disabled>Reject</button>
                                <!-- <button class="btn btn-dark" onclick="delete_each('{{$product->pivot->id}}')">Delete</button> -->
                                <a href="{{route('delete_grnproduct_main',$product->pivot->id)}}" class="btn btn-dark">Delete</a>
                                
                                </td>
                                <td><span class="p-2 badge badge-success">Accepted</span></td>
                                @endif
                                
                                @endif

                                
                                <!-- </form> -->
                                <!-- Begin Date and remark Modal main -->
                            <div class="modal fade" id="main_{{$product->pivot->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Reject Information</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group">
                                        <label>Reject Date</label>
                                        <input type="date" class="form-control" name="reject_date" id="reject_date{{$product->pivot->id}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <input type="text" class="form-control" name="remark" id="remark{{$product->pivot->id}}">
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                        <button type="button" class="btn btn-danger" onclick="rejectpro_main('{{$product->pivot->id}}')">Reject</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <!-- End data and remark modal main-->
                                
                                
                                
                                <form action="{{route('rejectproductmain')}}" method="post">
                                @csrf
                                <input type="hidden" name="pid" value="{{$product->id}}">
                                <input type="hidden" name="gid" value="{{$good_receive_note->id}}">
                                <input type="hidden" name="proname" value="{{$product->name}}">
                                <input type="hidden" name="qty" value="{{$product->pivot->quantity}}">
                                <input type="hidden" name="sup" value="{{$product->pivot->supplier}}">
                                <input type="hidden" name="pur" value="{{$product->pivot->purchase_price}}">
                                <input type="hidden" name="rem" value="{{$product->pivot->remark}}">
                                <input type="hidden" name="cat" value="{{$product->pivot->category_name}}">
                                
                                
                                </form>
                            </tr>
                            
                        @endforeach
                       @else
                       <?php $i=1; ?>
                       @foreach($good_receive_note->product as $product)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$product->name}}</td>
                                <!-- <form action="{{route('acceptproduct_regional')}}" method="post"> -->
                                @csrf
                                <input type="hidden" name="rwid" value="{{$regID}}">
                                <input type="hidden" name="pid" value="{{$product->id}}">
                                <input type="hidden" name="qty" value="{{$product->pivot->quantity}}">
                                <input type="hidden" name="gid" value="{{$good_receive_note->id}}">
                                <td>{{$product->pivot->quantity}}</td>
                                <td>{{$product->pivot->supplier}}</td>
                                <td>{{$product->pivot->purchase_price}}</td>
                                
                                @if(session()->get('user')->hasRole('Regional Warehouse'))
                                
                                
                                @if($product->pivot->change_status == 0)
                                <td><input type="button" onclick="accept_pro_reg('{{$product->pivot->id}}','{{$regID}}')" class="btn btn-info" value="Accept">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$product->pivot->id}}">Reject</button>
                                <button class="btn btn-secondary" disabled>Delete</button>
                            </td>
                                <td><span class=" badge badge-info">stable</span></td>
                                @elseif($product->pivot->change_status == 1)
                                <td><button disabled class="btn btn-secondary" value="Accept">Accept</button>
                                <button type="button" class="btn btn-secondary" disabled>Reject</button>
                                <button class="btn btn-secondary" disabled>Delete</button>
                            </td>
                                <td><span class="p-2 badge badge-warning">pending</span></td>

                                @elseif($product->pivot->change_status == 3)
                                <td><button disabled class="btn btn-secondary" value="Accept">Accept</button>
                                <button type="button" class="btn btn-secondary" disabled>Reject</button>
                                <a href="{{route('delete_grnproduct_reg',$product->pivot->id)}}" class="btn btn-dark">Delete</a>
                            </td>
                                <td><span class="p-2 badge badge-success">rejected</span></td>
                                @else
                                <td><button disabled class="btn btn-secondary" value="Accept">Accept</button>
                                <button type="button" class="btn btn-secondary" disabled>Reject</button>
                                <!-- <button class="btn btn-dark" onclick="delete_each('{{$product->pivot->id}}')">Delete</button> -->
                                <a href="{{route('delete_grnproduct_reg',$product->pivot->id)}}" class="btn btn-dark">Delete</a>
                                
                            </td>
                                <td><span class="p-2 badge badge-success">Accepted</span></td>
                                @endif
                                <!-- </form> -->
                                
                                
                                
                                
                                
                                <form  id="rejectform" action="{{route('rejectproductware')}}" method="post">
                                @csrf
                                
                                <input type="hidden" name="rwn" value="{{$regname}}">
                                <input type="hidden" name="rwid" value="{{$regID}}">
                                <input type="hidden" name="pid" value="{{$product->id}}">
                                <input type="hidden" name="qty" value="{{$product->pivot->quantity}}">
                                <input type="hidden" name="grnid" id="grnid" value="{{$good_receive_note->id}}">
                                
                                
                                <input type="hidden" name="proname" value="{{$product->name}}">
                                
                                <input type="hidden" name="sup" value="{{$product->pivot->supplier}}">
                                <input type="hidden" name="pur" value="{{$product->pivot->purchase_price}}">
                                <input type="hidden" name="rem" value="{{$product->pivot->remark}}">
                                <input type="hidden" name="cat" value="{{$product->pivot->category_name}}">
                                
                                
                                
                               
                                
                                @endif
                            </tr>
                            
                            <!-- Begin Date and remark Modal -->
                            <div class="modal fade" id="exampleModal{{$product->pivot->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Reject Information</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group">
                                        <label>Reject Date</label>
                                        <input type="date" class="form-control" name="reject_date" id="reject_date{{$product->pivot->id}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <input type="text" class="form-control" name="remark" id="remark{{$product->pivot->id}}">
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                        <button type="button" class="btn btn-danger" onclick="rejectpro('{{$product->pivot->id}}','{{$regID}}')">Reject</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <!-- End data and remark modal -->
                            
                        @endforeach
                     @endif
                    @endif
                </tbody>
             </table>
             
    </div>
</div>

@endsection

@section('js')

<script>

function rejectpro(value,regid)
{
    var date = $('#reject_date'+value).val();
    var remark = $('#remark'+value).val();
    // alert(date);
    $.ajax({
            type:'POST',
            url:'/ajaxReject_grnproduct',
            dataType:'json',
            data:{
                    "_token":"{{csrf_token()}}",
                    "grn_pivotpro_id":value, 
                    "regional_id" :regid,
                    "date" :date,
                    "remark":remark,
                },

                success:function(data){
                    swal({

                            title:"Success!",
                            text:"Successfully Request to Reject !!",
                            icon:"success",
                            })
setTimeout(function(){
             		window.location.reload();
             	},1000);

                }
            });

}

function rejectpro_main(value)
{
    var date = $('#reject_date'+value).val();
    var remark = $('#remark'+value).val();
    // alert(date);
    $.ajax({
            type:'POST',
            url:'/ajaxReject_grnproduct_main',
            dataType:'json',
            data:{
                    "_token":"{{csrf_token()}}",
                    "grn_pivotpro_id":value, 
                    
                    "date" :date,
                    "remark":remark,
                },

                success:function(data){
                    swal({

                            title:"Success!",
                            text:"Successfully Request to Reject !!",
                            icon:"success",
                            })
setTimeout(function(){
             		window.location.reload();
             	},1000);

                }
            });
}
function accept_pro_reg(value,reg_id)
{
    alert(value+" -- "+reg_id);
    $.ajax({
            type:'POST',
            url:'/ajaxAccept_grnproduct_reg',
            dataType:'json',
            data:{
                    "_token":"{{csrf_token()}}",
                    "grn_pivotpro_id":value, 
                    "regional_id":reg_id,
                    
                },

                success:function(data){
                    swal({

                        title:"Success!",
                        text:"Successfully Accepted!!",
                        icon:"success",
                        })
                        setTimeout(function(){
                        window.location.reload();
                        },1000);

                }
    });

}

function accept_pro_main(value)
{
    // alert(value);
    $.ajax({
            type:'POST',
            url:'/ajaxAccept_grnproduct_main',
            dataType:'json',
            data:{
                    "_token":"{{csrf_token()}}",
                    "grn_pivotpro_id":value, 
                    
                    
                },

                success:function(data){
                    swal({

                            title:"Success!",
                            text:"Successfully Accepted!!",
                            icon:"success",
                            })
                            setTimeout(function(){
                            window.location.reload();
                            },1000);

                }
            });
}

function delete_each(value)
{
    alert(value);
    $.ajax({
            type:'POST',
            url:'/delete_grnproduct_reg',
            dataType:'json',
            data:{
                    "_token":"{{csrf_token()}}",
                    "grn_pivotpro_id":value, 
                    
                    
                },

                success:function(data){
                    if(data == 0)
                    {
                        swal({

                                title:"Success!",
                                text:"All Products are empty!!",
                                icon:"success",
                                })
                                setTimeout(function(){
                                window.location.reload();
                                },1000);
                    }
                    else
                    {
                    swal({

                            title:"Success!",
                            text:"Successfully Deleted!!",
                            icon:"success",
                            })
                            setTimeout(function(){
                            window.location.reload();
                            },1000);
                        }

                }
            });

}


</script>
@endsection