<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title','Dashboard')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->

  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">

<link rel="stylesheet" href="{{asset('file.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  
  <!-- <link href="{{asset('assets/plugins/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css"/> -->

  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">

  <!-- Sweetalert -->
  <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    
  <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
  <style>
   
  </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">

<!-- preloader -->
<!-- <div class="preloader" id="preloaders" style="  position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('../../image/loader2.gif') 50%50% no-repeat rgb(249, 249, 249);
    opacity: 0.9;"></div> -->





<!-- end preloader -->
  @include('sweet::alert')

<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Youtube -->
    <!-- <div class="wrapper1">
      <span>i</span>
      <span>n</span>
      <span>v</span>
      <span>e</span>
      <span>n</span>
      <span>t</span>
      <span>o</span>
      <span>r</span>
      <span>y</span>
      <span>m</span>
      <span>a</span>
      <span>n</span>
      <span>a</span>
      <span>g</span>
      <span>e</span>
      <span>m</span>
      <span>e</span>
      <span>n</span>
      <span>t</span>
    </div> -->
    <h1 style="font-family:nunito" class="text-center font-weight-bold font-italic text-info ml-auto">Inventory Management</h1>
    <!-- end youtube test -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('image/logo.jpg')}}" alt="K-win Technology" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <p class="brand-text font-weight-light ">K-win Technology</p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        {{session()->get('formlist_manager_check')}}
        @if(session()->get('user')->hasRole('Project Manager'))
        <div class="info">
          <a href="#" class="d-block">{{ session()->get('user')->name }}</a>
        </div>
      </div>
      @elseif(session()->get('user')->hasRole('Warehouse Supervisor'))
      <div class="info">
          <a href="#" class="d-block">{{ session()->get('user')->name }}</a>
        </div>
      </div>
      @elseif(session()->get('user')->hasRole('Sales'))
      <div class="info">
          <a href="#" class="d-block">{{ session()->get('user')->name }}</a>
        </div>
      </div>
      @elseif(session()->get('user')->hasRole('Procurement Officer'))
      <div class="info">
          <a href="#" class="d-block">{{ session()->get('user')->name }}</a>
        </div>
      </div>
      @elseif(session()->get('user')->hasRole('Regional Warehouse'))
      <div class="info">
          <a href="#" class="d-block">{{ session()->get('user')->name }}</a>
        </div>
      </div>
      @elseif(session()->get('user')->hasRole('Site Supervisor'))
      <div class="info">
          <a href="#" class="d-block">{{ session()->get('user')->name }}</a>
        </div>
      </div>
      @elseif(session()->get('user')->hasRole('Sale Supervisor'))
      <div class="info">
          <a href="#" class="d-block">{{ session()->get('user')->name }}</a>
        </div>
      </div>
      @endif

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav sidebar-nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
          @if(session()->get('user')->hasRole('Project Manager') || session()->get('user')->hasRole('Super Admin'))
          <li class="nav-item">
            <a href="{{route('show_form_list')}}" class="nav-link">
              <i class="nav-icon fas fa-project-diagram"></i>
              <p>
                Form Lists
              </p>
            </a>
          </li>
          <!-- Monitor -->
         


          <!-- End Monitor -->
          <li class="nav-item">
            <a href="{{route('project_list')}}" class="nav-link">
              <i class="nav-icon fas fa-project-diagram"></i>
              <p>
                Project
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="{{route('defect-list')}}" class="nav-link">
              <i class="nav-icon fas fa-project-diagram"></i>
              <p>
                Defect
              </p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="{{route('employee_list')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Employee
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('material_request_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Site Material Request
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{route('site_delivery_order')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                 Approve Site Delivery Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('pm_site_inventory')}}" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Site Inventory
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('purchase_order')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Sale Purchase Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('warehouse_sale_orders')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Sale Order List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('warehouse_purchase_order')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Officer Purchase Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('CheckWarehouseTransfer')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                WarehouseTransfer Monitor
              </p>
            </a>
          </li>
          @foreach(session()->get('formlist_prepare') as $eachpre)
          
          @if($eachpre->prepare_by == 1 && $eachpre->id == 1)
         
          <li class="nav-item">
            <a href="{{route('good_receive_note_list')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Prepare Good Receive Note
              </p>
            </a>
          </li>
          @endif
          @endforeach
          @foreach(session()->get('formlist_approve') as $eachapprove)
          
          @if($eachapprove->approve_by == 1 && $eachapprove->id == 1)
         
          <li class="nav-item">
            <a href="{{route('good_receive_note_list')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Approve Good Receive Note
              </p>
            </a>
          </li>
          @endif
          @endforeach
          <!-- <li class="nav-item">
            <a href="{{route('reportTask')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Report Task
              </p>
            </a>
          </li> -->
         
          @elseif( session()->get('user')->hasRole('Warehouse Supervisor') )

          <li class="nav-item has-treeview" >
            <a href="#" class="nav-link" id="master_data">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('category_list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('subcategory_list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SubCategory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('brand_list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Brand</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('zone')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Zone</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('product_list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('handtool')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>HandTool</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('assign')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assign HandTool</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('return-handtool')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Return HandTool</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('RegionalWarehouse')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Regional Warehouse</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item" id="material_request">
            <a href="{{route('warehouse_material_request')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Material Request 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('warehouse_sale_orders')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Sale Order List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('material_issue_list_show')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Material Issue List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('waretransfer_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Warehouse Transfer Order
              </p>
            </a>
          </li>
          <!--<li class="nav-item">
            <a href="{{route('purchase_request_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Purchase Request List
              </p>
            </a>
          </li>-->
          <li class="nav-item">
            <a href="{{route('warehouse_purchase_request')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Purchase Request Lists
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('reject_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Reject List
              </p>
            </a>
          </li>
         
          @foreach(session()->get('formlist_prepare') as $eachpre)
          
          @if($eachpre->prepare_by == 3 && $eachpre->id == 1)
          
          <li class="nav-item">
            <a href="{{route('good_receive_note_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Prepare Good Receive Note
              </p>
            </a>
          </li>
          @endif
          @endforeach
          @foreach(session()->get('formlist_approve') as $eachapprove)
          @if($eachapprove->approve_by == 3 && $eachapprove->id == 1)
          <li class="nav-item">
            <a href="{{route('good_receive_note_list')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Approve Good Receive Note
              </p>
            </a>
          </li>
          @endif
          @endforeach
          <li class="nav-item">
            <a href="{{route('good_receive_note_list_normal')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                 Good Receive Note lists
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('site_delivery_order')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Site Delivery Order
              </p>
            </a>
          </li>
          @elseif(session()->get('user')->hasRole('Regional Warehouse')  )
          <li class="nav-item">
            <a href="{{route('regional_inventories')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inventory
              </p>
            </a>
          </li>
          <li class="nav-item">
            <!-- <a href="{{route('WarehouseTransferOrder')}}" class="nav-link"> -->
            <a href="{{route('waretransfer_list_reg')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Warehouse Transfer Orders
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('site_delivery_order')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Delivery Order Lists
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('good_receive_note_list')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Good Receive Note List
              </p>
            </a>
          </li>
        
          @elseif(session()->get('user')->hasRole('Sales') || session()->get('user')->hasRole('Super Admin'))

            <li class="nav-item">
            <a href="{{route('customer')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('sale_purchase_order_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Sale Purchase Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('document')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Document
              </p>
            </a>
          </li>
          @elseif(session()->get('user')->hasRole('Procurement Officer') || session()->get('user')->hasRole('Super Admin'))
          <li class="nav-item">
            <a href="{{route('procurement_purchase_request_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Purchase Request List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('procurement_purchase_order_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Purchase Order List
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{route('supplier_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Supplier List
              </p>
            </a>
          </li>
          
          
          @foreach(session()->get('formlist_prepare') as $eachpre)
          
          @if($eachpre->prepare_by == 4 && $eachpre->id == 1)
          
          <li class="nav-item">
            <a href="{{route('good_receive_note_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Prepare Good Receive Note
              </p>
            </a>
          </li>
          @endif
          @endforeach
          @foreach(session()->get('formlist_approve') as $eachapprove)
          
          @if($eachapprove->approve_by == 4 && $eachapprove->id == 1)
          <li class="nav-item">
            <a href="{{route('good_receive_note_list')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Approve Good Receive Note
              </p>
            </a>
          </li>
          @endif
          @endforeach
          <li class="nav-item">
            <a href="{{route('reject_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Reject List
              </p>
            </a>
          </li>
          @elseif(session()->get('user')->hasRole('Site Supervisor'))

          <li class="nav-item">
            <a href="{{route('report_list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Report
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('defect-list')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Defect
              </p>
            </a>
          </li>
          @elseif( session()->get('user')->hasRole('Sale Supervisor') )
          <li class="nav-item">
            <a href="{{route('customer')}}" class="nav-link">
            <i class="fas fa-user-circle fa-lg"></i>&nbsp;&nbsp;&nbsp;
              <p>
                Customer Register
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
            &nbsp;<i class="fas fa-file-contract fa-lg"></i>&nbsp;&nbsp;&nbsp;
              <p>
                Customer Quotation
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
            &nbsp;<i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;
              <p>
                Customer Purchase Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
            &nbsp; <i class="fas fa-file-invoice-dollar fa-lg"></i>&nbsp;&nbsp;&nbsp;
              <p>
                Customer Invoice
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{route('logoutprocess')}}" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">@yield('link')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @yield('content')

        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2017-2020 <a href="http://www.kwintechnologies.com">K-win Technology</a>.</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>

<script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('dist/js/pages/dashboard.js')}}"></script> -->
<!-- AdminLTE for demo purposes -->s
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- Bootstrap 4 -->
<!-- DataTable -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

@yield('js')
<script>

// $(window).on('load', function(){
//                 $("#preloaders").fadeOut(100);
//             });
//             $(document).ajaxStart(function(){
//                 $("#preloaders").show();
//             });
//             $(document).ajaxComplete(function(){
//                 $("#preloaders").hide();
//             });
$( document ).ready(function() {
    // window.location.reload();
});

</script>

</body>
</html>
