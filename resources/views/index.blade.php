@extends('layouts.app')
@section('slider')
    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <img src="img/slider_1.jpg" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h1 class="display-1 text-capitalize text-white mb-4">Rental Car</h1>
                    <p class="mb-5 fs-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                    </p>
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Now</a>
                </div>
            </div>
        </div>
        <div class="header-carousel-item">
            <img src="img/slider_2.jpg" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h1 class="display-1 text-capitalize text-white mb-4">Taxi Cab</h1>
                    <p class="mb-5 fs-5 animated slideInDown">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                    </p>
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Now</a>
                </div>
            </div>
        </div>
        <div class="header-carousel-item">
            <img src="img/slider_3.jpg" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h1 class="display-1 text-capitalize text-white mb-4">Fixed Route</h1>
                    <p class="mb-5 fs-5 animated slideInDown">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                    </p>
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Now</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="sub-style">
                    <h2 class="sub-title px-3 mb-0">Rental Cars/Cabs</h2>
                </div>
                <h4 class="display-7 mb-4">We provide cars as per kilometer</h4>
            </div>
            <div class="row g-4 justify-content-center">
                @php $i = 0.1; @endphp
                @foreach($cars as $car)
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="{{$i}}s">
                        <div class="service-item rounded">
                           <div class="service-img rounded-top">
                                <img src="{{asset('assets/'.$car->car_image)}}" class="img-fluid rounded-top w-100" alt="">
                           </div>
                            <div class="service-content rounded-bottom bg-light p-4">
                                <div class="service-content-inner">
                                    <h5 class="text-center">{{$car->car_name}}</h5>
                                    <p class="mb-4 text-center text-dark">₹{{$car->rate}}/km (Includding All)</p>
                                    <div class="mb-4 text-dark">
                                        <div class="row py-3">
                                            <div class="col-2 col-lg-2 col-xl-2">
                                                <i class="fas fa-taxi"></i>
                                            </div>
                                            <div class="col-8 col-lg-7 col-xl-8">
                                                Taxi Doors:
                                            </div>
                                            <div class="col-2 col-lg-3 col-xl-2">
                                                {{$car->taxi_doors}}
                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-2 col-lg-2 col-xl-2">
                                                <i class="fab fa-accessible-icon"></i>
                                            </div>
                                            <div class="col-8 col-lg-7 col-xl-8">
                                                Passengers:
                                            </div>
                                            <div class="col-2 col-lg-3 col-xl-2">
                                                {{$car->passengers}}
                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-2 col-lg-2 col-xl-2">
                                                <i class="fas fa-luggage-cart"></i>
                                            </div>
                                            <div class="col-8 col-lg-7 col-xl-8">
                                                Luggage Carry:
                                            </div>
                                            <div class="col-2 col-lg-3 col-xl-2">
                                                {{$car->luggage_carry}}
                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-2 col-lg-2 col-xl-2">
                                                <i class="fas fa-snowflake"></i>
                                            </div>
                                            <div class="col-8 col-lg-7 col-xl-8">
                                                Air Condition:
                                            </div>
                                            <div class="col-2 col-lg-3 col-xl-2">
                                                {{$car->air_condition ? 'Yes' : 'No'}}
                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-2 col-lg-2 col-xl-2">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </div>
                                            <div class="col-8 col-lg-7 col-xl-8">
                                                GPS Navigation:
                                            </div>
                                            <div class="col-2 col-lg-3 col-xl-2">
                                                {{$car->gps_navigation ? 'Yes' : 'No'}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $i = $i + 0.2; @endphp
                @endforeach
            </div>
        </div>
    </div>
    <div class="container-fluid local bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2">
                    <div class="section-title text-start">
                        <img src="img/car_1.png" class="img-fluid rounded w-100" alt="">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="rounded p-4">
                        <p class="fs-4 text-uppercase text-primary">Terms & Conditions</p>
                        <ul>
                            <li>Only ₹500 in Suart everywhere</li>
                            <li>From anywhere to surat airport</li>
                            <li>From surat airport to anywhere</li>
                            <li>From anywhere to surat railway station</li>
                            <li>From surat railway station to anywhere</li>
                            <li>All taxes included</li>
                            <li>Flexible car choice</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="container-fluid team bg-light py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h2 class="sub-title px-3 mb-0">Our Cabs</h2>
                </div>
                <h4 class="display-7 mb-4">Our Fleets and Rates</h4>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/T1.png" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5 class="mb-2"><strong>Hatchback</strong></h5>
                            <p class="mb-2"><strong>₹ 10/km</strong></p>
                            <p class="mb-2">Clean and AC Cabs</p>
                            <p class="mb-0">Call Now : +919726400024</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/T2.png" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5 class="mb-2"><strong>Hatchback</strong></h5>
                            <p class="mb-2"><strong>₹ 10/km</strong></p>
                            <p class="mb-2">Clean and AC Cabs</p>
                            <p class="mb-0">Call Now : +919726400024</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/T3.png" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5 class="mb-2"><strong>Hatchback</strong></h5>
                            <p class="mb-2"><strong>₹ 10/km</strong></p>
                            <p class="mb-2">Clean and AC Cabs</p>
                            <p class="mb-0">Call Now : +919726400024</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top h-100">
                            <img src="img/T4.png" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5 class="mb-2"><strong>Hatchback</strong></h5>
                            <p class="mb-2"><strong>₹ 10/km</strong></p>
                            <p class="mb-2">Clean and AC Cabs</p>
                            <p class="mb-0">Call Now : +919726400024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <div class="container-fluid blog py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h2 class="sub-title px-3 mb-0">Fixed Route</h2>
                </div>
                <h4 class="display-7 mb-4">We provide cars as a fixed route</h4>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="img/S1.png" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="blog-centent p-4 text-center">
                            <h4>Surat to Mumbai</h4>
                            <h4>Mumbai to Surat</h4>
                            <div class="my-4 text-dark">
                                <p class="mb-2">₹499 Sedan</p>
                                <p class="mb-2">₹4299 Ertiga</p>
                                <p class="mb-2">₹5999 Innova</p>
                                <p class="mb-0">(Includding All)</p>
                            </div>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="img/S2.png" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="blog-centent p-4 text-center">
                            <h4>Surat to Mumbai</h4>
                            <h4>Mumbai to Surat</h4>
                            <div class="my-4 text-dark">
                                <p class="mb-2">₹499 Sedan</p>
                                <p class="mb-2">₹4299 Ertiga</p>
                                <p class="mb-2">₹5999 Innova</p>
                                <p class="mb-0">(Includding All)</p>
                            </div>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="img/S3.png" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="blog-centent p-4 text-center">
                            <h4>Surat to Mumbai</h4>
                            <h4>Mumbai to Surat</h4>
                            <div class="my-4 text-dark">
                                <p class="mb-2">₹499 Sedan</p>
                                <p class="mb-2">₹4299 Ertiga</p>
                                <p class="mb-2">₹5999 Innova</p>
                                <p class="mb-0">(Includding All)</p>
                            </div>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="container-fluid about bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-img pb-5 ps-5">
                        <img src="img/about-1.jpg" class="img-fluid rounded w-100" style="object-fit: cover;" alt="Image">
                        <div class="about-img-inner">
                            <img src="img/about-2.jpg" class="img-fluid rounded-circle w-100 h-100" alt="Image">
                        </div>
                        <div class="about-experience">15 years experience</div>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="section-title text-start mb-5">
                        <h4 class="sub-title pe-3 mb-0">About Us</h4>
                        <h1 class="display-3 mb-4">We are Ready to Help Improve Your Treatment.</h1>
                        <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
                        <div class="mb-4">
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Refresing to get such a personal touch.</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Duis aute irure dolor in reprehenderit in voluptate.</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid feature py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Why Choose Us</h4>
                </div>
                <h1 class="display-3 mb-4">Why Choose Us? Get Your Life Style Back</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-diagnoses fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Licensed Therapist</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-briefcase-medical fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Personalized Treatment</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-hospital-user fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Therapy Goals</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-users fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Practitioners Network</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-spa fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Comfortable Center</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-heart fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Experienced Stuff</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fab fa-pied-piper fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Therapy Goals</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-user-md fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Licensed Therapist</h5>
                                <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">More Details</a>
                </div>
            </div>
        </div>
    </div>--}}
    <div class="container-fluid appointment py-5" id="appointment">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2">
                    <div class="section-title text-start">
                        <h2 class="sub-title pe-3 mb-0">Solutions To Your Plan</h2>
                        <h4 class="display-7 mb-4">Best Car Services With Minimal Rate</h4>
                        <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
                        <div class="row g-4">
                            <div class="col-sm-12">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4">
                                        <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i> Lorem Ipsum</h5>
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et deserunt qui cupiditate veritatis enim ducimus.</p>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i> Lorem Ipsum</h5>
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et deserunt qui cupiditate veritatis enim ducimus.</p>
                                    </div>
                                    <div class="text-start mb-4">
                                        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">More Details</a>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-sm-6">
                                <div class="video h-100">
                                    <img src="img/video-img.jpg" class="img-fluid rounded w-100 h-100" style="object-fit: cover;" alt="">
                                    <button type="button" class="btn btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                                        <span></span>
                                    </button>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">Get In Touch</p>
                        <h4 class="display-7 mb-4">Book Your Car Now</h4>
                        <form>
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <input type="text" class="form-control py-3 border-primary bg-transparent" placeholder="First Name">
                                </div>
                                <div class="col-xl-6">
                                    <input type="text" class="form-control py-3 border-primary bg-transparent" placeholder="Date of Journey">
                                </div>
                                <div class="col-xl-6">
                                    <input type="phone" class="form-control py-3 border-primary bg-transparent" placeholder="Phone">
                                </div>
                                <div class="col-xl-6">
                                    <input type="email" class="form-control py-3 border-primary bg-transparent" placeholder="Email">
                                </div>
                                <div class="col-xl-6">
                                    <input type="text" class="form-control py-3 border-primary bg-transparent" placeholder="Pickup From">
                                </div>
                                <div class="col-xl-6">
                                    <input type="text" class="form-control py-3 border-primary bg-transparent" placeholder="Drop To">
                                </div>
                                <div class="col-xl-6">
                                    <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                        <option value="">Select Car</option>
                                        <option value="Hatchback">Hatchback</option>
                                        <option value="Ac Sedan">Ac Sedan</option>
                                        <option value="Ac Suv">Ac Suv</option>
                                        <option value="Ac Innova">Ac Innova</option>
                                        <option value="innova Crysta">innova Crysta</option>
                                        <option value="tempo Traveller">tempo Traveller</option>
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                        <option value="">Type of journey</option>
                                        <option value="One way Trip">One way Trip</option>
                                        <option value="Round trip">Round trip</option>
                                        <option value="Local car rental">Local car rental</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary text-white w-100 py-3 px-5">SUBMIT NOW</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid testimonial py-5 wow zoomInDown" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title mb-5">
                <div class="sub-style">
                    <h4 class="sub-title text-white px-3 mb-0">Testimonial</h4>
                </div>
                <h1 class="display-3 mb-4">What Clients are Say</h1>
            </div>
            <div class="testimonial-carousel owl-carousel">
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="img/testimonial-img.jpg" class="img-fluid rounded-circle" alt="">
                        </div>
                        <p class="text-white fs-7">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores nemo facilis tempora esse explicabo sed! Dignissimos quia ullam pariatur blanditiis sed voluptatum. Totam aut quidem laudantium tempora. Minima, saepe earum!
                        </p>
                        <div class="text-center">
                            <h5 class="mb-2">John Abraham</h5>
                            <p class="mb-2 text-white-50">New York, USA</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="img/testimonial-img.jpg" class="img-fluid rounded-circle" alt="">
                        </div>
                        <p class="text-white fs-7">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores nemo facilis tempora esse explicabo sed! Dignissimos quia ullam pariatur blanditiis sed voluptatum. Totam aut quidem laudantium tempora. Minima, saepe earum!
                        </p>
                        <div class="text-center">
                            <h5 class="mb-2">John Abraham</h5>
                            <p class="mb-2 text-white-50">New York, USA</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="img/testimonial-img.jpg" class="img-fluid rounded-circle" alt="">
                        </div>
                        <p class="text-white fs-7">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores nemo facilis tempora esse explicabo sed! Dignissimos quia ullam pariatur blanditiis sed voluptatum. Totam aut quidem laudantium tempora. Minima, saepe earum!
                        </p>
                        <div class="text-center">
                            <h5 class="mb-2">John Abraham</h5>
                            <p class="mb-2 text-white-50">New York, USA</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection