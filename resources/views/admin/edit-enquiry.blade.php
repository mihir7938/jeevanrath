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
                                    @if($enquiry->user_type == "Company")
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_name">Company Name</label>
                                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" value="{{$enquiry->company_name}}">
                                            </div>
                                        </div>
                                    @endif
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
                                <div class="driver_box" style="{{($enquiry->status == '3') ? 'display: block;' : 'display: none;' }}">
                                    <div class="row">
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
                                            <label for="car">Car*</label>
                                            <select class="form-control" name="car" id="car">
                                                <option value="">Select Car</option>
                                                <option value="Honda Amaze" @if($enquiry->vehicle_name == "Honda Amaze") selected @endif>Honda Amaze</option>
                                                <option value="Maruti Dzire" @if($enquiry->vehicle_name == "Maruti Dzire") selected @endif>Maruti Dzire</option>
                                                <option value="Toyota Etios" @if($enquiry->vehicle_name == "Toyota Etios") selected @endif>Toyota Etios</option>
                                                <option value="Tata Tigore" @if($enquiry->vehicle_name == "Tata Tigore") selected @endif>Tata Tigore</option>
                                                <option value="Hyndai Aura" @if($enquiry->vehicle_name == "Hyndai Aura") selected @endif>Hyndai Aura</option>
                                                <option value="Honda City" @if($enquiry->vehicle_name == "Honda City") selected @endif>Honda City</option>
                                                <option value="Skoda Octavia" @if($enquiry->vehicle_name == "Skoda Octavia") selected @endif>Skoda Octavia</option>
                                                <option value="Sedan Mercedes" @if($enquiry->vehicle_name == "Sedan Mercedes") selected @endif>Sedan Mercedes</option>
                                                <option value="BMW" @if($enquiry->vehicle_name == "BMW") selected @endif>BMW</option>
                                                <option value="Odi" @if($enquiry->vehicle_name == "Odi") selected @endif>Odi</option>
                                                <option value="Jaguar" @if($enquiry->vehicle_name == "Jaguar") selected @endif>Jaguar</option>
                                                <option value="Maruti Ertiga" @if($enquiry->vehicle_name == "Maruti Ertiga") selected @endif>Maruti Ertiga</option>
                                                <option value="Bolero" @if($enquiry->vehicle_name == "Bolero") selected @endif>Bolero</option>
                                                <option value="Innova" @if($enquiry->vehicle_name == "Innova") selected @endif>Innova</option>
                                                <option value="Marazzo" @if($enquiry->vehicle_name == "Marazzo") selected @endif>Marazzo</option>
                                                <option value="Carens" @if($enquiry->vehicle_name == "Carens") selected @endif>Carens</option>
                                                <option value="Innova Crysta" @if($enquiry->vehicle_name == "Innova Crysta") selected @endif>Innova Crysta</option>
                                                <option value="Innova Hycross" @if($enquiry->vehicle_name == "Innova Hycross") selected @endif>Innova Hycross</option>
                                                <option value="Mahindra XUV 700" @if($enquiry->vehicle_name == "Mahindra XUV 700") selected @endif>Mahindra XUV 700</option>
                                                <option value="Toyota Fortuner" @if($enquiry->vehicle_name == "Toyota Fortuner") selected @endif>Toyota Fortuner</option>
                                                <option value="SUV Mercedes" @if($enquiry->vehicle_name == "SUV Mercedes") selected @endif>SUV Mercedes</option>
                                                <option value="Tempo Traveller (12/17/20 Seater)" @if($enquiry->vehicle_name == "Tempo Traveller (12/17/20 Seater)") selected @endif>Tempo Traveller (12/17/20 Seater)</option>
                                                <option value="Tata Winger (12/17/20 Seater)" @if($enquiry->vehicle_name == "Tata Winger (12/17/20 Seater)") selected @endif>Tata Winger (12/17/20 Seater)</option>
                                                <option value="Force Urbania (12/17/20 Seater)" @if($enquiry->vehicle_name == "Force Urbania (12/17/20 Seater)") selected @endif>Force Urbania (12/17/20 Seater)</option>
                                                <option value="Bus (29/56 seater)" @if($enquiry->vehicle_name == "Bus (29/56 seater)") selected @endif>Bus (29/56 seater)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="journey_type">Type of Journey*</label>
                                            <select class="form-control" name="journey_type" id="journey_type">
                                                <option value="">Type of Journey</option>
                                                <option value="One Way Trip" @if($enquiry->journey_type == "One Way Trip") selected @endif>One Way Trip</option>
                                                <option value="Round Trip" @if($enquiry->journey_type == "Round Trip") selected @endif>Round Trip</option>
                                                <option value="Local Car Rental (8 hrs/80 km)" @if($enquiry->journey_type == "Local Car Rental (8 hrs/80 km)") selected @endif>Local Car Rental (8 hrs/80 km)</option>
                                                <option value="Out Station (300 km avg)" @if($enquiry->journey_type == "Out Station (300 km avg)") selected @endif>Out Station (300 km avg)</option>
                                            </select>
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
                $(".driver_box").show();
            } else {
                $(".driver_box").hide();
            }
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
                    required: true
                },
                mobile:{
                    required: true,
                    digits: true,
                },
                pickup_from:{
                    required: true
                },
                drop_to:{
                    required: true
                },
                journey_date:{
                    required: true
                },
                end_journey_date: {
                    required: true
                },
                car:{
                    required: true
                },
                journey_type:{
                    required: true
                },
                pickup_time: {
                    required: true
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
                vendor:{
                    required: "Please select vendor."
                },
                driver:{
                    required: "Please select driver."
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
                car:{
                    required: "Please select car."
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