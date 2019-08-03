<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ env('APP_NAME', 'Vilacore') }} Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
          <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a></li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="far fa-user"></i>
                <span style="margin-left: 5px;">{{ Auth()->user()->name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fas fa-sign-out-alt mr-2"></i>
                  Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
            </li>
        </ul>
    </nav>


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">       
            <span class="brand-image" style="font-size: 40px; font-weight: bold;margin-left: 18px;">V</span>
            {{-- <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
            <span class="brand-text font-weight-light">VILACORE ADMIN</span>
        </a>
    
        @include('admin._sidebar')
    </aside>

    <div class="content-wrapper">
      @yield('content.header')

      <div class="content">
        <div class="container-fluid">@yield('content')</div>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2019 <a href="viandwi24.github.io/vilacore">Vilacore</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0-beta.1
    </div>
  </footer>


    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>$.widget.bridge('uibutton', $.ui.button)</script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/admin/plugins/fastclick/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/adminlte.js') }}"></script>
    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    @stack('js')
</body>
</html>
