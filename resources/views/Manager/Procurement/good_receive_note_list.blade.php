@extends('master')
@section('title','Good Receive Note List Main')
@section('link','Good Receive Note List Main')
@section('content')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>GRN Number</th>
    
                  	<th>Date</th>
                  	<th>Warehouse/Site Name</th>
                      <th>Total Qty</th>
                  	<th>Products details</th>
                </thead>
                <tbody class="text-center">
                    @foreach($good_receive_notes as $good)
                        @if(session()->get('user')->hasRole('Warehouse Supervisor'))

                            @if($good->warehouse_flag == 1 && $good->type == 1 && $good->approve_status == 1)

                            <tr>
                               <td>{{$good->grn_no}}</td>
                                <!-- <td>
                                    @foreach($good->warehouse_purchase_order as $pr)
                                    {{$pr->pr_no}}
                                    @endforeach
                                </td> -->
                                <td>{{$good->date}}</td>
                                <td>Main</td>
                                <td>{{$good->total_qty}}</td>
                                <td><a href="{{route('good_receive_note_details', $good->id)}}" class="btn btn-info">Details</a></td> 
                            </tr>
                            @endif
                        @elseif(session()->get('user')->hasRole('Regional Warehouse'))
                            @if($good->warehouse_flag == 2 && $good->type == 1)
                            <form action="{{route('good_receive_note_details_regional')}}" method="get">
                            @csrf
                            
                            
                            <tr>
                               <td>{{$good->grn_no}}</td>
                                <td>
                                    @foreach($good->warehouse_purchase_order as $pr)
                                    {{$pr->pr_no}}
                                    @endforeach
                                </td>
                                <td>{{$good->date}}</td>
                                <td>
                                
                                @foreach($good->regional as $regional)
                                {{$regional->warehouse_name}}  
                                <input type="hidden" name="gid" id="gid" value="{{$good->id}}">
                                <input type="hidden" name="regionalID" id="regionalID" value="{{$regional->id}}"> 
                                @endforeach
                                <td>{{$good->total_qty}}</td>
                                </td>
                                <!-- <td><a href="{{route('good_receive_note_details', $good->id)}}" class="btn btn-info">Details</a></td>  -->
                                <td><input type="submit" value="Details" class="btn btn-info"></td>
                            </tr>
                            </form>
                            @endif
                        @else
                            <tr>
                               <td>{{$good->grn_no}}</td>
                                <td>
                                    @foreach($good->warehouse_purchase_order as $pr)
                                    {{$pr->pr_no}}
                                    @endforeach
                                </td>
                                <td>{{$good->date}}</td>
                                @if($good->warehouse_flag == 1 && $good->type == 1)
                                <td>Main</td>
                                @elseif($good->warehouse_flag == 2 && $good->type == 1)
                                <td>Regional</td>
                                @endif
                                <td><a href="{{route('good_receive_note_details', $good->id)}}" class="btn btn-info">Details</a></td> 
                            </tr>
                        @endif
                    @endforeach
                </tbody>
             </table>
    </div>
</div>

@endsection
@section('js')
<script>
function productdetail(){
    alert("hello");
}
</script>
@endsection

<!-- function getSiteInventoryProject(value){
        
        console.log(value);
        
      var project_id = value;
      
      document.getElementById('forPhase').disabled = false;
      
      $('#forPhase').empty();

       $.ajax({
           type:'POST',
           url:'/getProjectSiteInventory',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":project_id,},

           success:function(data){
            
            console.log(data);
            
             $.each(data.phases, function(i, value) {

              $('#forPhase').append($('<option>').text(value.phase_name).attr('value', value.id));

            });
             
           }
           
        });

    } -->
