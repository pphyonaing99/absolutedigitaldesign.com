@extends('master')
@section('title','Reject List')
@section('link','Reject List')
@section('content')


<div class="row">
    <div class="col-md-12 bg-light">
        <table class="table table-bordered table-striped">
        
                <thead class="text-center thead-dark">
                    <th>#</th>
                	<th>GRN Number</th>
                  	<!-- <th>Ref PR Number</th> -->
                  	<th>Date</th>
                  	<th>Warehouse/Site Name</th>   
                  	<th>Product/Handtool Name</th>
                      <th>Category_name</th>
                    <th>Qty</th>
                    <th>Supplier</th>
                    <th>Purchase Price</th>
                    <th>Remark</th>
                    <th>Delete</th>
                     
                </thead>
                <?php $i=1 ?>
                @foreach($good_receive_notes_reject as $good)
                
                
                <tr>
                <td>{{$i++}}</td>
                <td>{{$good->grn_no}}</td>
                <td>{{$good->date}}</td>
                <td>{{$good->regional_name}}</td>
                <td>{{$good->product_name}}</td>
                <td>{{$good->category_name}}</td>
                <td>{{$good->quantity}}</td>
                <td>{{$good->supplier}}</td>
                <td>{{$good->purchase_price}}</td>
                <td>{{$good->remark}}</td>
                <td class="text-center text-danger"><i class="fa fa-trash"></i></td>
               </tr>
                @endforeach
                </tbody>

    </table>
    </div>
</div>

@endsection