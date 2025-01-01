<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jeevan Rath</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('adminlte/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/daterangepicker.css')}}">
	@yield('header')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="loader">
        <div class="loader-inner">
            <img src="{{asset('img/loading.gif')}}" alt="" style="width: 100%;">
        </div>
    </div>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto align-items-center">
                @if(Auth::check())
                    <li class="nav-item mr-3">
                        Welcome {{Auth::user()->name}},
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{route('logout')}}">
                            Logout
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{route('index')}}" class="brand-link">
              <img src="{{asset('img/small_logo.jpeg')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
              <span class="brand-text font-weight-light">Jeevan Rath</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{route('admin.index')}}" class="nav-link {{(Route::currentRouteName() == 'admin.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{(Route::currentRouteName() == 'admin.cities') || (Route::currentRouteName() == 'admin.cities.add') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{(Route::currentRouteName() == 'admin.cities') || (Route::currentRouteName() == 'admin.cities.add') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-city"></i>
                                <p>Cities<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.cities')}}" class="nav-link {{(Route::currentRouteName() == 'admin.cities') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Cities</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.cities.add')}}" class="nav-link {{(Route::currentRouteName() == 'admin.cities.add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New City</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{(Route::currentRouteName() == 'admin.cars') || (Route::currentRouteName() == 'admin.cars.add') || (Route::currentRouteName() == 'admin.cars.edit') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{(Route::currentRouteName() == 'admin.cars') || (Route::currentRouteName() == 'admin.cars.add') || (Route::currentRouteName() == 'admin.cars.edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-car"></i>
                                <p>Rental Cars/Cabs<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.cars')}}" class="nav-link {{(Route::currentRouteName() == 'admin.cars') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Cars</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.cars.add')}}" class="nav-link {{(Route::currentRouteName() == 'admin.cars.add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New Car</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            @yield('content')
        </div>
        <footer class="main-footer">
            Copyright &copy; 2024 Jeevan Rath. All rights reserved.
        </footer>
    </div>
    <script src="{{asset('adminlte/js/jquery.min.js')}}"></script>
    <script src="{{asset('adminlte/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('adminlte/js/bs-custom-file-input.min.js')}}"></script>
    <script src="{{asset('adminlte/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminlte/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('adminlte/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('adminlte/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>
    <script src="{{asset('adminlte/js/moment.min.js')}}"></script>
    <script src="{{asset('adminlte/js/daterangepicker.js')}}"></script>
    <script src="{{asset('adminlte/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('adminlte/js/adminlte.js')}}"></script>
     <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    @yield('footer')
</body>
</html>