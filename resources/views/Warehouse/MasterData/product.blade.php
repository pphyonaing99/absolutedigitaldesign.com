@extends('master')
@section('title','Product List')
@section('link','Product List')
@section('content')

<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product List</h3>
              <a href="{{route('create_product',$shelve_id)}}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Product</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                	<tr>
                   <th>#</th>
                    <th>S/N</th>
                    <th>Product Name</th>
                    <th>Product Brand</th>
                    <th>Model</th>
                    <th>Product Quantity</th>
                    <th>Product Register Date</th>
                  </tr>
                </thead>
                <?php $i = 1;?>
                <tbody>
                  <tr>
                    @foreach($products as $product)
                    <td>{{$i++}}</td>
                    <td>{{$product->serial_number}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->brand->name}}</td>
                    <td>{{$product->model_number}}</td>
                    <td>{{$product->stock_qty}}</td>
                    <td>{{$product->reg_date}}</td>
                  </tr>

                  <!-- Modal -->
                  <div class="modal fade" id="add_part_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title">Part Register</h3>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form role="form" method="post" action="{{route('store_part')}}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="serial_number">Serial Number</label>
                                <input type="text" class="form-control" name="serial_number" id="serial_number" placeholder="Enter Serial Number">
                              </div>
                              <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Product Name">
                              </div>
                              <div class="form-group">
                                <label for="brand">Brand</label>
                                <input type="text" class="form-control" name="brand_name" id="brand" placeholder="Enter Your Brand Name">
                              </div>
                              <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" name="stock_qty" id="quantity" placeholder="Enter Your Product Quantity">
                              </div>
                              <div class="form-group">
                              <label>Date range:</label>

                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="date" name="reg_date" class="form-control float-right">
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
@endsection