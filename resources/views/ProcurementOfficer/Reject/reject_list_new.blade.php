@extends('master')
@section('title','Reject List')
@section('link','Reject List')
@section('content')


<div class="row">
    <div class="col-md-12 bg-light">
        <table class="table table-bordered table-striped">
        
                <thead class="text-center bg-primary">
                    <th>#</th>
                	<th>GRN Number</th>
                  	
                  	<th>Reject Date</th>
                    <th>Product Name</th>
                    <th>Model</th>
                    <th>Brand</th>
                    <th>Reject Qty</th>
                  	<th>Warehouse/Site Name</th>   
                  	
                      
                    
                    
                    
                    
                    <th>Remark</th>
                    @if(session()->get('user')->hasRole('Warehouse Supervisor'))
                    <th>Action</th>
                    @endif
                    <th>Status</th>
                     
                </thead>
                <?php $i=1 ?>
                
                
                @foreach($good_receive_notes_reject as $good)
                <tbody class="text-center">
                
                <tr>
            @if($good->grn_id != null)
                @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$i++}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>{{$i++}}</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$grn->grn_no}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>{{$dor->do_no}}</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$good->reject_date}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>not yet</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$good->product->name}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>{{$good->product->name}}</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$good->product->model_number}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>{{$good->product->model_number}}</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$good->product->brand->name}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>{{$good->product->brand->name}}</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$good->reject_qty}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>{{$good->reject_qty}}</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
               @if($good->grn_id == $grn->id)
                @if($good->regional_id == null)
                <td>Main Warehouse</td>
                @else
                
                <td>{{$good->regional->warehouse_name}}</td>
                @endif
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>DO destination</td>
                @endif
                @endforeach
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                <td>{{$good->remark}}</td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>DO remark</td>
                @endif
                @endforeach
            @endif
            @if(session()->get('user')->hasRole('Warehouse Supervisor'))
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)

                <td>
                @if($good->status == 0)
                    <button class="btn btn-info" onclick="approve_reject_pro('{{$good->id}}')">Approve</button>
                    <button class="btn btn-secondary" disabled>Delete</button>
                @else
                     <button class="btn btn-secondary" disabled>Approve</button>
                     <button class="btn btn-danger">Delete</button>
                @endif
                    
                </td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>
                @if($good->status == 0)
                    <!-- <button class="btn btn-info" onclick="approve_reject_pro('{{$good->id}}')">Approve</button>
                    <button class="btn btn-secondary" disabled>Delete</button> -->
                    <span class="pt-2 pb-2 pl-3 pr-3 badge badge-secondary">Notic</span>
                @else
                     <button class="btn btn-secondary" disabled>Approve</button>
                     <button class="btn btn-danger">Delete</button>
                @endif
                </td>
                @endif
                @endforeach
            @endif
            
            @endif
            @if($good->grn_id != null)
               @foreach($grn_list as $grn)
                @if($good->grn_id == $grn->id)
                
                <td>
                @if($good->status == 0)
                <span class=" badge badge-warning">pending</span>
                @else
                <span class=" badge badge-success">approved</span>
                @endif
                </td>
                @endif
               @endforeach
            @else
                @foreach($deliver_order as $dor)
                @if($good->do_id == $dor->id)
                <td>
                @if($good->status == 0)
                <span class=" badge badge-secondary">continue</span>
                @else
                <span class=" badge badge-success">continue</span>
                @endif 
                </td>
                @endif
                @endforeach
            @endif   
                

                
               </tr>
               
                </tbody>
               
                @endforeach
    </table>
    </div>
</div>

@endsection

@section('js')

<script>
function approve_reject_pro(value)
{
    alert(value);
    $.ajax({
           type:'POST',
           url:'/approve_reject_item_reg',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "reject_id":value,},
            
           success:function(data){
            swal({

                    title:"Success!",
                    text:"Successfully Approve to Reject Request !!",
                    icon:"success",
                    })
                    setTimeout(function(){
                    window.location.reload();
                    },1000);
           }
        });
}


</script>

@endsection