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
    <link rel="stylesheet" href="{{asset('adminlte/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/css/tempusdominus-bootstrap-4.min.css')}}">
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
                        @if(Auth::check() && (Auth::user()->isUser()))
                            <li class="nav-item">
                                <a href="{{route('users.index')}}" class="nav-link {{(Route::currentRouteName() == 'users.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Duty Details</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('users.reports')}}" class="nav-link {{(Route::currentRouteName() == 'users.reports') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>Reports</p>
                                </a>
                            </li>
                        @elseif(Auth::check() && Auth::user()->isAdmin())
                            <li class="nav-item {{(Route::currentRouteName() == 'admin.index') || (Route::currentRouteName() == 'admin.inquiries.edit') || (Route::currentRouteName() == 'admin.inquiries.all') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{(Route::currentRouteName() == 'admin.index') || (Route::currentRouteName() == 'admin.inquiries.edit') || (Route::currentRouteName() == 'admin.inquiries.all') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-question-circle"></i>
                                    <p>Inquiries<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.index')}}" class="nav-link {{(Route::currentRouteName() == 'admin.index') || (Route::currentRouteName() == 'admin.inquiries.edit') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Confirm Inquiries</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.inquiries.all')}}" class="nav-link {{(Route::currentRouteName() == 'admin.inquiries.all') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>All Inquiries</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.invoices')}}" class="nav-link {{(Route::currentRouteName() == 'admin.invoices') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-invoice"></i>
                                    <p>Invoices</p>
                                </a>
                            </li>
                            <li class="nav-item {{(Route::currentRouteName() == 'admin.cities') || (Route::currentRouteName() == 'admin.cities.add') || (Route::currentRouteName() == 'admin.cities.edit') || (Route::currentRouteName() == 'admin.types') || (Route::currentRouteName() == 'admin.types.add') || (Route::currentRouteName() == 'admin.types.edit') || (Route::currentRouteName() == 'admin.vehicles') || (Route::currentRouteName() == 'admin.vehicles.add') || (Route::currentRouteName() == 'admin.vehicles.edit') || (Route::currentRouteName() == 'admin.categories') || (Route::currentRouteName() == 'admin.categories.add') || (Route::currentRouteName() == 'admin.categories.edit') || (Route::currentRouteName() == 'admin.drivers') || (Route::currentRouteName() == 'admin.drivers.add') || (Route::currentRouteName() == 'admin.drivers.edit') || (Route::currentRouteName() == 'admin.companies') || (Route::currentRouteName() == 'admin.companies.add') || (Route::currentRouteName() == 'admin.companies.edit') || (Route::currentRouteName() == 'admin.users') || (Route::currentRouteName() == 'admin.users.add') || (Route::currentRouteName() == 'admin.users.edit') || (Route::currentRouteName() == 'admin.users.change') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{(Route::currentRouteName() == 'admin.cities') || (Route::currentRouteName() == 'admin.cities.add') || (Route::currentRouteName() == 'admin.cities.edit') || (Route::currentRouteName() == 'admin.types') || (Route::currentRouteName() == 'admin.types.add') || (Route::currentRouteName() == 'admin.types.edit') || (Route::currentRouteName() == 'admin.vehicles') || (Route::currentRouteName() == 'admin.vehicles.add') || (Route::currentRouteName() == 'admin.vehicles.edit') || (Route::currentRouteName() == 'admin.categories') || (Route::currentRouteName() == 'admin.categories.add') || (Route::currentRouteName() == 'admin.categories.edit') || (Route::currentRouteName() == 'admin.drivers') || (Route::currentRouteName() == 'admin.drivers.add') || (Route::currentRouteName() == 'admin.drivers.edit') || (Route::currentRouteName() == 'admin.companies') || (Route::currentRouteName() == 'admin.companies.add') || (Route::currentRouteName() == 'admin.companies.edit') || (Route::currentRouteName() == 'admin.users') || (Route::currentRouteName() == 'admin.users.add') || (Route::currentRouteName() == 'admin.users.edit') || (Route::currentRouteName() == 'admin.users.change') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>Masters<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.cities')}}" class="nav-link {{(Route::currentRouteName() == 'admin.cities') || (Route::currentRouteName() == 'admin.cities.add') || (Route::currentRouteName() == 'admin.cities.edit') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Cities</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.types')}}" class="nav-link {{(Route::currentRouteName() == 'admin.types') || (Route::currentRouteName() == 'admin.types.add') || (Route::currentRouteName() == 'admin.types.edit') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Vehicles Types</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.vehicles')}}" class="nav-link {{(Route::currentRouteName() == 'admin.vehicles') || (Route::currentRouteName() == 'admin.vehicles.add') || (Route::currentRouteName() == 'admin.vehicles.edit') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Vehicles Names</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.categories')}}" class="nav-link {{(Route::currentRouteName() == 'admin.categories') || (Route::currentRouteName() == 'admin.categories.add') || (Route::currentRouteName() == 'admin.categories.edit') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.drivers')}}" class="nav-link {{(Route::currentRouteName() == 'admin.drivers') || (Route::currentRouteName() == 'admin.drivers.add') || (Route::currentRouteName() == 'admin.drivers.edit') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Drivers/Vendors</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.companies')}}" class="nav-link {{(Route::currentRouteName() == 'admin.companies') || (Route::currentRouteName() == 'admin.companies.add') || (Route::currentRouteName() == 'admin.companies.edit') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Companies</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.users')}}" class="nav-link {{(Route::currentRouteName() == 'admin.users') || (Route::currentRouteName() == 'admin.users.add') || (Route::currentRouteName() == 'admin.users.edit') || (Route::currentRouteName() == 'admin.users.change') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Admins</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{(Route::currentRouteName() == 'admin.details') || (Route::currentRouteName() == 'admin.details.add') || (Route::currentRouteName() == 'admin.details.edit') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{(Route::currentRouteName() == 'admin.details') || (Route::currentRouteName() == 'admin.details.add') || (Route::currentRouteName() == 'admin.details.edit') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-car"></i>
                                    <p>Vehicles<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.details')}}" class="nav-link {{(Route::currentRouteName() == 'admin.details') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>All Vehicles</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.details.add')}}" class="nav-link {{(Route::currentRouteName() == 'admin.details.add') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Vehicle Details</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
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
    <script src="{{asset('adminlte/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('adminlte/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('adminlte/js/jszip.min.js')}}"></script>
    <script src="{{asset('adminlte/js/buttons.html5.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>
    <script src="{{asset('js/validation-additional.js')}}"></script>
    <script src="{{asset('adminlte/js/moment.min.js')}}"></script>
    <script src="{{asset('adminlte/js/daterangepicker.js')}}"></script>
    <script src="{{asset('adminlte/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('adminlte/js/tempusdominus-bootstrap-4.min.js')}}"></script>
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