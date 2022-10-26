@extends('master')
@section('title','Good Receive Note Details')
@section('link','Good Receive Note Details')
@section('content')
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            
                <thead class="text-center">
                   
                	<th>Product/Handtool Name</th>
                  	<th>Qty</th>
                  	<th>Supplier</th>
                  	<th>Purchase Price</th>
                  	<th>Remark</th>
                  	
                  	
                      
                
                </thead>
                <tbody class="text-center">
                        
                        @foreach($good_receive_note->product as $products)
                        
                        <tr>
                        
                        <td>{{$products->name}}</td>
                        <td>{{$products->pivot->quantity}}</td>
                        <td>{{$products->pivot->supplier}}</td>
                        <td>{{$products->pivot->purchase_price}}</td>
                        <td>{{$products->pivot->remark}}</td>  
                         
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection