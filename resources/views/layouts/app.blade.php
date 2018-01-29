<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Meta Author-->
    <meta name="author" content="Muhammad Mahin Dar">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App Title -->
    <title>@yield('title') | CPMS </title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CPMS') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset('css/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Ionicons -->
    <link href="{{ asset('css/bower_components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <!--Toast -->
    <link href="{{ asset('css/bower_components/toast/jquery.toast.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset('css/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link href="{{ asset('css/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('cssarea')
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>C</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Petro</b>Chemical</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="/css/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{count(Auth::user()->unreadnotifications)}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{count(Auth::user()->unreadnotifications)}} notifications</li>
               @foreach(Auth::user()->unreadnotifications as $noti)
              @if($noti->type=='App\Notifications\PendingProduction')
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="{{URL('Pending/Productions')}}" onclick="">
                      <i class="fa fa-users text-aqua"></i> 
                      Pending Production Request
                    </a>
                  </li>
                </ul>
              </li>
              @elseif($noti->type=='App\Notifications\ProductionApproved')
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a @if($noti->data['status']==4) href="{{URL('Production')}}/{{$noti->data['id']}}" @elseif($noti->data['status']==3) href="{{URL('Approved/Productions')}}" @endif onclick="">
                      <i class="fa fa-users text-aqua"></i> 
                      The Production has been @if($noti->data['status']==4) Completed @elseif($noti->data['status']==3)Approved @elseif($noti->data['status']==0)Disapproved @endif
                    </a>
                  </li>
                </ul>
              </li>
              
               @endif
              @endforeach
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <li>
              <a href="javascript:void(0);" class=" right-menu-item" onclick="go_full_screen()">
                <i class="fa fa-arrows-alt" aria-hidden="true"></i>
              </a>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          @if(Auth::check())
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset( Auth::user()->avatar)}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset( Auth::user()->avatar)}}" class="img-circle" alt="User Image">

                <p>
                  
                  {{Auth::user()->name}}
                  <small>Member since {{Auth::user()->created_at->format('d-m-Y')}}</small>
                  
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('Profile.show',Auth::user()->id)}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}"onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"class="btn btn-default btn-flat">Sign out</a>
                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
          @endif
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
          @can('Read-GatePass')
                <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Gate Pass</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL('GatePass')}}"><i class="fa fa-circle-o"></i>Gate Passes</a></li>           
          </ul>
        </li>
        @endcan
        <li class="header">User Management Area</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-building"></i> <span>Company Mangement</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('Read-Company')
            <li><a href="{{URL('Company')}}"><i class="fa fa-circle-o"></i>Companies</a></li>
            @endcan
            @can('Read-Branch')
            <li><a href="{{URL('Branch')}}"><i class="fa fa-circle-o"></i>Branches</a></li>
            @endcan
            @can('Read-Department')
            <li><a href="{{URL('Department')}}"><i class="fa fa-circle-o"></i>Departments</a></li>            
          @endcan
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('Read-User')
            <li><a href="{{URL('Users')}}"><i class="fa fa-user-plus"></i>Users</a></li>
            @endcan
            @can('Read-Role')
            <li><a href="{{URL('Role')}}"><i class="fa fa-circle-o"></i>Role</a></li>
            @endcan        
          </ul>
        </li>


        <li class="header">Production Area</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-industry"></i> <span>Production</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o"></i> <span>Type of Costs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('Read-SemiFixed')
            <li><a href="{{URL('SemiFixed')}}"><i class="fa fa-circle-o"></i>SemiFixed</a></li>
            @endcan
            @can('Read-FactoryOverhead')
            <li><a href="{{URL('FactoryOverhead')}}"><i class="fa fa-circle-o "></i>Factory Overhead</a></li>
            @endcan
          </ul>
        </li> 
        @can('Read-Material')  
            <li><a href="{{URL('Material')}}"><i class="fa fa-circle-o"></i>Materials</a></li>
            @endcan
            @can('Read-Product')
            <li><a href="{{URL('Product')}}"><i class="fa fa-circle-o"></i>Product</a></li>
            @endcan
            @can('Update-DailyProduction')
            <li><a href="{{URL('DailyProduction')}}"><i class="fa fa-circle-o"></i>Daily Production</a></li>
            @endcan
            @can('Read-Production')
            <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o"></i> <span>Production</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('Read-Production')
            <li><a href="{{URL('Production')}}"><i class="fa fa-circle-o"></i>All Production</a></li>
            @endcan
            @can('Approve-Production')
            <li><a href="{{URL('/Pending/Productions')}}"><i class="fa fa-circle-o "></i>Pending Production</a></li>
            @endcan
            @can('Complete-Production')
             <li><a href="{{URL('/Approved/Productions')}}"><i class="fa fa-circle-o"></i>Approved Production</a></li>
             @endcan
             <li><a href="{{URL('/Completed/Productions')}}"><i class="fa fa-circle-o"></i>Completed Production</a></li>
          </ul>
        </li>
        @endcan          
          </ul>
        </li>
        <li class="header">Reports</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-building"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('Daily-ProductionReport')
            <li><a href="{{URL('Reports')}}"><i class="fa fa-circle-o"></i>Daily Product Production</a></li>
            @endcan
            @can('Monthly-ProductionReport')
            <li><a href="{{URL('Reports/MonthlyReport')}}"><i class="fa fa-circle-o"></i>Monthly Product Production</a></li>
            @endcan
          </ul>
        </li>        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
      <h1>
        @yield('BigHeading')
        <small>@yield('SmallHeading')</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
       @yield('FullPage')
      <!-- Default box -->
      <div class="box ">
        <div class="box-header with-border no-print">
          <h3 class="box-title">@yield('pagetitle')</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          @yield('dynamiccontent')
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-print">
          @yield('footer')
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer no-print">

    <strong>Copyright &copy; 2018-2019 <a>Petrochemical international</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
 <script src="{{ asset('css/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('css/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('css/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('css/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!--Toast -->
<script src="{{ asset('js/toast/jquery.toast.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('css/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('css/dist/js/demo.js') }}"></script>


<script type="text/javascript">
  function go_full_screen(){
  var elem = document.documentElement;
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.msRequestFullscreen) {
    elem.msRequestFullscreen();
  } else if (elem.mozRequestFullScreen) {
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) {
    elem.webkitRequestFullscreen();
  }
}
</script>
  @if(Session::has('notice'))
            <script type="text/javascript">
                $(document).ready(function () {
                    $.toast({
                        heading: 'Success'
                        , text: '{{ Session::get("notice") }}'
                        , position: 'top-right'
                        , loaderBg: '#ff6849'
                        , icon: 'success'
                        , hideAfter: 9500
                        , stack: 6
                    })
                });
            </script>

        @endif

        @if(Session::has('alert'))
            <script type="text/javascript">
                $(document).ready(function () {
                    $.toast({
                        heading: 'Error'
                        , text: '{{ Session::get("alert") }}'
                        , position: 'top-right'
                        , loaderBg: '#ff6849'
                        , icon: 'danger'
                        , hideAfter: 9500
                        , stack: 6
                    })
                });
            </script>

        @endif
@yield('scriptarea')
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
