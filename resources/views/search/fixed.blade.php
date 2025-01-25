<div class="container blog py-5">
    @if(isset($vehicle_details) && count($vehicle_details) > 0)
        <div class="row g-4 justify-content-center">
            @php $i = 0.1; @endphp
            @foreach($vehicle_details as $fixed)
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{$i}}s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="{{asset('assets/'.$fixed->vehicle_image)}}" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="blog-centent p-4 text-center">
                            <h4>{{$fixed->origin_trip}}</h4>
                            <h4>{{$fixed->return_trip}}</h4>
                            <div class="my-4 text-dark">
                                @if ($fixed->vehicle1 && $fixed->rate1)
                                    <p class="mb-2">₹{{$fixed->rate1}} {{$fixed->vehicle1}}</p>
                                @endif
                                @if ($fixed->vehicle2 && $fixed->rate2)
                                    <p class="mb-2">₹{{$fixed->rate2}} {{$fixed->vehicle2}}</p>
                                @endif
                                @if ($fixed->vehicle3 && $fixed->rate3)
                                    <p class="mb-2">₹{{$fixed->rate3}} {{$fixed->vehicle3}}</p>
                                @endif
                                @if ($fixed->vehicle4 && $fixed->rate4)
                                    <p class="mb-2">₹{{$fixed->rate4}} {{$fixed->vehicle4}}</p>
                                @endif
                                @if ($fixed->vehicle5 && $fixed->rate5)
                                    <p class="mb-2">₹{{$fixed->rate5}} {{$fixed->vehicle5}}</p>
                                @endif
                                <p class="mb-0">(Includding All)</p>
                            </div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#book-now-modal" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Book Now</a>
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