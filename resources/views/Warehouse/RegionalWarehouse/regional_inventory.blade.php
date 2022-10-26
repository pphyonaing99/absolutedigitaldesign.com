@extends('master')
@section('title','Regional Inventory List')
@section('link','Regional Inventory List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Regional Inventory List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Project Name</th>
                	<th>Phase Name</th>
                	<th>Product Name</th>
                  	<th>Quantity</th>
                  	<th>Last Received</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($regional_inventories as $inventory)
                  <tr class="text-center">
                  	<td>{{$i++}}</td>
                  	<td>{{$inventory->project->project_name}}</td>
                  	<td>{{$inventory->phase->phase_name}}</td>
                  	<td>{{$inventory->product->name}}</td>
                  	<td>{{$inventory->reserved_qty}}</td>
                  	<td>{{$inventory->received_date}}</td>
                  </tr>

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

@endsection