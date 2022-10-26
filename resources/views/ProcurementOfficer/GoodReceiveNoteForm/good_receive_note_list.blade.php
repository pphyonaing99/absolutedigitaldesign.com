@extends('master')
@section('title','Good Receive Note List')
@section('link','Good Receive Note List')
@section('content')
<div class="row">
<div class="col-md-6">
<h3><i><b>Good Receive Note Lists</b></i></h3>
</div>

@foreach(session()->get('formlist_prepare') as $eachpre)
          
@if($eachpre->prepare_by == 1 && $eachpre->id == 1)

<div class="col-md-6 mb-3">
<a href="{{route('good_receive_form')}}" class="btn btn-info float-right">Add Good Receive Note</a>>
</div>

@endif
@endforeach
@foreach(session()->get('formlist_prepare') as $eachpre)
          
@if($eachpre->prepare_by == 4 && $eachpre->id == 1)

<div class="col-md-6 mb-3">
<a href="{{route('good_receive_form')}}" class="btn btn-info float-right">Add Good Receive Note</a>>
</div>

@endif
@endforeach
@foreach(session()->get('formlist_prepare') as $eachpre)
          
@if($eachpre->prepare_by == 3 && $eachpre->id == 1)

<div class="col-md-6 mb-3">
<a href="{{route('good_receive_form')}}" class="btn btn-info float-right">Add Good Receive Note</a>>
</div>

@endif
@endforeach

</div>

<div class="row">
    <div class="col-md-12">

        <table class="table table-bordered table-striped">
                <thead class="text-center bg-info">
                	<th>GRN Number</th>
                  	<!-- <th>Ref PR Number</th> -->
                  	<th>Required Date</th>
                    <th>Total Qty</th>
                  	<th>Destination</th>
                    <!-- Check approve by manager and officer -->
                    @foreach(session()->get('formlist_approve') as $eachapprove)
                    @if($eachapprove->prepare_by == 1 && $eachapprove->id == 1)
                   <th>Status</th>
                   @endif
                   @endforeach
                   @foreach(session()->get('formlist_approve') as $eachapprove)
                    @if($eachapprove->prepare_by == 4 && $eachapprove->id == 1)
                   <th>Status</th>
                   @endif
                   @endforeach
                   @foreach(session()->get('formlist_approve') as $eachapprove)
                    @if($eachapprove->prepare_by == 3 && $eachapprove->id == 1)
                   <th>Status</th>
                   @endif
                   @endforeach
                    
                   
                    <!-- end approve by manager and officer -->
                  	<th>Products details</th>
                </thead>
                <tbody class="text-center">
                    
                    @foreach($good_receive_notes as $good)
                    
                        @if(session()->get('user')->hasRole('Warehouse Supervisor'))
                      
                            
                            <tr>
                               <td>{{$good->grn_no}}</td>
                                <!-- <td>
                                    @foreach($good->warehouse_purchase_order as $pr)
                                    {{$pr->pr_no}}
                                    @endforeach
                                </td> -->
                                <td>{{$good->date}}</td>
                                <td>{{$good->total_qty}}</td>
                                <td>Main</td>
                                @foreach(session()->get('formlist_approve') as $eachapprove)
          
                                @if($eachapprove->approve_by == 3 && $eachapprove->id == 1)
                                    @if($good->approve_status == 1)
                                    <td><span class="p-2 badge badge-success text-center">Approved</span></td>
                                    @else
                                    <td id="approve{{$good->id}}"><button  id="pend{{$good->id}}" class="btn btn-info pend" onclick="onapprove('{{$good->id}}')">Approve</button></td>
                                    
                                    @endif
                                @endif

                                @endforeach
                                
                               
                                <td><a href="{{route('good_receive_note_details', $good->id)}}" class="btn btn-info">Details-Ware</a></td> 
                            </tr>
                            
                       
                        @elseif(session()->get('user')->hasRole('Regional Warehouse'))
                        
                        @foreach($good_reg as $eachgood_reg)
                       
                            @if($good->warehouse_flag == 2 && $good->type == 1 && $good->approve_status == 1 && $eachgood_reg->regional_warehouse_id == session()->get('regional_id'))
                            @if($eachgood_reg->good_receive_note_id == $good->id)
                            <form action="{{route('good_receive_note_details_regional')}}" method="get">
                            @csrf
                            
                            
                            <tr>
                               <td>{{$good->grn_no}}</td>
                                <!-- <td>
                                    @foreach($good->warehouse_purchase_order as $pr)
                                    {{$pr->pr_no}}
                                    @endforeach
                                </td> -->
                                <td>{{$good->date}}</td>
                                <td>{{$good->total_qty}}</td>
                                
                                
                    <td>
                                @foreach($reg_name as $regional)
                                
                                @if($regional->id == session()->get('regional_id'))
                                {{$regional->warehouse_name}}  
                                <input type="hidden" name="gid" id="gid" value="{{$good->id}}">
                                <input type="hidden" name="regionalID" id="regionalID" value="{{$regional->id}}"> 
                                @endif
                                @endforeach
                                
                                </td>
                                <!-- <td><a href="{{route('good_receive_note_details', $good->id)}}" class="btn btn-info">Detailsreg</a></td>  -->
                                <td><input type="submit" value="Detailsreg" class="btn btn-info"></td>
                            </tr>
                            </form>
                            @endif
                            @endif
                            
                            @endforeach
                        @else
                            
                               <td>{{$good->grn_no}}</td>
                                <!-- <td>
                                    @foreach($good->warehouse_purchase_order as $pr)
                                    {{$pr}}
                                    @endforeach
                                </td> -->
                                <td>{{$good->date}}</td>
                                <td>{{$good->total_qty}}</td>
                                @if($good->warehouse_flag == 1)
                                <td>Main</td>
                                @elseif($good->warehouse_flag == 2)
                                <td>Regional</td>
                                @endif
                                <!-- Check Approve By manager and officer-->
                                @foreach(session()->get('formlist_approve') as $eachapprove)
          
                                @if($eachapprove->approve_by == 1 && $eachapprove->id == 1)
                                    @if($good->approve_status == 1)
                                    <td><span class="p-2 badge badge-success text-center">Approved</span></td>
                                    @else
                                    <td id="approve{{$good->id}}"><button  id="pend{{$good->id}}" class="btn btn-info pend" onclick="onapprove('{{$good->id}}')">Approve</button></td>
                                    
                                    @endif
                                @endif

                                @endforeach
                                @foreach(session()->get('formlist_approve') as $eachapprove)
          
                                @if($eachapprove->approve_by == 4 && $eachapprove->id == 1)
                                    @if($good->approve_status == 1)
                                    <td><span class="p-2 badge badge-success text-center">Approved</span></td>
                                    @else
                                    <td id="approve{{$good->id}}"><button  id="pend{{$good->id}}" class="btn btn-info pend" onclick="onapprove('{{$good->id}}')">Approve</button></td>
                                    
                                    @endif
                                    
                                @endif

                                @endforeach
                            
                                
                                <!-- end check approve by manager and officer-->
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
$( document ).ready(function() {
    $('.approve').hide();
});
function onapprove(value)
{
    // alert(value);
    $.ajax({
		      type:'POST',
		      url:'/ajaxonapprovegrn',
		      dataType:'json',
		      data:{"_token": "{{ csrf_token() }}",
              "grn_id":value},

		      success:function(data){
		        console.log(data);
                var htmlapp = "";
                htmlapp += `
                <button class="btn btn-success approve">Approved</button>
                `
                $('#approve'+value).html(htmlapp);
		        swal({
		          'title':"Successful!",
		          'text':"Successfully Approved!",
		          'icon':"success",

		        })
		      }
	    	});
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