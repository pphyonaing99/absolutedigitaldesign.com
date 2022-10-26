@extends('master')
@section('title','General Setting')
@section('content')

<input type="checkbox" name="" id="checkbox_master">

@endsection
@section('js')

<script type="text/javascript">
	$('#checkbox_master').click(function(){
		var html = '';
      	var checked = document.getElementById('checkbox_master').checked;
      	if (checked == true) {
      		html += `<a href="#" class="nav-link">
		              <i class="nav-icon fas fa-tachometer-alt"></i>
		              <p>
		                Master Data
		                <i class="right fas fa-angle-left"></i>
		              </p>
		            </a>
		            <ul class="nav nav-treeview">
		              <li class="nav-item">
		                <a href="{{route('product_list')}}" class="nav-link">
		                  <i class="far fa-circle nav-icon"></i>
		                  <p>Product</p>
		                </a>
		              </li>
		              <li class="nav-item">
		                <a href="{{route('equipment_list')}}" class="nav-link">
		                  <i class="far fa-circle nav-icon"></i>
		                  <p>Equipment</p>
		                </a>
		              </li>
		              <li class="nav-item">
		                <a href="{{route('employee_list')}}" class="nav-link">
		                  <i class="far fa-circle nav-icon"></i>
		                  <p>Employees</p>
		                </a>
		              <li class="nav-item">
		                <a href="{{route('discount_type')}}" class="nav-link">
		                  <i class="far fa-circle nav-icon"></i>
		                  <p>Discount Type</p>
		                </a>
		              </li>
		            </ul>`;
      		$('#master_data').html(html);
        	console.log('checked');
      	}else{
      	
        	console.log("HAHA");
      	}
    })
</script>

@endsection
