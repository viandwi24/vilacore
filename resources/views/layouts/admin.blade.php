<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
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
  <!-- Alert -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/toastr/toastr.min.css') }}">
  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed layout-navbar-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item"><a onclick="togglepushmenu()" class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
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
    <strong>&copy; 2019 <a href="viandwi24.github.io/vilacore">Vilacore</a></strong> by<strong>
      <a style="color: grey;" target="_blank" href="https://fb.com/viandwi24">viandwi24</a>
    </strong>
    <div class="float-right d-sm-inline-block">
      <b>Version</b> {{ env('VILACORE_VERSION', "0.0.0") }}-{{ env('VILACORE_VERSION_DESCRIPTION', 'stable') }}
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
    <!-- Alert -->
    <script src="{{ asset('assets/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/adminlte.js') }}"></script>
    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
      var Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000 });
      $(window).ready(function(){
        checklaststatepushmenu();
      });
      
      function togglepushmenu() {
        $state = !$('body').hasClass('sidebar-collapse');
        if ($state == true) {
          localStorage.setItem("pushmenu", false);
        } else {
          localStorage.setItem("pushmenu", true);
        }
      }
      function checklaststatepushmenu() {
        $state = localStorage.getItem("pushmenu");
        if ($state == null) {
          localStorage.setItem("pushmenu", false);
        }

        if ($state == "false") {
          $('body').addClass('sidebar-collapse');
        }
      }
    </script>
    @stack('js')
    

    @if (Session::has('alert'))
        <?php $alert = Session::get('alert'); ?>
        <script>
          Toast.fire({
              type: '{{ $alert["type"] }}',
              title: '{{ $alert["text"] }}'
          });
        </script>
    @endif

    @if ($errors->any())
      <script>
        @foreach ($errors->all() as $error)
          console.log('{{ $error }}');
          toastr.error('{{ $error }}')
        @endforeach
      </script>
  @endif
    
</body>
</html>
