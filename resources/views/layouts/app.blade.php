<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jeevan Rath</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('lib/animate/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
	@yield('header')
</head>
<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0 align-items-center" style="height: 45px;">
            <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                <div class="d-flex flex-wrap">
                    <a href="https://maps.app.goo.gl/qNmbX2z3KVQr4z2V6" class="text-light me-4" target="_blank"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                    <a href="tel:+919726400024" class="text-light me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+919726400024</a>
                    <a href="mailto:bookings.jeevanrath@gmail.com" class="text-light me-0"><i class="fas fa-envelope text-primary me-2"></i>bookings.jeevanrath@gmail.com</a>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="https://www.facebook.com/p/Jeevanrath-Rental-Cars-Surat-100066783011785/" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
            <a href="{{route('index')}}" class="navbar-brand p-0">
                <!--<h1 class="text-primary m-0"><i class="fas fa-car me-3"></i>JeevanRath</h1>-->
                <img src="img/logo.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="{{route('index')}}" class="nav-item nav-link {{ Route::currentRouteName() == 'index' ? 'active' : '' }}">Home</a>
                    <a href="{{route('about')}}" class="nav-item nav-link {{ Route::currentRouteName() == 'about' ? 'active' : '' }}">About</a>
                    <a href="{{route('contact')}}" class="nav-item nav-link {{ Route::currentRouteName() == 'contact' ? 'active' : '' }}">Contact Us</a>
                </div>
                <a href="{{route('index')}}/#appointment" class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">Book Now</a>
            </div>
        </nav>
        @yield('slider')
    </div>
    @yield('content')
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4"><i class="fas fa-star-of-life me-3"></i>Jeevan Rath</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus dolorem impedit eos autem dolores laudantium quia, qui similique
                        </p>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-share fa-2x text-white me-2"></i>
                            <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="https://www.facebook.com/p/Jeevanrath-Rental-Cars-Surat-100066783011785/"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Contact Info</h4>
                        <a href="https://maps.app.goo.gl/qNmbX2z3KVQr4z2V6"><i class="fa fa-map-marker-alt me-2"></i> A-106-Truimph Plaza, Near Palanpur Fire Station Canal Road, Gaurav Path Road, Pal Gam, Surat, Gujarat 395009</a>
                        <a href="mailto:bookings.jeevanrath@gmail.com"><i class="fas fa-envelope me-2"></i> bookings.jeevanrath@gmail.com</a>
                        <a href="tel:+919726400024" class="mb-3"><i class="fas fa-phone me-2"></i> +919726400024</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Quick Links</h4>
                        <a href="{{route('index')}}"><i class="fas fa-angle-right me-2"></i> Home</a>
                        <a href="{{route('about')}}"><i class="fas fa-angle-right me-2"></i> About Us</a>
                        <a href="{{route('contact')}}"><i class="fas fa-angle-right me-2"></i> Contact Us</a>
                        <a href="{{route('index')}}/#appointment"><i class="fas fa-angle-right me-2"></i> Book Now</a>
                    </div>
                </div>
                {{--<div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Terapia Services</h4>
                        <a href=""><i class="fas fa-angle-right me-2"></i> All Services</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Physiotherapy</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Diagnostics</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Manual Therapy</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Massage Therapy</a>
                        <a href=""><i class="fas fa-angle-right me-2"></i> Rehabilitation</a>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-white">Copyright <i class="fas fa-copyright text-light me-2"></i>JeevanRath, All right reserved.</span>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>
    <script src="{{asset('js/main.js')}}"></script>
    @yield('footer')
</body>
</html>