@extends('master')
@section('title','Warehouse Transfer Order List')
@section('link','Warehouse Transfer Order List')
@section('content')
<style>



</style>

<!-- Begin -->

<div class="container">
  <h4>Warehouse Transfer Order Lists For Regional</h4>
             
  <table class="table table-striped">
    <thead>
      <tr class="text-success">
        <th>#</th>
        <th class="text-center">Warehouse Transfer No</th>
        <th class="col-md-3">Regional Name</th>
        <th>Date</th>
        <th>Total Qty</th>
        
        
        <th class="text-center">Action</th>
        <th><span class="pl-3">Status</span></th>
        <th>Deliver Order</th>
        
      </tr>
    </thead>
    <tbody>
    <?php $j=1; ?>
     <!-- Task loop begin -->
      @foreach($wto_list as $eachwtolist)
      <tr>
        <td>{{$j++}}</td>
        <td class="text-center">{{$eachwtolist->warehouse_transfer_no}}</td>
        @foreach($regional as $regname)
        @if($regname->id == $eachwtolist->wto_regional_id)
        <td>{{$regname->warehouse_name}}</td>
        @endif
        @endforeach
        <td>{{$eachwtolist->date}}</td>
        
        <td><span class="pl-3 pr-3">{{$eachwtolist->total_qty}}</span></td>
       
        
        
       
       
        
       
        <td>
        
        <a class="btn btn-info" id="grad1" data-toggle="collapse" href="#issuedetail_{{$eachwtolist->id}}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">&nbsp;&nbsp;<i class="fas fa-angle-double-down"></i>&nbsp;&nbsp;Details</a></td>
        <!-- <button class="btn btn-primary">Accept</button> </td> -->
        @if($eachwtolist->accept_status == 0)
        <td><a href="{{route('accept_wto_regional',$eachwtolist->id)}}" class="btn btn-primary"><i class="fas fa-check"></i>&nbsp;&nbsp;Accept</a></td>
        @else
        <td class="mt-2">&nbsp;<span class="badge badge-success">accepted</td>
        @endif
        @if($eachwtolist->deliver_status == 0 && $eachwtolist->accept_status == 0)
        <td><button class="btn btn-secondary pr-3" disabled>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-truck"></i>&nbsp;&nbsp;&nbsp;Deliver</button></td>
        @elseif($eachwtolist->deliver_status == 0 && $eachwtolist->accept_status == 1)
        <td> <a href="{{route('store_deliver_order_regional',$eachwtolist->id)}}" class="btn btn-danger pr-3" id="grad2">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-truck"></i>&nbsp;&nbsp;&nbsp;Deliver</a></td>
        
        @else
        <td class="">&nbsp;<span class="badge badge-success">Delivered</td>
       
        @endif
        
      </tr>
      
      <tr>
     
      <td colspan="10"><div class="collapse out container mr-5" id="issuedetail_{{$eachwtolist->id}}">
            <div class="row">
            <?php $k=1; ?>
            <div class="col-md-1">
                <label>Index</label>
                
                
                
                
                
              
                
                @foreach($material_issue as $eachmati)
                
                @foreach($mi_wto as $eachmiw)
                @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                @if($eachmati->id == $eachmiw->material_issue_id)
               
                <div class="mt-2 mb-4">
                {{$k++}}
                
                </div>
                @endif
                @endif
                @endforeach
             
             @endforeach
               
             
               
              
               
                </div>
                
                <div class="col-md-2">
                <label>Material Issue No</label>
                @foreach($material_issue as $eachmati)
                
                @foreach($mi_wto as $eachmiw)
                @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                
                @if($eachmati->id == $eachmiw->material_issue_id)
                
                <div class="mt-2 mb-4">
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    
                {{$eachmati->material_issue_no}}
                
                </div>
                @endif
                @endif
                @endforeach
             
                @endforeach
               
                </div>

                
               
               
               
                <div class="col-md-1">
                <label>Code</label>
              @foreach($material_issue as $eachmati)
              @if($eachmati->purchase_order_id == null)
              @foreach($mi_wto as $eachmiw)
              @foreach($material_request as $maq)
              @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
              @if($eachmati->id == $eachmiw->material_issue_id)
              @if($eachmati->material_request_id == $maq->id)
                <div class="mt-2 mb-4">{{$eachmati->material_request->request_code}}</div>
              @endif
              @endif
              @endif
              @endforeach
              @endforeach
              @else
              
                @foreach($mi_wto as $eachmiw)
                @foreach($pur_order as $eachpur)
                @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                @if($eachmati->id == $eachmiw->material_issue_id)
                @if($eachmati->purchase_order_id == $eachpur->id)
                <div class="mt-2 mb-4">
                
                {{$eachpur->order_code}}
                </div>
                @endif
                @endif
                @endif
                @endforeach
                @endforeach
              @endif
                @endforeach
             
                </div>

                <div class="col-md-2 text-center">
                <label>Project</label>
                @foreach($material_issue as $eachmati)
                
                @foreach($mi_wto as $eachmiw)
                @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                @if($eachmati->id == $eachmiw->material_issue_id)
                <div class="mt-2 mb-4">
                
                {{$eachmati->project->project_name}}
                
                </div>
                @endif
                @endif
                @endforeach
             
                @endforeach
                
            
                </div>
                
                <div class="col-md-2 text-center">
                <label>Phase</label>
                @foreach($material_issue as $eachmati)
                
                @foreach($mi_wto as $eachmiw)
                @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                @if($eachmati->id == $eachmiw->material_issue_id)
                <div class="mt-2 mb-4">
                
                {{$eachmati->phase->phase_name}}
                
                </div>
                @endif
                @endif
                @endforeach
             
                @endforeach
                
            
                </div>
                <div class="col-md-2 text-center">
                <label>Total Qty</label>
                @foreach($material_issue as $eachmati)
                
                @foreach($mi_wto as $eachmiw)
                @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                @if($eachmati->id == $eachmiw->material_issue_id)
                
                <div class="mt-2 mb-4">
                    &nbsp;
                {{$eachmati->total_qty}}
                <!-- <a href="" class="bg-primary" data-toggle="modal" data-target=".show_material_"><span class="ml-2 mr-2">Show Unit</span></a> -->
                </div>
                @endif
                @endif
                @endforeach
             
                @endforeach
               
                </div>
                <div class="col-md-2">
                <label>Products</label>
                @foreach($material_issue as $eachmati)
                
                @foreach($mi_wto as $eachmiw)
                @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                @if($eachmati->id == $eachmiw->material_issue_id)
                
                <div class="mt-2 mb-4">
                
                <a href="" class="bg-primary" data-toggle="modal" data-target=".show_product_{{$eachmiw->material_issue_id}}"><span class="ml-2 mr-2">Show Up</span></a>
                </div>
                @endif
                @endif
                @endforeach
             
                @endforeach
               
                </div>

                
                
                
              
               
               
                
                
            
                
                </div>
                
            </div>
           
      </td>
     
     
      </tr>
   
      <!-- Begin file  Modal-->
   
      <div class="modal fade show_photos_" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background-color:#343A40">
        <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel">REPORT TASK FILES</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body bg-light">

              <div class="row">
           
            
              
              <div class="container text-center">
              <video controls>
             
            
              </video>
              </div>
            
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            
          </div>
    </div>
  </div>
</div>

      <!--End file Model-->
      <!-- Begin Modal Approve  -->
      
      <div class="modal fade show_approve_" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content" style="background-color:#343A40">
            <div class="modal-header" style="background-color:#343A40">
              <h5 class="modal-title text-white" id="exampleModalLongTitle">Modal title</h5>
              
            </div>
            <div class="modal-body bg-light">
              <div class="row">
              <div class="col-md-3">
              <label>Task End Date</label>
              <div>
              
              </div>
              </div>
              <div class="col-md-3">
              <label>Finish Date</label>
              <div>
              
              </div>
              </div>
              <div class="col-md-6 text-center">
              <label>Description</label>
              <div>
              
              </div>
              </div>
              
              </div>
            </div>
            <div class="modal-footer bg-light">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <form action="" method="post" id="approve">
                @csrf
              <input type="hidden" name="report_id" value="">
              <button type="submit" class="btn btn-primary">Approve</button>
              </form>
            </div>
          </div>
        </div>
      </div>
     

      <!-- End Modal Approve -->
      <!-- Begin Modal Material -->
      
      @foreach($mi_wto as $eachmiw)
      <div class="modal fade show_product_{{$eachmiw->material_issue_id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
                <div class="modal-header" style="background-color:#343A40">
                   <h5 class="modal-title text-white" id="exampleModalLabel">Product Lists{{$eachmiw->material_issue_id}}</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                   </button>
                  </div>
                  <div class="modal-body">
                    <div class="container">
                        <div class="row">
                        <?php $m=1; ?>
                          <div class="col-md-1">
                          <label>#</label>
                          @foreach($material_issue as $mater)
                          @foreach($material_issue_list as $materlist)
                          @if($eachmiw->material_issue_id == $mater->id)
                          @if($mater->id == $materlist->material_issue_id)
                          <div>
                          {{$m++}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <div class="col-md-4">
                          <label>Product Name</label>
                          @foreach($material_issue as $mater)
                          @foreach($material_issue_list as $materlist)
                          @if($eachmiw->material_issue_id == $mater->id)
                          @if($mater->id == $materlist->material_issue_id)
                          <div class="col-md-4">
                          {{$materlist->product->name}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Brand</label>
                          @foreach($material_issue as $mater)
                          @foreach($material_issue_list as $materlist)
                          @if($eachmiw->material_issue_id == $mater->id)
                          @if($mater->id == $materlist->material_issue_id)
                          <div>
                          {{$materlist->product->brand->name}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Model</label>
                          @foreach($material_issue as $mater)
                          @foreach($material_issue_list as $materlist)
                          @if($eachmiw->material_issue_id == $mater->id)
                          @if($mater->id == $materlist->material_issue_id)
                          <div>
                          {{$materlist->product->model_number}}
                          {{$materlist->product->stock_qty}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Stock Quantity</label>
                          @foreach($material_issue as $mater)
                          @foreach($material_issue_list as $materlist)
                          @if($eachmiw->material_issue_id == $mater->id)
                          @if($mater->id == $materlist->material_issue_id)
                          <div class="col-md-2">
                          
                          {{$materlist->product->stock_qty}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <!-- <div class="col-md-2">
                          <label>Stock Quantity</label>
                          @foreach($material_issue as $mater)
                          @foreach($material_issue_list as $materlist)
                          @if($eachmiw->material_issue_id == $mater->id)
                          @if($mater->id == $materlist->material_issue_id)
                          <div>
                          {{$materlist->product->model_number}}
                          {{$materlist->product->stock_qty}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div> -->
                        </div>
                    </div>
                  </div>
                
          </div>
        </div>
      </div>
      @endforeach
      <!-- end Modal -->
      @endforeach
     <!-- Task loop end -->
    </tbody>
  </table>
</div>


<!-- End -->

@endsection

@section('js')
<script>

function savedo(wto_id)
{
  // alert(wto_id);
  $.ajax({
           type:'POST',
           url:'/store_deliver_order_regional',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}",
           "wto_id":wto_id,
            },

           success:function(data){
              alert(data);
           }
          });
  

}

</script>
@endsection