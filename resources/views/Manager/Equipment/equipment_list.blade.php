@extends('master')
@section('title','Equipment List')
@section('link','Equipment List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Equipment List</h3>
              <a href="{{route('create_equipment')}}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Equipment</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                	<th>#</th>
                	<th>S/N</th>
                	<th>Equipment Name</th>
                	<th>Equipment Brand</th>
                	<th>Equipment Quantity</th>
                	<th>Equipment Register Date</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($equipments as $equipment)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$equipment->serial_number}}</td>
                    <td>{{$equipment->name}}</td>
                    <td>{{$equipment->brand_name}}</td>
                    <td>{{$equipment->stock_qty}}</td>
                    <td>{{$equipment->reg_date}}</td>
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
<script>
  $(function () {
    $("#example1").DataTable();
</script>
@endsection