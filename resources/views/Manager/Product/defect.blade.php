@extends('master')
@section('title','Defect List')
@section('link','Defect List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Defect List</h3>
              <a href="#" data-toggle="modal" data-target="#storeDefect" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Defect</a>
             
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                	<tr>
                   <th>#</th>
                    <th>Product Name</th>
                    <th>Added By</th></th>
                    <th>Defect Quantity</th>
                    <th>Defect Date</th>
                    <th>Defect Comment</th>
                  </tr>
                </thead>
                <?php $i = 1;?>
                <tbody>
                  <tr>
                    @foreach($defect_items as $defect_item)
                    <td>{{$i++}}</td>
                    <td>{{$defect_item->product->name}}</td>
                    <td>{{$defect_item->user->name}}</td>
                    <td>{{$defect_item->qty}}</td>
                    <td>{{$defect_item->defect_date}}</td>
                    <td>{{$defect_item->comment}}</td>
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
      
      
  <!-- Modal -->
  <div class="modal fade" id="storeDefect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Defect Report</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" method="post" action="{{route('store-defect')}}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="inventory_id">Select Product</label>
                <select class="form-control" name="inventory_id">
                    @foreach($site_inventories as $inventory)
                    <option value={{$inventory->id}}>{{$inventory->product->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="qty">Quantity</label>
                <input type="number" class="form-control" id="qty" name="qty" placeholder="quantity">
              </div>
              <div class="form-group">
                <label for="comment">Comment</label>
                <input type="text" class="form-control" name="comment" id="comment" placeholder="Enter Your Comment">
              </div>
              <div class="form-group">
              <label>Date range:</label>

              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="date" name="defect_date" class="form-control float-right">
              </div>
              <!-- /.input group -->
            </div>
            </div>
            <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
      <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
<!-- page script -->
@endsection