<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Tell the browser to be responsive to screen width -->
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
   

    <style>
      
   .groundqty{
       display: block;
   }
    /* .preloader{
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('image/loader.gif') 50%50% no-repeat rgb(249, 249, 249);
        opacity: 0.9;
    } */

    </style>
    <link href="{{asset('assets/plugins/c3-master/c3.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('css/colors/blue.css')}}" id="theme" rel="stylesheet">

    <link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    
    <link rel="stylesheet" href="{{asset('js/dist/css/qrcode-reader.min.css')}}">

    <link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">

    <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet"> --}}
    <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">


    {{-- <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css"> --}}

    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
   

</head>

<body class="fix-header fix-sidebar card-no-border logo-center">

    <div class="preloader" id="preloaders" style="  position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('../../image/loader2.gif') 50%50% no-repeat rgb(249, 249, 249);
    opacity: 0.9;"></div>


    @include('sweet::alert')

    @php
    $admin= session()->get("user")->role;
    @endphp
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
              
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
    
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        
                            <h2 class="text-white font-weight-bold font-italic">
                            @if($admin == "Sale_Person")
                            @lang('lang.electric_sale')
                            @elseif($admin == "Warehouse")
                            @lang('lang.electric_warehouse')
                            @else    
                            @lang('lang.electric_manager')
                            @endif
                            </h2>
                            
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        @if(session()->get('user')->role == "Owner")
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('lang.warehousee')
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{route('warehouse_item_list',"3")}}">
                                                <div class="btn btn-danger btn-circle"><i class="fas fa-warehouse"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.wareone')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                   
                                                </div>
                                            </a>
                                            
                                            <a href="{{route('warehouse_item_list',"4")}}">

                                                <div class="btn btn-danger btn-circle"><i class="fas fa-warehouse"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.waretwo')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>
                                            <a href="{{route('warehouse_item_list',"5")}}">

                                                <div class="btn btn-danger btn-circle"><i class="fas fa-warehouse"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.warethree')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('lang.shops')
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{route('admin_sale_page',"1")}}">
                                                <div class="btn btn-primary btn-circle"><i class="fas fa-shopping-cart"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.shoppone')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                   
                                                </div>
                                            </a>
                                            
                                            <a href="{{route('admin_sale_page',"2")}}">
                                                <div class="btn btn-primary btn-circle"><i class="fas fa-shopping-cart"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.shopptwo')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('lang.admin')
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="{{route('admin_dashboard')}}">
                                                <div class="btn btn-warning btn-circle"><i class="fas fa-cogs"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.admin') @lang('lang.panel')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>
                                       
                                            <a href="{{route('employee_list')}}">
                                                <div class="btn btn-warning btn-circle"><i class="fas fa-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.employee') @lang('lang.list')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>


                                            <a href="{{route('list')}}">
                                                <div class="btn btn-warning btn-circle"><i class="fas fa-users"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.sale_customer_list')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>
                                            <a href="{{route('financial')}}">
                                                <div class="btn btn-warning btn-circle"><i class="fas fa-dollar-sign"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.financial')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>
                                            <a href="{{route('expenses')}}">
                                                <div class="btn btn-warning btn-circle"><i class="fas fa-hand-holding-usd"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>@lang('lang.expenses') @lang('lang.list')<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>
                                            <a href="{{route('quotations')}}">
                                                <div class="btn btn-warning btn-circle"><i class="fas fa-hand-holding-usd"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Quotation စာရင်း<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                               
                                                </div>
                                            </a>

                                       
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{-- <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('admin_dashboard')}}">@lang('lang.admin') @lang('lang.panel')</a></li>
                            <li><a href="{{route('financial')}}">@lang('lang.financial')</a></li>
                            <li><a href="{{route('employee_list')}}">@lang('lang.employee') @lang('lang.list')</a></li>
                            <li><a href="{{route('customer_list')}}">@lang('lang.customer') @lang('lang.list')</a></li>
                            <li><a href="{{route('purchase_list')}}">@lang('lang.purchase') @lang('lang.list')</a></li>
                            <li><a href="{{route('expenses')}}">@lang('lang.expenses') @lang('lang.list')</a></li>
                        </ul> --}}
                        @endif
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">@lang('lang.notifications')</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Stock Check<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Updated Item</small>
                                                </div>
                                            </a>
                                            
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Voucher<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Check Voucher</small>
                                                </div>
                                            </a>
                                            
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Reorder<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Check Reorder Item</small>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </u
                                l>
                            </div>
                        </li> --}}




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('image/user.jpg')}}" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{asset('image/user.jpg')}}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{session()->get('user')->name}}</h4>
                                                <p class="text-muted">{{session()->get('user')->email}}</p>
                                                <a href="#" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('change_password_ui')}}"><i class="mdi mdi-account-key"></i> Change Password </a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('logoutprocess')}}"><i class="mdi mdi-power"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                           

                            <a href="{{ url()->previous() }}" class="nav-link waves-effect waves-dark pt-2"><i class="fa fa-arrow-left"></i> Back</a>                            
                        </li>                        
                    </ul>

                    <div class="dropdown">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang == App::getLocale())
                                  {{$language}}
                            @endif
                      @endforeach
                      </a>
                
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                  <a class="dropdown-item english" href="{{url('localization/'.$lang)}}">{{$language}}</a>
                            @endif
                      @endforeach
                      </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        

        
         <aside class="left-sidebar">
        
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                       
                      

                        <li>

                            <a href="{{route('index')}}">
                                <i class="mdi mdi-home"></i>
                                <span>@lang('lang.home')</span>
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-store"></i>
                                <span class="hide-menu">
                                    @lang('lang.inventory')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="{{route('i_dashboard')}}">@lang('lang.inventory_dashboard')</a></li>
                                <li><a href="{{route('category_list')}}">@lang('lang.category') </a></li>
                                <li><a href="{{route('subcategory_list')}}">Subcategory</a></li>
                                <li><a href="{{route('brand_list')}}">Brand</a></li>
                                <li><a href="{{route('type_list')}}">Type</a></li>
                                <li><a href="{{route('item_list')}}">Item Lists</a></li>
                                   
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-cart"></i>
                                <span class="hide-menu">
                                    @lang('lang.stock')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="{{route('s_dashboard')}}">@lang('lang.stock_panel')</a></li>
                                <li><a href="{{route('stock_count')}}">@lang('lang.stock_count')</a></li>
                                <li><a href="{{route('stock_price_page')}}">@lang('lang.stock_price')</a></li>
                                <li><a href="{{route('stock_reorder_page')}}">@lang('lang.reorder_item')</a></li>
                                   
                            </ul>
                        </li>
                      
                        @if(session()->get('user')->role == "Warehouse"  || session()->get('ShopOrWh') =="warehouse")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-sale"></i>
                                
                                   @lang('lang.issue')
                                
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('issue_create')}}">@lang('lang.issue') @lang('lang.add')</a></li>
                                <li><a href="{{route('issue_list')}}">@lang('lang.issue') @lang('lang.list')</a></li>
                                <!-- <li><a href="{{route('purchase_list')}}">@lang('lang.purchase') @lang('lang.list')</a></li> -->

                                <!-- {{-- <li><a href="{{route('sale_panel')}}">@lang('lang.sales') @lang('lang.panel')</a></li>
                                <li><a href="{{route('sale_page')}}">@lang('lang.sale')</a></li>
                                @if(session()->get('user')->role == "Owner")
                                <li><a href="{{route('sale_history')}}">@lang('lang.sale_history')</a></li>

                                <li><a href="{{route('list')}}">@lang('lang.sale_customer_list')</a></li> --}} -->
                           
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow " href="{{route('purchase_history')}}" aria-expanded="false">
                                <i class="mdi mdi-sale"></i>
                                
                                   @lang('lang.purchase')
                                
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('purchase_create')}}">@lang('lang.to_purchase')</a></li>
                                <li><a href="{{route('purchase_history')}}">@lang('lang.purchase') @lang('lang.list')</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(session()->get('user')->role == "Sale_Person" || session()->get('ShopOrWh') == "shop")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-sale"></i>
                                <span class="hide-menu">
                                    @lang('lang.sales')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="{{route('sale_panel')}}">@lang('lang.sales') @lang('lang.panel')</a></li>
                                <li><a href="{{route('sale_page')}}">@lang('lang.sale')</a></li>
                               
                                <li><a href="{{route('sale_history')}}">@lang('lang.sale_history')</a></li>
                                <li><a href="{{route('quotations')}}">Quotation</a></li>
                            </ul>
                        </li>
                        @endif

                        {{-- admin --}}
                        {{-- @if(session()->get('user')->role == "Sale_Person")
                         <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-clipboard-text"></i>
                                <span class="hide-menu">
                                    @lang('lang.order_list')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('order_panel')}}">@lang('lang.order_panel')</a></li>                                
                                <li><a href="{{route('order_page','1')}}">@lang('lang.incoming_order')</a></li>
                                <li><a href="{{route('order_page','2')}}">@lang('lang.confirm_order')</a></li>
                                <li><a href="{{route('order_page','3')}}">@lang('lang.changes_order')</a></li>
                                <li><a href="{{route('order_page','4')}}">@lang('lang.delivered_order')</a></li>
                                <li><a href="{{route('order_page','5')}}">@lang('lang.accepted_order')</a></li>
                                <li><a href="{{route('order_history')}}">@lang('lang.order_voucher_history')</a></li>                                    
                            </ul>
                        </li> 
 @endif
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-account-multiple-outline"></i>
                                <span class="hide-menu">
                                    @lang('lang.admin')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('admin_dashboard')}}">@lang('lang.admin') @lang('lang.panel')</a></li>
                                <li><a href="{{route('financial')}}">@lang('lang.financial')</a></li>
                                <li><a href="{{route('employee_list')}}">@lang('lang.employee') @lang('lang.list')</a></li>
                                <li><a href="{{route('customer_list')}}">@lang('lang.customer') @lang('lang.list')</a></li>
                                <li><a href="{{route('purchase_list')}}">@lang('lang.purchase') @lang('lang.list')</a></li>
                                <li><a href="{{route('expenses')}}">@lang('lang.expenses') @lang('lang.list')</a></li>
                            </ul>
                        </li>
                        --}}
                        <li>
                            <a href="{{route('logoutprocess')}}"><i class="mdi mdi-power"></i> <span>@lang('lang.logout')</span></a>
                        </li>
                      @php
                      $shopname= session()->get('from');
                      switch ($shopname) {
                        case '1':
                            $shop_name="Shop(one)";
                            break;
                        case '2':
                        $shop_name="Shop(Two)";
                        break;
                        case '3':
                            $shop_name="Warehouse(one)";
                            break;
                        case '4':
                        $shop_name="Warehouse(two)";
                        break;
                        default:
                        $shop_name="Fifth Floor(Warehouse)";
                            break;
                    }
                      @endphp
                       <li>
                        <span class="text-primary" style="margin-left: 200px;font-weight:600">{{$shop_name}}</span>
                    </li>
                    
                    </ul>
                    
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        
        </aside>
        
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <div class="row page-titles">
                    
                    @yield('place')

                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Today Sale</small></h6>
                                    <h4 class="m-t-0 text-info">{{number_format(session()->get('today_sale')) }} MMK</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Yesterday Sale</small></h6>
                                    <h4 class="m-t-0 text-primary">{{number_format(session()->get('last_day_sale')) }} MMK</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('content')

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2018 Material Pro Admin by wrappixel.com </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/custom.min.js')}}"></script>
    <!-- jquery -->
    {{-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}

    <!--c3 JavaScript -->
    <script src="{{asset('assets/plugins/d3/d3.min.js')}}"></script>
    
    <script src="{{asset('assets/plugins/c3-master/c3.min.js')}}"></script>

    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    
    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>
    
    <script src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}" type="text/javascript"></script>
    
    <script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    
    <script src="{{asset('js/validation.js')}}"></script>
    
    <script src="{{ asset('js/dist/js/qrcode-reader.min.js')}}"></script>

    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

    <script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script>
         $(window).on('load', function(){
                $("#preloaders").fadeOut(100);
            });
            $(document).ajaxStart(function(){
                $("#preloaders").show();
            });
            $(document).ajaxComplete(function(){
                $("#preloaders").hide();
            });
       function oldPrice(){
            var unit_id = $('#unit option:selected').val();
                
                $.ajax({

                    type: 'POST',

                    url: '/oldprice',

                    data: {
                        "_token": "{{ csrf_token() }}",
                        'unit_id': unit_id,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#itemcurrent_purchase_price').val(data[0]);
                        $('#itemcurrent_selling_price').val(data[1]);
                        $('#itemcurrent_selling_price1').val(data[2]);
                        $('#itemcurrent_selling_price2').val(data[3]);
                        $('#counting_unit_ID').val(data[4]);

                    }
        });
        }

function showSubCategory(value) {

var category_id = value;

$('#sub_category').empty();

$.ajax({
    type: 'POST',
    url: '/showSubCategory',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "category_id": category_id,
    },

    success: function(data) {

        console.log(data);
        $('#subcategory').append($('<option>').text("Select"));
        $.each(data, function(i, value) {

            $('#sub_category').append($('<option>').text(value.name).attr('value', value.id));
        });

    }

});

}


function showBrand(value) {

var subcategory_id = value;

$('#brands').empty();

$.ajax({
    type: 'POST',
    url: '/showBrand',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "subcategory_id": subcategory_id,
    },

    success: function(data) {

        console.log(data);
        $('#brands').append($('<option>').text("Select"));
        
        $.each(data, function(i, value) {

            $('#brands').append($('<option>').text(value.name).attr('value', value.id));
        });

    }

});

}


function showType(value) {
var subcategory_id= $('#sub_category').val();
var brand_id = value;

$('#type').empty();

$.ajax({
    type: 'POST',
    url: '/showType',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "subcategory_id": subcategory_id,
        "brand_id": brand_id,
    },

    success: function(data) {

        console.log(data);

        $('#type').append($('<option>').text("Select"));

        $.each(data, function(i, value) {

            $('#type').append($('<option>').text(value.name).attr('value', value.id));
        });

    }

});

}

function showItems(value){

var sub_category= $( "#sub_category option:selected" ).val();
var brands= $( "#brands option:selected" ).val();
var type= value;

$.ajax({

    type:'POST',

    url:'{{route('AjaxGetItem')}}',

    data:{
        "_token":"{{csrf_token()}}",
        "sub_category_id":sub_category,
        "brand_id" : brands,
        "type_id" : type,
    },

    success:function(data){

        $('#item_list').empty();             

        $('#item_list').append($('<option>').text("Select Item").attr('value', ""));
                 
        $.each(data, function(i, value) {

        $('#item_list').append($('<option>').text(value.item_name).attr('value', value.id));
     
        });         

    },
});

}
    function form_clear(){
        $('#category').empty();
        $('#subcategory').empty();
        $('#also_brand').empty();
        $('#also_type').empty();
        $('#also_item').empty();
        $('#unit').empty();

    }

$("#from_id").change(function(){
    form_clear();
        var from_id = $('#from_id').children("option:selected").val();
       $.ajax({
           type:'POST',
           url:'{{route('category_of_from')}}',
           data:{
               "_token":"{{csrf_token()}}",
               "from_id": from_id,
           },
           success:function(data){
         
            $('#category').empty();
            $('#category').append($('<option>').text('Select Category'));

            $.each(data,function(i,value){
                $('#category').append($('<option>').text(value.category_name).attr('value', value.id));
             
            })
            
           }
       });
       
    });
    $( "#search_item" ).keyup(function() {
       var search_item= $('#search_item').val();
       var from_id = $('#from_id').children("option:selected").val();
        console.log(search_item);
        if($.trim(search_item) !=''){
            $.ajax({
           type:'POST',
           url:'{{route('get_issue_item')}}',
           data:{
               "_token":"{{csrf_token()}}",
               "search_word": search_item,
               "from_id": from_id,
           },
           success:function(data){
               $('#resultitem').empty();
                console.log(data[0].length);
            var html=``;
            if(data[0].length==0){
                html+=`
                <div class="bg-light shadow mt-2" style="height: 30px;font-weight: bold;">
                    <p style="padding-left: 20px" class="text-danger">No Found!</p>
                </div>
                `;
            }
            else {
                $.each(data[0],function(i,v){
            $.each(v,function(j,value){
                $.each(data[1],function(z,val){
                   
                    if(val.id==value.item.id){

                $.each(data[2],function(k,valu){
                $.each(valu,function(j,l){
                    console.log(value.id);

                    console.log(l.counting_unit_id);
                    if(l.counting_unit_id== value.id){
                         window.stock= l.stock_qty;
                        console.log(stock);
                    }
                    
                })
                })

                   var categoryId= val.category.id;
                   var categoryName= val.category.category_name;
                   var subcategoryId= val.sub_category.id;
                   var subcategoryName= val.sub_category.name;
                   var brandId= val.brand.id;
                   var brandName= val.brand.name;
                   var typeId= val.type.id;
                   var typeName= val.type.name;

                    
                   html +=`
                <div class="bg-light shadow searchadd" style="height: 30px;font-weight: bold;cursor:pointer" data-itemname="${value.item.item_name}" data-unitname="${value.unit_name}" data-itemid="${value.item.id}" data-unitid="${value.id}" data-categoryid="${categoryId}" data-categoryname="${categoryName}" data-subcategoryid="${subcategoryId}" data-subcategoryname="${subcategoryName}" data-brandid="${brandId}" data-brandname="${brandName}" data-typeid="${typeId}" data-typename="${typeName}" data-stock="${stock}">
                    <p style="padding-left: 20px">${value.item.item_name} (${typeName}) (${brandName}) <span class="text-primary">${value.unit_name} (${stock}) </span> </p>
                </div>`;
                }
                });
              
              
            });
            
            });

            }
           
            $('#resultitem').append(html);
                      
           }
       });
        }
        else{
            $('#resultitem').empty();

        }
        
});


function showRelatedSubCategoryFrom(value) {

console.log(value);

$('#subcategory').prop("disabled", false);

var category_id = value;
var from_id = $('#from_id option:selected').val();

$('#subcategory').empty();

$.ajax({
    type: 'POST',
    url: '/showSubCategoryFrom',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "category_id": category_id,
        "from_id":from_id,
    },

    success: function(data) {

        console.log(data);
        $('#subcategory').append($('<option>').text('Select Subcategory'));
        $.each(data, function(i, value) {

            $('#subcategory').append($('<option>').text(value.name).attr('value', value.id));
        });
    }
});
}

function showRelatedBrandFrom(value) {
var subcategory_id = value;
$('#also_brand').empty();
var from_id = $('#from_id option:selected').val();
$.ajax({
    type: 'POST',
    url: '/showBrandFrom',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "subcategory_id": subcategory_id,
        "from_id":from_id,
    },

    success: function(data) {

        console.log(data);
        $('#also_brand').append($('<option>').text('Select Brand'));
        
        $.each(data, function(i, value) {

            $('#also_brand').append($('<option>').text(value.name).attr('value', value.id));
        });
    }
});
}

function showRelatedTypeFrom(value) {
var subcategory_id= $('#subcategory').val();
var brand_id = value;
var from_id = $('#from_id option:selected').val();


$('#also_type').empty();

$.ajax({
    type: 'POST',
    url: '/showTypeFrom',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "subcategory_id": subcategory_id,
        "brand_id": brand_id,
        "from_id":from_id,
    },

    success: function(data) {

        console.log(data);

        if(data.length==0){
            $('#also_type').append($('<option>').text("No Found"));
        }else{
            $('#also_type').append($('<option>').text("Select Type"));
            $.each(data, function(i, value) {
            $('#also_type').append($('<option>').text(value.name).attr('value', value.id));
        });
        }
    }

});

}

function showRelatedItemFrom(value){
    
    var brand_id = $('#also_brand').val();
    var type_id = value;
var from_id = $('#from_id option:selected').val();
    $('#also_item').empty();
$.ajax({
    type: 'POST',
    url: '/showItemFrom',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "type_id": type_id,
        "brand_id": brand_id,
        "from_id":from_id,
        
    },
    success: function(data) {

$('#also_item').append($('<option>').text('Select Item'));

$.each(data, function(i, value) {
    $('#also_item').append($('<option>').text(value.item_name).attr('value', value.id));
});

}

});

}

function showRelatedSubCategoryFr(value) {

console.log(value);

$('#sub_category').prop("disabled", false);

var category_id = value;
var from_id = $('#from_id').val();

$('#sub_category').empty();

$.ajax({
    type: 'POST',
    url: '/showSubCategoryFrom',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "category_id": category_id,
        "from_id":from_id,
    },

    success: function(data) {

        console.log(data);
        $('#sub_category').append($('<option>').text('Select subcategory'));
        $.each(data, function(i, value) {

            $('#sub_category').append($('<option>').text(value.name).attr('value', value.id));
        });
    }
});
}


function showRelatedBrandFr(value) {
var subcategory_id = value;
$('#brands').empty();
var from_id = $('#from_id').val();
$.ajax({
    type: 'POST',
    url: '/showBrandFrom',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "subcategory_id": subcategory_id,
        "from_id":from_id,
    },

    success: function(data) {

        console.log(data);
        $('#brands').append($('<option>').text('Select Brand'));
        
        $.each(data, function(i, value) {

            $('#brands').append($('<option>').text(value.name).attr('value', value.id));
        });
    }
});
}

function showRelatedTypeFr(value) {
var subcategory_id= $('#sub_category').val();
var brand_id = value;
var from_id = $('#from_id').val();


$('#type').empty();

$.ajax({
    type: 'POST',
    url: '/showTypeFrom',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        "subcategory_id": subcategory_id,
        "brand_id": brand_id,
        "from_id":from_id,
    },

    success: function(data) {

        console.log(data);

        if(data.length==0){
            $('#type').append($('<option>').text("No Found"));
        }else{
            $('#type').append($('<option>').text("Select Type"));
            $.each(data, function(i, value) {
            $('#type').append($('<option>').text(value.name).attr('value', value.id));
        });
        }
    }

});

}

function showRelatedUnit(value){
    var item_id = value;
    $('#unit').empty();
    $.ajax({
    type: 'POST',
    url: '/showUnit',
    dataType: 'json',
    data: {
        "_token": "{{ csrf_token() }}",
        
        "item_id": item_id,
        
    },
    success: function(data) {

console.log(data);
$('#unit').append($('<option>').text('Select Units'));

$.each(data, function(i, value) {
console.log(value.name);

    $('#unit').append($('<option>').text(value.unit_name).attr('value', value.id));
});

}

});
}

$('#resultitem').on('click','.searchadd',function(){
    form_clear();
    $('#item').empty();
    $('#unit').empty();
    var itemname= $(this).data("itemname");
    var unitname= $(this).data("unitname");
    var itemid= $(this).data("itemid");
    var unitid= $(this).data("unitid");
    var categoryid= $(this).data("categoryid");
    var categoryName= $(this).data("categoryname");
    var subcategoryId= $(this).data("subcategoryid");
    var subcategoryName= $(this).data("subcategoryname");
    var brandId= $(this).data("brandid");
    var brandName= $(this).data("brandname");
    var typeId= $(this).data("typeid");
    var typeName= $(this).data("typename");
    var stock= $(this).data("stock");
    $('#current_qty').val(stock);
    $('#category').append($('<option>').text(categoryName).attr('value', categoryid));
    $('#subcategory').append($('<option>').text(subcategoryName).attr('value', subcategoryId));
    $('#also_brand').append($('<option>').text(brandName).attr('value', brandId));
    $('#also_type').append($('<option>').text(typeName).attr('value', typeId));
    
    $('#also_item').append($('<option>').text(itemname).attr('value', itemid));
        $( "#item" ).prop( "disabled", false );
        $( "#unit" ).prop( "disabled", false );

    $('#unit').append($('<option>').text(unitname).attr('value', unitid));
        oldPrice();
        $('#resultitem').empty();
        $('#search_item').empty();
        $('#qty').focus();
    console.log(itemid,itemname,unitname,unitid);
})

$('.advenced_search_btn').click(function(){
    $('.advenced_search').toggle();
})

    </script>





    @yield('js')

    
    
</body>

</html>
