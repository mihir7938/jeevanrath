@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Inquiry</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.inquiries.update.save')}}" class="form" id="edit-inquiries-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$enquiry->id}}" />
                        <input type="hidden" id="user_type" name="user_type" value="{{$enquiry->user_type}}" />
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
                                <h3 class="card-title">User Type : {{ $enquiry->user_type }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="0" @if($enquiry->status == "0") selected @endif>Pending</option>
                                                <option value="1" @if($enquiry->status == "1") selected @endif>Inprocess</option>
                                                <option value="2" @if($enquiry->status == "2") selected @endif>Booking Confirmed</option>
                                                <option value="3" @if($enquiry->status == "3") selected @endif>Trip Confirmed</option>
                                                <option value="4" @if($enquiry->status == "4") selected @endif>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" value="{{$enquiry->company_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_type">Vehicle Type*</label>
                                            <select class="form-control" name="vehicle_type" id="vehicle_type">
                                                <option value="">Select Vehicle Type</option>
                                                <option value="Hatchback" @if($enquiry->vehicle_name == "Hatchback") selected @endif>Hatchback</option>
                                                <option value="Sedan" @if($enquiry->vehicle_name == "Sedan") selected @endif>Sedan</option>
                                                <option value="MUV" @if($enquiry->vehicle_name == "MUV") selected @endif>MUV</option>
                                                <option value="SUV" @if($enquiry->vehicle_name == "SUV") selected @endif>SUV</option>
                                                <option value="Premium SUV" @if($enquiry->vehicle_name == "Premium SUV") selected @endif>Premium SUV</option>
                                                <option value="Luxury Car" @if($enquiry->vehicle_name == "Luxury Car") selected @endif>Luxury Car</option>
                                                <option value="Bus" @if($enquiry->vehicle_name == "Bus") selected @endif>Bus</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="journey_type">Type of Journey*</label>
                                            <select class="form-control" name="journey_type" id="journey_type">
                                                <option value="">Type of Journey</option>
                                                <option value="One Way Trip" @if($enquiry->journey_type == "One Way Trip") selected @endif>One Way Trip</option>
                                                <option value="Local Car Rental (8 hrs/80 km)" @if($enquiry->journey_type == "Local Car Rental (8 hrs/80 km)") selected @endif>Local Car Rental (8 hrs/80 km)</option>
                                                <option value="Out Station (300 km avg)" @if($enquiry->journey_type == "Out Station (300 km avg)") selected @endif>Out Station (300 km avg)</option>
                                                <option value="Airport Pickup & Drop" @if($enquiry->journey_type == "Airport Pickup & Drop") selected @endif>Airport Pickup & Drop</option>
                                                <option value="Railway Station Pickup & Drop" @if($enquiry->journey_type == "Railway Station Pickup & Drop") selected @endif>Railway Station Pickup & Drop</option>
                                                <option value="Monthly" @if($enquiry->journey_type == "Monthly") selected @endif>Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if($enquiry->user_type == "Company")
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Booker Name*</label>
                                                <input type="text" class="form-control" id="booker_name" name="booker_name" placeholder="Booker Name" value="{{$enquiry->booker_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mobile">Booker Mobile*</label>
                                                <input type="phone" class="form-control" id="booker_mobile" name="booker_mobile" placeholder="Booker Mobile" value="{{$enquiry->booker_mobile}}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="company_box" style="{{($enquiry->status == '2' || $enquiry->status == '3') ? 'display: block;' : 'display: none;' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="account" class="text-danger">Package Company*</label>
                                                <select id="account" name="account" class="form-control border border-danger">
                                                    <option value="">Select</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{$company->id}}" @if($enquiry->package_company_id == $company->id) selected @endif>{{$company->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="driver_box" style="{{($enquiry->status == '3') ? 'display: block;' : 'display: none;' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category" class="text-danger">Package Category*</label>
                                                <select id="category" name="category" class="form-control border border-danger">
                                                    <option value="">Select</option>
                                                    @foreach($package_categories as $package_category)
                                                        <option value="{{$package_category->id}}" @if($enquiry->package_category_id == $package_category->id) selected @endif>{{$package_category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="package_name" class="text-danger">Package Name*</label>
                                                @if($enquiry->package_id)
                                                    <select id="package_name" name="package_name" class="form-control border border-danger">
                                                        <option value="">Select</option>
                                                        @foreach($packages as $package)
                                                            <option value="{{$package->id}}" @if($enquiry->package_id == $package->id) selected @endif>{{$package->name}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select id="package_name" name="package_name" class="form-control border border-danger">
                                                        <option value="">Select</option>
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vendor" class="text-danger">Vendor*</label>
                                                <select id="vendor" name="vendor" class="form-control border border-danger">
                                                    <option value="">Select</option>
                                                    @foreach($vendors as $vendor)
                                                        <option value="{{$vendor->id}}" @if($enquiry->vendor_id == $vendor->id) selected @endif>{{$vendor->name}} - {{$vendor->mobile_number}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="driver" class="text-danger">Driver*</label>
                                                <select id="driver" name="driver" class="form-control border border-danger">
                                                    <option value="">Select</option>
                                                    @foreach($drivers as $driver)
                                                        <option value="{{$driver->id}}" @if($enquiry->driver_id == $driver->id) selected @endif>{{$driver->name}} - {{$driver->mobile_number}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="car" class="text-danger">Vehicle Name*</label>
                                                <select class="form-control border border-danger" name="car" id="car">
                                                    <option value="">Select Vehicle</option>
                                                    <option value="Honda Amaze" @if($enquiry->vehicle == "Honda Amaze") selected @endif>Honda Amaze</option>
                                                    <option value="Maruti Dzire" @if($enquiry->vehicle == "Maruti Dzire") selected @endif>Maruti Dzire</option>
                                                    <option value="Toyota Etios" @if($enquiry->vehicle == "Toyota Etios") selected @endif>Toyota Etios</option>
                                                    <option value="Tata Tigore" @if($enquiry->vehicle == "Tata Tigore") selected @endif>Tata Tigore</option>
                                                    <option value="Hyndai Aura" @if($enquiry->vehicle == "Hyndai Aura") selected @endif>Hyndai Aura</option>
                                                    <option value="Honda City" @if($enquiry->vehicle == "Honda City") selected @endif>Honda City</option>
                                                    <option value="Skoda Octavia" @if($enquiry->vehicle == "Skoda Octavia") selected @endif>Skoda Octavia</option>
                                                    <option value="Sedan Mercedes" @if($enquiry->vehicle == "Sedan Mercedes") selected @endif>Sedan Mercedes</option>
                                                    <option value="BMW" @if($enquiry->vehicle == "BMW") selected @endif>BMW</option>
                                                    <option value="Odi" @if($enquiry->vehicle == "Odi") selected @endif>Odi</option>
                                                    <option value="Jaguar" @if($enquiry->vehicle == "Jaguar") selected @endif>Jaguar</option>
                                                    <option value="Maruti Ertiga" @if($enquiry->vehicle == "Maruti Ertiga") selected @endif>Maruti Ertiga</option>
                                                    <option value="Bolero" @if($enquiry->vehicle == "Bolero") selected @endif>Bolero</option>
                                                    <option value="Innova" @if($enquiry->vehicle == "Innova") selected @endif>Innova</option>
                                                    <option value="Marazzo" @if($enquiry->vehicle == "Marazzo") selected @endif>Marazzo</option>
                                                    <option value="Carens" @if($enquiry->vehicle == "Carens") selected @endif>Carens</option>
                                                    <option value="Innova Crysta" @if($enquiry->vehicle == "Innova Crysta") selected @endif>Innova Crysta</option>
                                                    <option value="Innova Hycross" @if($enquiry->vehicle == "Innova Hycross") selected @endif>Innova Hycross</option>
                                                    <option value="Mahindra XUV 700" @if($enquiry->vehicle == "Mahindra XUV 700") selected @endif>Mahindra XUV 700</option>
                                                    <option value="Toyota Fortuner" @if($enquiry->vehicle == "Toyota Fortuner") selected @endif>Toyota Fortuner</option>
                                                    <option value="SUV Mercedes" @if($enquiry->vehicle == "SUV Mercedes") selected @endif>SUV Mercedes</option>
                                                    <option value="Tempo Traveller (12/17/20 Seater)" @if($enquiry->vehicle == "Tempo Traveller (12/17/20 Seater)") selected @endif>Tempo Traveller (12/17/20 Seater)</option>
                                                    <option value="Tata Winger (12/17/20 Seater)" @if($enquiry->vehicle == "Tata Winger (12/17/20 Seater)") selected @endif>Tata Winger (12/17/20 Seater)</option>
                                                    <option value="Force Urbania (12/17/20 Seater)" @if($enquiry->vehicle == "Force Urbania (12/17/20 Seater)") selected @endif>Force Urbania (12/17/20 Seater)</option>
                                                    <option value="Bus (29/56 seater)" @if($enquiry->vehicle == "Bus (29/56 seater)") selected @endif>Bus (29/56 seater)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vehicle_number" class="text-danger">Vehicle Number*</label>
                                                <input type="text" class="form-control border border-danger" id="vehicle_number" name="vehicle_number" placeholder="Vehicle Number" value="{{$enquiry->vehicle_number}}" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Guest Name*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Guest Name" value="{{$enquiry->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Guest Mobile*</label>
                                            <input type="phone" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="{{$enquiry->mobile_number}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pickup_from">Pickup Location*</label>
                                            <input type="text" class="form-control" id="pickup_from" name="pickup_from" placeholder="Pickup Location" value="{{$enquiry->pickup_from}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="drop_to">Drop Location*</label>
                                            <input type="text" class="form-control" id="drop_to" name="drop_to" placeholder="Drop Location" value="{{$enquiry->drop_to}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="journey_date">Journey Start Date*</label>
                                            <input type="text" class="form-control" id="journey_date" name="journey_date" placeholder="Journey Start Date" value="{{Carbon\Carbon::parse($enquiry->journey_date)->format('d/m/Y')}}">
                                            <input type="hidden" name="start_journey_date" id="start_journey_date" value="{{Carbon\Carbon::parse($enquiry->journey_date)->format('m/d/Y')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_journey_date">Journey End Date*</label>
                                            <input type="text" class="form-control" id="end_journey_date" name="end_journey_date" placeholder="Journey End Date" value="{{Carbon\Carbon::parse($enquiry->end_journey_date)->format('d/m/Y')}}">
                                            <input type="hidden" name="journey_date_end" id="journey_date_end" value="{{Carbon\Carbon::parse($enquiry->end_journey_date)->format('m/d/Y')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pickup_time">Pickup Time*</label>
                                            <input type="text" class="form-control datetimepicker-input" id="pickup_time" name="pickup_time" placeholder="Pickup Time" data-toggle="datetimepicker" value="{{$enquiry->pickup_time}}">
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
        $(document).on('change', '#status', function(){
            if($(this).val() == 3) {
                $(".company_box").show();
                $(".driver_box").show();
            } else if($(this).val() == 2) {
                $(".company_box").show();
                $(".driver_box").hide();
            } else {
                $(".company_box").hide();
                $(".driver_box").hide();
            }
        });
        $(document).on('change','#category',function() {
            var category_value = $(this).val();
            var appendElement = $("#package_name");
            appendElement.empty();
            var newdata1 = '<option value="">Select</option>';
            $(newdata1).appendTo(appendElement);        
            $.ajax({
                url: "{{ route('get_packages') }}",
                type: 'get',
                data: {
                    'category_id' : category_value
                },
                dataType: 'json',
                success:function(response){
                    if(response.status){
                        $.each(response.packages, function(i,result){
                            newdata = "<option value='"+result.id+"'>"+result.name+"</option>";
                            $(newdata).appendTo(appendElement);
                        });
                    }
                }
            });
        });
        var endDate = new Date($("#journey_date_end").val());
        $("#journey_date").datepicker({
            'format': 'dd/mm/yyyy',
            'endDate': endDate,
            'autoclose': true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#end_journey_date').datepicker('setStartDate', minDate);
        });
        var startDate = new Date($("#start_journey_date").val());
        $("#end_journey_date").datepicker({
            'format': 'dd/mm/yyyy',
            'startDate': startDate,
            'autoclose': true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#journey_date').datepicker('setEndDate', minDate);
        });
        $('#pickup_time').datetimepicker({
            'format': 'LT'
        })
        $.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0; 
        });
        $.validator.addMethod("alphaNumeric", function(value, element) {
            return this.optional(element) || /^[a-z0-9\s]+$/i.test(value);
        });
        $('#edit-inquiries-form').validate({
            rules:{
                company_name: {
                    required:function(){
                        if($('#user_type').val()  == 'Company') {
                            return true;
                        }
                        return false;
                    },
                },
                booker_name: {
                    required:function(){
                        if($('#user_type').val()  == 'Company') {
                            return true;
                        }
                        return false;
                    },
                },
                booker_mobile: {
                    required:function(){
                        if($('#user_type').val()  == 'Company') {
                            return true;
                        }
                        return false;
                    },
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                account: {
                    required:function(){
                        if($('#status').val()  == '2' || $('#status').val()  == '3') {
                            return true;
                        }
                        return false;
                    },
                },
                category: {
                    required:function(){
                        if($('#status').val()  == '3') {
                            return true;
                        }
                        return false;
                    },
                },
                package_name: {
                    required:function(){
                        if($('#status').val()  == '3') {
                            return true;
                        }
                        return false;
                    },
                },
                vendor: {
                    required:function(){
                        if($('#status').val()  == '3') {
                            return true;
                        }
                        return false;
                    },
                },
                driver: {
                    required:function(){
                        if($('#status').val()  == '3') {
                            return true;
                        }
                        return false;
                    },
                },
                car: {
                    required:function(){
                        if($('#status').val()  == '3') {
                            return true;
                        }
                        return false;
                    },
                },
                vehicle_number: {
                    required:function(){
                        if($('#status').val()  == '3') {
                            return true;
                        }
                        return false;
                    },
                    noSpace: true,
                    alphaNumeric: true
                },
                name:{
                    required:function(){
                        if($('#user_type').val()  == 'Company' && $("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                },
                mobile:{
                    required:function(){
                        if($('#user_type').val()  == 'Company' && $("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    },
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                pickup_from:{
                    required:function(){
                        if($("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                },
                drop_to:{
                    required:function(){
                        if($("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                },
                journey_date:{
                    required: true
                },
                end_journey_date: {
                    required: true
                },
                vehicle_type:{
                    required: true
                },
                journey_type:{
                    required: true
                },
                pickup_time: {
                    required:function(){
                        if($("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                }
            },
            messages:{
                company_name:{
                    required: "Please enter company name."
                },
                booker_name:{
                    required: "Please enter booker name."
                },
                booker_mobile:{
                    required: "Please enter booker number."
                },
                account:{
                    required: "Please select package company name."
                },
                category: {
                    required: "Please select package category."
                },
                package_name: {
                    required: "Please select package name."
                },
                vendor:{
                    required: "Please select vendor."
                },
                driver:{
                    required: "Please select driver."
                },
                car: {
                    required: "Please select vehicle."
                },
                vehicle_number:{
                    required: "Please enter vehicle number.",
                    noSpace: "Space not allowed",
                    alphaNumeric: "Please enter only letters and numbers.",
                },
                name:{
                    required: "Please enter name."
                },
                mobile:{
                    required: "Please enter mobile number.",
                },
                pickup_from:{
                    required: "Please enter pickup location."
                },
                drop_to:{
                    required: "Please enter drop location."
                },
                journey_date:{
                    required: "Please select start journey date."
                },
                end_journey_date:{
                    required: "Please select end journey date."
                },
                vehicle_type:{
                    required: "Please select vehicle type."
                },
                journey_type:{
                    required: "Please select journey type."
                },
                pickup_time:{
                    required: "Please select pickup time."
                }
            }
        });
    });
</script>
@endsection