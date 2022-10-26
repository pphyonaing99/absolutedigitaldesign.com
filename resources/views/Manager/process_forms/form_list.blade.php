@extends('master')
@section('title','Form Lists')
@section('link','Form Lists')
@section('content')


<div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Form List</h3>
           
              <a href="{{route('create_form')}}" id="" class="btn btn-primary float-right janky"> <i class="fa fa-plus"></i> Create Form</a>
            </div>
           
            <!-- /.card-header -->
            <div class="card-body">
           
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                	<tr>
                        <th>No</th>
                    <th>Form Name</th>
                    <th>Approve By</th>
                    <th>Check By</th>
                    <th>Prepare By</th>
                    <th>Index Digit</th>
                    <th>Prefix Syntax</th>
                    <th>Action</th>
                    
                  </tr>
                </thead>
                <?php $i=1; ?>
               
                @foreach($form as $eachform)
                <tbody class="text-center">
                
                    
               
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$eachform->form_name}}</td>
                        @foreach($roles as $eachrole)
                        @if($eachform->approve_by == $eachrole->id)
                        <td class="text-danger">{{$eachrole->name}}</td>
                        @endif
                        @endforeach
                        @foreach($roles as $eachrole)
                        @if($eachform->check_by == $eachrole->id)
                        <td class="text-info">{{$eachrole->name}}</td>
                        @endif
                        @endforeach
                        @foreach($roles as $eachrole)
                        @if($eachform->prepare_by == $eachrole->id)
                        <td class="text-success">{{$eachrole->name}}</td>
                        @endif
                        @endforeach
                        <td class="">{{$eachform->index_digit}}</td>
                        <td>{{$eachform->prefix}}</td>
                        <td>
                        
                        <button type="button" class="btn btn-success" onclick="countdi('{{$eachform->index_digit}}','{{$eachform->id}}')" data-toggle="modal" data-target="#exampleModal{{$eachform->id}}"><i class="fas fa-wrench"></i>&nbsp;&nbsp;&nbsp;Update</button>
                    </td>

                    </tr>
                    @endforeach
                    
                </tbody>
               
              </table>
              
            </div>
          </div>
</div>
@foreach($form as $eachformMo)
<div class="modal fade" id="exampleModal{{$eachformMo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>   
      </div>
      <div class="modal-body">  
        <form action="{{route('update_form')}}" method="post">
          @csrf
          <input type="hidden" value="{{$eachformMo->id}}" name="form_id" >
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Form Name:</label>
            <input type="text" class="form-control" id="form_name" name="form_name" value="{{$eachformMo->form_name}}">
          </div>
          <div class="form-group">
            <label>Approve By</label>
            
            <select class="custom-select" name="approve_role_id">
            
            	@foreach($roles as $role)
              	<option value="{{$role->id}}">{{$role->name}}</option>
              	@endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Check By</label>
            <option>Select Role</option>
            <select class="custom-select" name="check_role_id">
            <option>Select Role</option>
            	@foreach($roles as $role)
              	<option value="{{$role->id}}">{{$role->name}}</option>
              	@endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Prepare By</label>
            
            <select class="custom-select" name="prepare_role_id">
            <option>Select Role</option>
            	@foreach($roles as $role)
              	<option value="{{$role->id}}">{{$role->name}}</option>
              	@endforeach
            </select>
        </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Index Digit:</label>
            <input type="number" class="form-control" id="index{{$eachformMo->id}}" name="index">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Prefix Syntax:</label>
            <input type="text" class="form-control" id="prefix" name="prefix" value="{{$eachformMo->prefix}}">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="reload()">Submit</button>
      </div>
</form>
    </div>
  </div>
</div>
@endforeach


@endsection
@section('js')
<script>

function countdi(value,id)
{
    $len = value.length;
    // alert($len);
    $('#index'+id).val($len);
}


</script>

@endsection