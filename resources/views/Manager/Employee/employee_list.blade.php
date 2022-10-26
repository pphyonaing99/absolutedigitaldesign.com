@extends('master')
@section('title','Employee List')
@section('link','Employee List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Employee List</h3>
              <a href="{{route('create_employee')}}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Employee</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<th>#</th>
                	<th>Name</th>
                	<th>Photo</th>
                	<th>Contact</th>
                	<th>Address</th>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                  @foreach($employees as $employee)
                  <tr class="text-center">
                    <td>{{$i++}}</td>
                    <td>{{$employee->name}}</td>
                    <td><img src="{{'/image/'.$employee->photo}}" data-toggle="modal" data-target="#image_{{$employee->id}}" style="width: 50px; height: 50px; cursor: pointer;"></td>
                    <td>{{$employee->phone}}</td>
                    <td>{{$employee->address}}</td>
                  </tr>

                  <!-- Modal -->
                  <div class="modal fade" id="image_{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <img src="{{'image/'.$employee->photo}}" width="750px" height="500px">
                        </div>
                      </div>
                    </div>
                  </div>
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