
@extends('projectmaster')
@section('title','Report Task List')
@section('link')
<li class="breadcrumb-item active"><?=$projectname->project_name?></li>
<li class="breadcrumb-item active"><?=$phasename->phase_name?></li>

@endsection
@section('content')

<div class="container">
  <h3>Task Lists</h3>
             
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Task Name</th>
        <th>Description</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Complete</th>
        <th>Report Task Details</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php $j=1; ?>
      @foreach($taskdetails as $task)<!-- Task loop begin -->
      
      <tr>
        <td>{{$j++}}</td>
        <td>{{$task->task_name}}</td>
        <td>{{$task->description}}</td>
        <td>{{$task->start_date}}</td>
        
        <td>{{$task->end_date}}</td>
        @if($task->complete == 0)
        <td>not complete</td>
        @endif
        @if($task->complete == 1)
        <td>completed</td>
        @endif
       
        <td> <a class="btn btn-primary btn-block" data-toggle="collapse" href="#reporttask{{$task->id}}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">report task</a></td>
        <td></td>
        <td></td>
        
        
      </tr>
      <tr>
      <td colspan="7"><div class="collapse out container mr-5" id="reporttask{{$task->id}}">
            <div class="row">
            <?php $k=1; ?>
            <div class="col-md-1">
                <label>Index</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                
                <div class="mt-2 mb-4">
                {{$k++}}
                
                </div>
                
                @endif
                @endforeach
                </div>
                
                <div class="col-md-1">
                <label>Check By</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                
                <div class="mt-2 mb-4">
                {{$report->checked_by}}
                
                </div>
                
                @endif
                @endforeach
                </div>
               
                <!-- <div class="col-md-3 text-center">
                <label>Description</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                
                <div class="mt-2 mb-4">
                
                {{$report->report_description}}
                </div>
                @endif
                @endforeach
                </div> -->
               
                <div class="col-md-2 text-center">
                <label>Finish Date</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                
                <div class="mt-2 mb-4">
                
                {{$report->finished_date}}
                </div>
                
                @endif
                @endforeach
                </div>
                
                <div class="col-md-1">
                <label>Progress</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                
                <div class="mt-2 mb-4 text-center">
                
                <!-- <progress id="progBar" value="40" max="100" class="mt-2 mb-4"> -->
                {{$report->progress}}
                </div>
                
                @endif
                
                @endforeach
                </div>
                <div class="col-md-2 text-center">
                <label>Materials</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                
                <div class="mt-2 mb-4 text-center">
                
                <a href="" class="bg-primary" data-toggle="modal" data-target=".show_material_{{$report->id}}"><span class="ml-2 mr-2">Show Unit</span></a>
                </div>
               
                @endif
                @endforeach
                </div>
                <div class="col-md-2 mb-3 text-center">
                <label>Report File</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                @if($report->type == 1)
                <div class="mt-2 mb-4">
                <!-- <i class="fas fa-images fa-2x"></i> -->
                <!-- <a href="{{asset('image/'.$report->photo)}}"><span class="ml-2 mr-2"><i class="far fa-play-circle"></i>photo</span></a> -->
                <a href=""  data-toggle="modal" data-target=".show_photos_{{$report->id}}"><span class="ml-2 mr-2"><i class="fas fa-camera fa-spin"></i>photo<sup class="bg-dark rounded  pl-1 pr-1">{{$report->file_count}}</sup></span></a>
                </div>
                
                @endif
                @if($report->type == 2)
                <div class="mt-2 mb-4">
                <!-- <i class="fas fa-images fa-2x"></i> -->
                <!-- <a href="{{asset('video/'.$report->photo)}}"><span class="ml-2 mr-2"><i class="far fa-play-circle"></i>video</span></a> -->
                <a href=""  data-toggle="modal" data-target=".show_photos_{{$report->id}}"><span class="ml-2 mr-2"><i class="fas fa-video fa-spin mr-2"></i>video</span></a>
                </div>
                
                @endif
                @endif
                @endforeach
                </div>
                <div class="col-md-1">
               <label>Approve</label>
               
               @csrf
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                @if($report->change_status == 5)
                <div class="mt-2 mb-4">
                <a class="bg-dark"><span class="mr-2 ml-2">Approved</span></a>
                </div>
                
                @endif
                @if($report->change_status != 5)
                <!-- <form action="{{route('report_product')}}" method="post" id="approve{{$report->id}}"> -->
                <!-- @csrf -->
                <div class="mt-2 mb-4">
                <!-- <input type="hidden" name="report_id" value="{{$report->id}}"> -->
                <!-- <a class="bg-info" onclick="hello('{{$report->id}}')"><span class="mr-2 ml-2">Approve</span></a> -->
                <!-- <button type="submit" >Approve</button> -->
                <!-- Modal link -->
                <a href="" class="bg-primary" data-toggle="modal" data-target=".show_approve_{{$report->id}}"><span class="ml-2 mr-2">Show</span></a>
                <!-- end modal link -->
                </div>
                <!-- </form> -->
                
                @endif
                @endif
                @endforeach
                
                </div>
                <div class="col-md-2 text-center">
                <label>Performance</label>
                @foreach($reports as $report)
                @if($report->task_id == $task->id)
                
                <div class="mt-2 mb-4 text-center">
                @if($report->performance_status == 0)
                <span class="bg-warning ml-2 mr-2 rounded">{{$report->performance}}</span>
                @endif
                @if($report->performance_status == 1)
                <span class="bg-success ml-2 mr-2 rounded">{{$report->performance}}</span>
                @endif
                @if($report->performance_status == 2)
                <span class="bg-info ml-2 mr-2 rounded">{{$report->performance}}</span>
                @endif
                @if($report->performance_status == 3)
                <span class="bg-danger ml-2 mr-2 rounded">{{$report->performance}}</span>
                @endif
                
                </div>
                
                @endif
                @endforeach
                
                </div>
                
            </div>
           
      </td>
     
      </tr>
      <!-- Begin file  Modal-->
      @foreach($reports as $report)
      <div class="modal fade show_photos_{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
             @foreach($onlyphoto as $onlypho)
             @if($report->id == $onlypho->report_task_id)
              @if($report->file_type == 1)
             <a href="{{asset('image/'.$onlypho->file)}}" class="ml-3 mr-3"><embed src="{{asset('image/'.$onlypho->file)}}" height="150px" width="150px" /></a>
              @endif
              @if($report->file_type == 2)
              <div class="container text-center">
              <video controls>
              <source src="{{asset('video/'.$onlypho->file)}}" type="video/mp4">
             <!-- <a href="{{asset('video/'.$onlypho->file)}}" class="pl-3 pr-3"><embed src="{{asset('video/'.$onlypho->file)}}" height="300px" width="500px" /></a> -->
              </video>
              </div>
             @endif
              @endif
              @endforeach
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            
          </div>
    </div>
  </div>
</div>
@endforeach
      <!--End file Model-->
      <!-- Begin Modal Approve  -->
      @foreach($reports as $report)
      <div class="modal fade show_approve_{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
              {{$task->end_date}}
              </div>
              </div>
              <div class="col-md-3">
              <label>Finish Date</label>
              <div>
              {{$report->finished_date}}
              </div>
              </div>
              <div class="col-md-6 text-center">
              <label>Description</label>
              <div>
              {{$report->report_description}}
              </div>
              </div>
              
              </div>
            </div>
            <div class="modal-footer bg-light">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <form action="{{route('report_product')}}" method="post" id="approve{{$report->id}}">
                @csrf
              <input type="hidden" name="report_id" value="{{$report->id}}">
              <button type="submit" class="btn btn-primary">Approve</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach

      <!-- End Modal Approve -->
      <!-- Begin Modal Material -->
      
      @foreach($reports as $report)
      <div class="modal fade show_material_{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                          @foreach($report_task_list as $report_task)
                          @foreach($product_all as $pros)
                          @if($pros->id == $report_task->product_id)
                          @if($report->id == $report_task->report_task_id)
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
                          @foreach($report_task_list as $report_task)
                          @foreach($product_all as $pros)
                          @if($pros->id == $report_task->product_id)
                          @if($report->id == $report_task->report_task_id)
                          <div>
                          {{$pros->name}}
                          </div>
                          @endif
                          @endif
                           @endforeach
                           @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Brand</label>
                          @foreach($report_task_list as $report_task)
                          @foreach($product_all as $pros)
                          @if($pros->id == $report_task->product_id)
                          @if($report->id == $report_task->report_task_id)
                          <div>
                          <?= $pros->brand->name?>
                          </div>
                          @endif
                          @endif
                           @endforeach
                           @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Model</label>
                          @foreach($report_task_list as $report_task)
                          @foreach($product_all as $pros)
                          @if($pros->id == $report_task->product_id)
                          @if($report->id == $report_task->report_task_id)
                          <div>
                          <?= $pros->model_number?>
                          </div>
                          @endif
                          @endif
                           @endforeach
                           @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>S/N</label>
                          @foreach($report_task_list as $report_task)
                          @foreach($product_all as $pros)
                          @if($pros->id == $report_task->product_id)
                          @if($report->id == $report_task->report_task_id)
                          <div>
                          {{$pros->serial_number}}
                          </div>
                          @endif
                          @endif
                           @endforeach
                           @endforeach
                          </div>
                          <div class="col-md-2">
                          <label>Quantity</label>
                          @foreach($report_task_list as $report_task)
                          @foreach($product_all as $pros)
                          @if($pros->id == $report_task->product_id)
                          @if($report->id == $report_task->report_task_id)
                          <div>
                          {{$report_task->stock_qty}}
                          </div>
                          @endif
                          @endif
                           @endforeach
                           @endforeach
                          </div>
                        </div>
                    </div>
                  </div>
                  <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div> -->
          </div>
        </div>
      </div>
      @endforeach
      <!-- end Modal -->
      @endforeach<!-- Task loop end -->
    </tbody>
  </table>
</div>

      
@endsection
@section('js')
<script>
function hello(value)
{
  $('#approve'+value).submit();
}
</script>
@endsection





































