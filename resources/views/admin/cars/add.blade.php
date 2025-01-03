@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Vehicles</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.cars.add.save')}}" class="form" id="add-cars-form" enctype="multipart/form-data">
                        @csrf
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
                                <h3 class="card-title">Add Vehicle</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State*</label>
                                            <select id="state" name="state" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City*</label>
                                            <select id="city" name="city" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Vehicle Type*</label>
                                            <select id="type" name="type" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_name">Vehicle*</label>
                                            <select id="vehicle_name" name="vehicle_name" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate">Rate (per km)*</label>
                                            <input type="number" class="form-control" id="rate" name="rate" placeholder="Enter Rate" min="1" max="100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="taxi_doors">Taxi Doors*</label>
                                            <input type="number" class="form-control" id="taxi_doors" name="taxi_doors" placeholder="Enter Total Doors" min="1" max="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="passengers">Passengers*</label>
                                            <input type="number" class="form-control" id="passengers" name="passengers" placeholder="Enter Total Passengers" min="1" max="100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="luggage_carry">Luggage Carry*</label>
                                            <input type="number" class="form-control" id="luggage_carry" name="luggage_carry" placeholder="Enter Total Carry Luggage" min="1" max="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="air_condition">Air Condition*</label>
                                            <div class="d-flex align-items-center h-38">
                                                <div class="custom-control custom-radio mr-3">
                                                  <input class="custom-control-input" type="radio" id="air_condition_radio1" name="air_condition" value="1" checked>
                                                  <label for="air_condition_radio1" class="custom-control-label">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" type="radio" id="air_condition_radio2" name="air_condition" value="0">
                                                  <label for="air_condition_radio2" class="custom-control-label">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gps_navigation">GPS Navigation*</label>
                                            <div class="d-flex align-items-center h-38">
                                                <div class="custom-control custom-radio mr-3">
                                                  <input class="custom-control-input" type="radio" id="gps_navigation_radio1" name="gps_navigation" value="1" checked>
                                                  <label for="gps_navigation_radio1" class="custom-control-label">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" type="radio" id="gps_navigation_radio2" name="gps_navigation" value="0">
                                                  <label for="gps_navigation_radio2" class="custom-control-label">No</label>
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
        $(document).on('change','#state',function() {
            var state_value = $(this).val();
            var appendElement = $("#city");
            appendElement.empty();
            var newdata1 = '<option value="">Select</option>';
            $(newdata1).appendTo(appendElement);        
            $.ajax({
                url: "{{ route('get_cities') }}",
                type: 'get',
                data: {
                    'state_id' : state_value
                },
                dataType: 'json',
                success:function(response){
                    if(response.status){
                        $.each(response.cities, function(i,result){
                            newdata = "<option value='"+result.id+"'>"+result.name+"</option>";
                            $(newdata).appendTo(appendElement);
                        });
                    }
                }
            });
        });
        $(document).on('change','#type',function() {
            var type_value = $(this).val();
            var appendElement = $("#vehicle_name");
            appendElement.empty();
            var newdata1 = '<option value="">Select</option>';
            $(newdata1).appendTo(appendElement);        
            $.ajax({
                url: "{{ route('get_vehicles') }}",
                type: 'get',
                data: {
                    'type_id' : type_value
                },
                dataType: 'json',
                success:function(response){
                    if(response.status){
                        $.each(response.vehicles, function(i,result){
                            newdata = "<option value='"+result.id+"'>"+result.name+"</option>";
                            $(newdata).appendTo(appendElement);
                        });
                    }
                }
            });
        });
        $('#add-cars-form').validate({
            rules:{
                state:{
                    required: true
                },
                city:{
                    required: true
                },
                type:{
                    required: true
                },
                vehicle_name:{
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
                    required: true,
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                }
            },
            messages:{
                state:{
                    required: "Please select state."
                },
                city:{
                    required: "Please select city."
                },
                type:{
                    required: "Please select vehicle type."
                },
                vehicle_name:{
                    required: "Please select vehicle name."
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
                    required: "Please select image.",
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