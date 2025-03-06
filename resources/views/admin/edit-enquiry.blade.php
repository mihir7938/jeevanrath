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
                                                <option value="2" @if($enquiry->status == "2") selected @endif>Confirmed</option>
                                                <option value="3" @if($enquiry->status == "3") selected @endif>Cancelled</option>
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
                                <div class="driver_box" style="{{($enquiry->status == '2') ? 'display: block;' : 'display: none;' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="driver">Driver/Vendor*</label>
                                                <select id="driver" name="driver" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($drivers as $driver)
                                                        <option value="{{$driver->id}}" @if($enquiry->driver_id == $driver->id) selected @endif>{{$driver->type}} - {{$driver->name}} - {{$driver->mobile_number}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vehicle_number">Vehicle Number*</label>
                                                <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" placeholder="Vehicle Number" value="{{$enquiry->vehicle_number}}" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pickup_location">Pickup Location*</label>
                                                <input type="text" class="form-control" id="pickup_location" name="pickup_location" placeholder="Pickup Location" value="{{$enquiry->pickup_location}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pickup_time">Pickup Time*</label>
                                                <input type="text" class="form-control datetimepicker-input" id="pickup_time" name="pickup_time" placeholder="Pickup Time" data-toggle="datetimepicker" value="{{$enquiry->pickup_time}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">First Name*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="First Name" value="{{$enquiry->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="journey_date">Date of Journey*</label>
                                            <input type="text" class="form-control" id="journey_date" name="journey_date" placeholder="Date of Journey" value="{{Carbon\Carbon::parse($enquiry->journey_date)->format('d/m/Y')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile*</label>
                                            <input type="phone" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="{{$enquiry->mobile_number}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email*</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$enquiry->email}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pickup_from">Pickup From*</label>
                                            <input type="text" class="form-control" id="pickup_from" name="pickup_from" placeholder="Pickup From" value="{{$enquiry->pickup_from}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="drop_to">Drop To*</label>
                                            <input type="text" class="form-control" id="drop_to" name="drop_to" placeholder="Drop To" value="{{$enquiry->drop_to}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="car">Car*</label>
                                            <select class="form-control" name="car" id="car">
                                                <option value="">Select Car</option>
                                                <option value="Hatchback" @if($enquiry->vehicle_name == "Hatchback") selected @endif>Hatchback</option>
                                                <option value="Ac Sedan" @if($enquiry->vehicle_name == "Ac Sedan") selected @endif>Ac Sedan</option>
                                                <option value="Ac Suv" @if($enquiry->vehicle_name == "Ac Suv") selected @endif>Ac Suv</option>
                                                <option value="Ac Innova" @if($enquiry->vehicle_name == "Ac Innova") selected @endif>Ac Innova</option>
                                                <option value="Innova Crysta" @if($enquiry->vehicle_name == "Innova Crysta") selected @endif>Innova Crysta</option>
                                                <option value="Tempo Traveller" @if($enquiry->vehicle_name == "Tempo Traveller") selected @endif>Tempo Traveller</option>
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
                                                <option value="Local Car Rental" @if($enquiry->journey_type == "Local Car Rental") selected @endif>Local Car Rental</option>
                                            </select>
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
            if($(this).val() == 2) {
                $(".driver_box").show();
            } else {
                $(".driver_box").hide();
            }
        });
        $("#journey_date").datepicker({
            'format': 'dd/mm/yyyy',
            'autoclose': true
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
                driver: {
                    required:function(){
                        if($('#status').val()  == '2') {
                            return true;
                        }
                        return false;
                    },
                },
                vehicle_number: {
                    required:function(){
                        if($('#status').val()  == '2') {
                            return true;
                        }
                        return false;
                    },
                    noSpace: true,
                    alphaNumeric: true
                },
                pickup_location: {
                    required:function(){
                        if($('#status').val()  == '2') {
                            return true;
                        }
                        return false;
                    },
                },
                pickup_time: {
                    required:function(){
                        if($('#status').val()  == '2') {
                            return true;
                        }
                        return false;
                    },
                },
                name:{
                    required: true
                },
                journey_date:{
                    required: true
                },
                mobile:{
                    required: true,
                    digits: true,
                },
                email: {
                    maxlength: 155,
                },
                pickup_from:{
                    required: true
                },
                drop_to:{
                    required: true
                },
                car:{
                    required: true
                },
                journey_type:{
                    required: true
                }
            },
            messages:{
                company_name:{
                    required: "Please enter company name."
                },
                driver:{
                    required: "Please select driver/vendor."
                },
                vehicle_number:{
                    required: "Please enter vehicle number.",
                    noSpace: "Space not allowed",
                    alphaNumeric: "Please enter only letters and numbers.",
                },
                pickup_location:{
                    required: "Please enter pickup location."
                },
                pickup_time:{
                    required: "Please select pickup time."
                },
                name:{
                    required: "Please enter name."
                },
                journey_date:{
                    required: "Please select journey date."
                },
                mobile:{
                    required: "Please enter mobile number.",
                },
                email:{
                    email: "Please provide a valid email."
                },
                pickup_from:{
                    required: "Please enter pickup from."
                },
                drop_to:{
                    required: "Please enter drop to."
                },
                car:{
                    required: "Please select car."
                },
                journey_type:{
                    required: "Please select journey type."
                }
            }
        });
    });
</script>
@endsection