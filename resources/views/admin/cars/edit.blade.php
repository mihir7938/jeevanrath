@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cars</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.cars.update.save')}}" class="form" id="edit-cars-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$car->id}}" />
                        @include('shared.alert')
                        @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Car</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="car_name">Car Name*</label>
                                            <input type="text" class="form-control" id="car_name" name="car_name" placeholder="Enter Car Name" value="{{$car->car_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate">Rate (per km)*</label>
                                            <input type="number" class="form-control" id="rate" name="rate" placeholder="Enter Rate" min="1" max="100" value="{{$car->rate}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="taxi_doors">Taxi Doors*</label>
                                            <input type="number" class="form-control" id="taxi_doors" name="taxi_doors" placeholder="Enter Total Doors" min="1" max="100" value="{{$car->taxi_doors}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="passengers">Passengers*</label>
                                            <input type="number" class="form-control" id="passengers" name="passengers" placeholder="Enter Total Passengers" min="1" max="100" value="{{$car->passengers}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="luggage_carry">Luggage Carry*</label>
                                            <input type="number" class="form-control" id="luggage_carry" name="luggage_carry" placeholder="Enter Total Carry Luggage" min="1" max="100" value="{{$car->luggage_carry}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="air_condition">Air Condition*</label>
                                            <div class="d-flex align-items-center h-38">
                                                <div class="custom-control custom-radio mr-3">
                                                  <input class="custom-control-input" type="radio" id="air_condition_radio1" name="air_condition" value="1" @if($car->air_condition == 1) checked @endif>
                                                  <label for="air_condition_radio1" class="custom-control-label">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" type="radio" id="air_condition_radio2" name="air_condition" value="0" @if($car->air_condition == 0) checked @endif>
                                                  <label for="air_condition_radio2" class="custom-control-label">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Car Image* (allowed only JPG,JPEG &amp; PNG files)</label>
                                            <div class="input-group">
                                                <div class="custom-file">             
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>              
                                            </div>
                                            @if($car->car_image)
                                                <img src="{{asset('assets/'.$car->car_image)}}" width="200px" class="mt-4 d-block" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gps_navigation">GPS Navigation*</label>
                                            <div class="d-flex align-items-center h-38">
                                                <div class="custom-control custom-radio mr-3">
                                                  <input class="custom-control-input" type="radio" id="gps_navigation_radio1" name="gps_navigation" value="1" @if($car->gps_navigation == 1) checked @endif>
                                                  <label for="gps_navigation_radio1" class="custom-control-label">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" type="radio" id="gps_navigation_radio2" name="gps_navigation" value="0" @if($car->gps_navigation == 0) checked @endif>
                                                  <label for="gps_navigation_radio2" class="custom-control-label">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(function () {
        bsCustomFileInput.init();
        $('#edit-cars-form').validate({
            rules:{
                car_name:{
                    required: true
                },
                rate: {
                    required: true,
                    digits: true
                },
                taxi_doors: {
                    required: true,
                    digits: true
                },
                passengers: {
                    required: true,
                    digits: true
                },
                luggage_carry: {
                    required: true,
                    digits: true
                },
                image: {
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                }
            },
            messages:{
                car_name:{
                    required: "Please enter title."
                },
                rate:{
                    required: "Please enter rate."
                },
                taxi_doors:{
                    required: "Please enter total taxi doors."
                },
                passengers:{
                    required: "Please enter total passengers."
                },
                luggage_carry:{
                    required: "Please enter total carry luggage."
                },
                image: {
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "image" ) {
                    $(".input-group").after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection