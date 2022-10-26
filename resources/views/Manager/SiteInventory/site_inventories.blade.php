@extends('master')
@section('title','Site Inventory List')
@section('link','Site Inventory List')
@section('content')
<!-- Select2 -->

<div class="card-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Project</label>
        <select class="form-control select2" onchange="getSiteInventoryProject(this.value)">
          <option>Select Project</option>
          @foreach($projects as $project)
            <option value="{{$project->id}}">{{$project->project_name}}</option>
          @endforeach
        </select>
      </div>
      <!-- /.form-group -->
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Phase</label>
        <select class="form-control select2" id="forPhase" name="phase_id" disabled="disabled" onchange="getSiteInventoryPhase(this.value)">
        </select>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- /.row -->
</div>

<div class="card">
            <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Brand Name</th>
                  <th>Quantity</th>
                  <th>Received Date</th>
                </tr>
                </thead>
                <tbody id="site_inventories">
                @foreach($site_inventories as $site_inventory)
                <tr>
                  <td>{{$site_inventory->name}}</td>
                  <td>{{$site_inventory->brand_name}}</td>
                  <td>{{$site_inventory->delivered_qty}}</td>
                  <td>{{$site_inventory->received_date}}</td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  })
  //Get Phase of Project and Site Inventory for project
    function getSiteInventoryProject(value){
      var project_id = value;
      document.getElementById('forPhase').disabled = false;
      $('#forPhase').empty();

       $.ajax({
           type:'POST',
           url:'/getProjectSiteInventory',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":project_id,},

           success:function(data){
            var html = '';
            console.log(data);
             $.each(data.phases, function(i, value) {

              $('#forPhase').append($('<option>').text(value.phase_name).attr('value', value.id));

            });
             $.each(data.site_inventories, function(i, site_inventory) {

              html+=`<tr>
                    <td>${site_inventory.name}</td>
                    <td>${site_inventory.brand_name}</td>
                    <td>${site_inventory.delivered_qty}</td>
                    <td>${site_inventory.received_date}</td>
                  </tr>`;
            });
             $("#site_inventories").html(html);
           }

        });

    }
  //Get Phase of Phase and Site Inventory for phase
    function getSiteInventoryPhase(value){
      var phase_id = value;

       $.ajax({
           type:'POST',
           url:'/getPhaseSiteInventory',
           dataType:'json',
           data:{ "_token": "{{ csrf_token() }}","id":phase_id,},

           success:function(data){
            $('#site_inventories').empty();
            var html = '';
            console.log(data);
             $.each(data, function(i, site_inventory) {

              html+=`<tr>
                    <td>${site_inventory.name}</td>
                    <td>${site_inventory.brand_name}</td>
                    <td>${site_inventory.delivered_qty}</td>
                    <td>${site_inventory.received_date}</td>
                  </tr>`;
            });
             $("#site_inventories").html(html);
           }

        });


    }
</script>
@endsection