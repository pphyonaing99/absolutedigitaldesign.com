@extends('master')
@section('title','Warehouse Transfer Order List')
@section('link','Warehouse Transfer Order List')
@section('content')
<style>



</style>

<!-- Begin -->

<div class="container">
  <div class="row">
    <div class="col-md-9">
  <h3>Warehouse Transfer Order Lists</h3>
</div>
<div class="col-md-3">
  <a href="{{route('material_issue')}}" class="btn btn-info mb-2 "><i class="fas fa-plus"></i>&nbsp;&nbsp;New Warehouse Transfer Order</a>
</div>
  </div>
  <table class="table table-striped">
    <thead>
      <tr class="text-success">
        <th>#</th>
        <th class="text-center">Warehouse Transfer No</th>
        <th class="col-md-3">Regional Name</th>
        <th>Date</th>
        <th>Total Quantity</th>
        
        <th>Material Issue Details</th>
        
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
        
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$eachwtolist->total_qty}}</td>
       
        
        
       
       
        
       
        <td> <a class="btn btn-info pr-5" id="grad1" data-toggle="collapse" href="#issuedetail_{{$eachwtolist->id}}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-double-down"></i>&nbsp;&nbsp;&nbsp;Details</a></td>
        
        
        
      </tr>
      
      <tr>
     
      <td colspan="7"><div class="collapse out container mr-5" id="issuedetail_{{$eachwtolist->id}}">
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
                
                <div class="mt-2 mb-3">
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                {{$eachmati->material_issue_no}}
                
                </div>
                @endif
                @endif
                @endforeach
             
                @endforeach
               
                </div>

                
               
               
               
                <div class="col-md-1">
                <label>PO Code</label>
                @foreach($material_issue as $eachmati)
                
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
                
                <a href="" class="bg-primary" data-toggle="modal" data-target=".show_product_{{$eachwtolist->id}}"><span class="ml-2 mr-2">Show Up</span></a>
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
      
     
      <div class="modal fade show_product_{{$eachwtolist->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
                <div class="modal-header" style="background-color:#343A40">
                   <h5 class="modal-title text-white" id="exampleModalLabel">Product Lists</h5>
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
                          @foreach($mi_wto as $eachmiw)
                          @foreach($material_issue_list as $eachmatilist)
                          @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                          @if($eachmiw->material_issue_id == $eachmatilist->material_issue_id)
                          <div>
                          {{$m++}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <div class="col-md-3">
                          <label>Product Name</label>
                          @foreach($mi_wto as $eachmiw)
                          @foreach($material_issue_list as $eachmatilist)
                          @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                          @if($eachmiw->material_issue_id == $eachmatilist->material_issue_id)
                          <div class="col-md-3">
                          {{$eachmatilist->product->name}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Brand</label>
                          @foreach($mi_wto as $eachmiw)
                          @foreach($material_issue_list as $eachmatilist)
                          @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                          @if($eachmiw->material_issue_id == $eachmatilist->material_issue_id)
                          <div>
                          {{$eachmatilist->product->brand->name}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Model</label>
                          @foreach($mi_wto as $eachmiw)
                          @foreach($material_issue_list as $eachmatilist)
                          @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                          @if($eachmiw->material_issue_id == $eachmatilist->material_issue_id)
                          <div>
                          {{$eachmatilist->product->model_number}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                          <!-- <div class="col-md-2">
                          <label>S/N</label>
                          @foreach($mi_wto as $eachmiw)
                          @foreach($material_issue_list as $eachmatilist)
                          @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                          @if($eachmiw->material_issue_id == $eachmatilist->material_issue_id)
                          <div>
                          {{$eachmatilist->product->serial_number}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div> -->
                          <div class="col-md-2">
                          <label>Quantity</label>
                          @foreach($mi_wto as $eachmiw)
                          @foreach($material_issue_list as $eachmatilist)
                          @if($eachwtolist->id == $eachmiw->warehouse_transfer_order_id)
                          @if($eachmiw->material_issue_id == $eachmatilist->material_issue_id)
                          <div class="ml-3 mr-3">
                          {{$eachmatilist->product->stock_qty}}
                          </div>
                          @endif
                          @endif
                          @endforeach
                          @endforeach
                          </div>
                        </div>
                    </div>
                  </div>
                
          </div>
        </div>
      </div>
      
      <!-- end Modal -->
      @endforeach
     <!-- Task loop end -->
    </tbody>
  </table>
</div>


<!-- End -->

@endsection