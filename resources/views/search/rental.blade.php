<div class="container service py-5">
    @if(isset($vehicle_details) && count($vehicle_details) > 0)
        <div class="row g-4 justify-content-center">
            @php $i = 0.1; @endphp
            @foreach($vehicle_details as $vehicle_detail)
                <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="{{$i}}s">
                    <div class="service-item rounded">
                       <div class="service-img rounded-top">
                            <img src="{{asset('assets/'.$vehicle_detail->vehicle_image)}}" class="img-fluid rounded-top w-100" alt="">
                       </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="text-center">{{$vehicle_detail->vehicles->name}}</h5>
                                <p class="mb-4 text-center text-dark">₹{{$vehicle_detail->rate}}/km (Includding All)</p>
                                <div class="mb-4 text-dark">
                                    <div class="row py-3">
                                        <div class="col-2 col-lg-2 col-xl-2">
                                            <i class="fas fa-taxi"></i>
                                        </div>
                                        <div class="col-8 col-lg-7 col-xl-8">
                                            Taxi Doors:
                                        </div>
                                        <div class="col-2 col-lg-3 col-xl-2">
                                            {{$vehicle_detail->taxi_doors}}
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
                                            {{$vehicle_detail->passengers}}
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
                                            {{$vehicle_detail->luggage_carry}}
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
                                            {{$vehicle_detail->air_condition ? 'Yes' : 'No'}}
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
                                            {{$vehicle_detail->gps_navigation ? 'Yes' : 'No'}}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#book-now-modal" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php $i = $i + 0.2; @endphp
            @endforeach
        </div>
    @else
        <h3 class="row justify-content-center">No record found</h3>
    @endif
</div>