<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CAS | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset('adminlte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
  <!-- Ionicons -->
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet"/>
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <!-- Theme style -->
	<link href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}" rel="stylesheet"/>
  <!-- AdminLTE skins -->
  <link href="{{ asset('adminlte/dist/css/skins/skin-blue.min.css') }}" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">

  <!--jQuery-->
  <script type="text/javascript" src="{{ asset('adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
  <!-- google map -->
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBcDAzO0BjrJDZuG4q5edgMBZI5sdjvqTg"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>AS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CAS</b> Management</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('dist/img/user_img.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::admin()->get()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('dist/img/user_img.png') }}" class="img-circle" alt="User Image">
                <p>{{Auth::admin()->get()->name}}</p>
              </li>
              <!-- Menu Footer -->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="logout" class="btn btn-default btn-flat">Log out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{ Request::is('users') ? 'active' : '' }}" id="users">
          <a href="{{ URL::to('users') }}">
            <i class="fa fa-users"></i><span>Users</span>
          </a>
        </li>
        <li class="{{ Request::is('prevention') ? 'active' : '' }}" id="prevention">
          <a href="{{ URL::to('prevention') }}">
            <i class="fa fa-files-o"></i><span>Crime Prevention Tips</span>
          </a>
        </li>
        <li class="{{ Request::is('reports') ? 'active' : '' }}" id="reports">
          <a href="{{ URL::to('reports') }}">
            <i class="fa fa-flag"></i><span>Crime Reports</span>
          </a>
        </li>
        <li class="{{ Request::is('witness') ? 'active' : '' }}" id="witness">
          <a href="{{ URL::to('witness') }}">
            <i class="fa fa-eye"></i><span>Witnessed Reports</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>Dashboard</h1>
    </section> -->

    <!-- Main content -->
    <section class="content">

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->


</body>
  <script src="{{ asset('dist/js/cas.js') }}"></script>
  <script src="{{ asset('adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('adminlte/dist/js/app.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <!-- bootstrap datepicker -->
  <script src="{{ asset('adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

<script>
  $(function () {
    $("#listingTable").DataTable();
  });

  $(function () {
    setNavigation();
  });

  $(function () {
      //bootstrap WYSIHTML5 - text editor
      $(".textarea").wysihtml5();
  });

  function setNavigation() {

    var path = window.location.pathname;
    var section = '<?php echo $section; ?>';
    
    if(section == 'users')
      document.getElementById("users").className = "active";
    else if(section == 'prevention')
      document.getElementById("prevention").className = "active";
    else if(section == 'reports')
      document.getElementById("reports").className = "active";
    else if(section == 'witness')
      document.getElementById("witness").className = "active";
  }
</script>
</html>