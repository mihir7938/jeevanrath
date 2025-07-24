@extends('layouts.admin-app')
@section('content')
    <div class="content-header"></div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.duty.edit.update')}}" class="form" id="edit-duty-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$enquiry->id}}" />
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
                                <h3 class="card-title">Edit Duty Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row summary mb-2">
                                    <div class="col-md-6">
                                        <div><label>Booking ID :</label> {{$enquiry->booking_id}}</div>
                                        <div><label>Driver Name :</label> {{$enquiry->drivers->name}}</div>
                                        <div><label>Driver Number :</label> {{$enquiry->drivers->mobile_number}}</div>
                                        <div><label>Guest Name :</label> {{$enquiry->name}}</div>
                                        <div><label>Guest Mobile Number :</label> {{$enquiry->mobile_number}}</div>
                                        @if($enquiry->company_name)
                                            <div><label>Company Name :</label> {{$enquiry->company_name}}</div>
                                        @endif
                                        <div><label>Vehicle Type :</label> {{$enquiry->vehicle_name}}</div>
                                        <div><label>Vehicle Name :</label> {{$enquiry->vehicle}}</div>
                                        <div><label>Vehicle Number :</label> {{$enquiry->vehicle_number}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($enquiry->journey_date)->format('d-m-Y')}}</div>
                                        <div><label>End Journey Date :</label> {{Carbon\Carbon::parse($enquiry->end_journey_date)->format('d-m-Y')}}</div>
                                        <div><label>Pickup Time :</label> {{$enquiry->pickup_time}}</div>
                                        <div><label>Pickup Location :</label> {{$enquiry->pickup_from}}</div>
                                        <div><label>Drop Location :</label> {{$enquiry->drop_to}}</div>
                                        <div><label>Journey Type :</label> {{$enquiry->journey_type}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_point_kilometer">Start Point Kilometer*</label>
                                            <input type="text" class="form-control" id="start_point_kilometer" name="start_point_kilometer" placeholder="Start Point Kilometer" value="{{$enquiry->start_point_kilometer}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duty_on_kilometer">Duty On Kilometer*</label>
                                            <input type="text" class="form-control" id="duty_on_kilometer" name="duty_on_kilometer" placeholder="Duty On Kilometer" value="{{$enquiry->duty_on_kilometer}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duty_start_time">Duty Start Time*</label>
                                            <input type="text" class="form-control datetimepicker-input" id="duty_start_time" name="duty_start_time" placeholder="Duty Start Time" data-toggle="datetimepicker" value="{{$enquiry->duty_start_time}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duty_end_time">Duty End Time*</label>
                                            <input type="text" class="form-control datetimepicker-input" id="duty_end_time" name="duty_end_time" placeholder="Duty End Time" data-toggle="datetimepicker" value="{{$enquiry->duty_end_time}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duty_closed_kilometer">Duty Closed Kilometer*</label>
                                            <input type="text" class="form-control" id="duty_closed_kilometer" name="duty_closed_kilometer" placeholder="Duty Closed Kilometer" value="{{$enquiry->duty_closed_kilometer}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_point_kilometer">End Point Kilometer*</label>
                                            <input type="text" class="form-control" id="end_point_kilometer" name="end_point_kilometer" placeholder="End Point Kilometer" value="{{$enquiry->end_point_kilometer}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_duty_date">End Date of Journey*</label>
                                            <input type="text" class="form-control" id="end_duty_date" name="end_duty_date" placeholder="End Date of Journey" value="{{$enquiry->end_duty_date ? Carbon\Carbon::parse($enquiry->end_duty_date)->format('d-m-Y') : ''}}">
                                            <input type="hidden" name="start_date" id="start_date" value="{{Carbon\Carbon::parse($enquiry->journey_date)->format('m/d/Y')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fastag_amount">Total Fastag Amount*</label>
                                            <input type="text" class="form-control" id="fastag_amount" name="fastag_amount" placeholder="Total Fastag Amount" value="{{$enquiry->fastag_amount}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fastag_amount">Duty Slip Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">             
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="image">Duty Slip Image</label>
                                                </div>              
                                            </div>
                                            @if($enquiry->image)
                                                <img src="{{asset('assets/'.$enquiry->image)}}" width="200px" class="mt-2 d-block" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fastag_image">Fastag Statement</label>
                                            <div class="fastag-input-group">
                                                <div class="custom-file">             
                                                    <input type="file" class="custom-file-input" id="fastag_image" name="fastag_image">
                                                    <label class="custom-file-label" for="fastag_image">Fastag Statement</label>
                                                </div>              
                                            </div>
                                            @if($enquiry->fastag_image)
                                                <a href="{{asset('assets/'.$enquiry->fastag_image)}}" class="download d-block mt-2" target="_blank">
                                                    <button type="button" class="btn btn-primary">Statement <i class="fas fa-download ml-1"></i></button>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duty_closed"></label>
                                            <div class="custom-control custom-checkbox">
                                              <input class="custom-control-input" type="checkbox" id="duty_closed" name="duty_closed" @if($enquiry->duty_closed == "1") checked @endif>
                                              <label for="duty_closed" class="custom-control-label">Duty Closed</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Remarks" style="height: 50px;">{{$enquiry->remarks}}</textarea>
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
        $('#duty_start_time').datetimepicker({
            'format': 'LT'
        });
        $('#duty_end_time').datetimepicker({
            'format': 'LT'
        });
        var startDate = new Date($("#start_date").val());
        $("#end_duty_date").datepicker({
            'format': 'dd/mm/yyyy',
            'startDate': startDate,
            'autoclose': true
        });
        $('#edit-duty-form').validate({
            rules:{
                start_point_kilometer:{
                    required: true,
                    digits: true,
                },
                duty_on_kilometer:{
                    required: true,
                    digits: true,
                },
                duty_start_time:{
                    required: true,
                },
                duty_end_time:{
                    required: true,
                },
                duty_closed_kilometer:{
                    required: true,
                    digits: true,
                },
                end_point_kilometer:{
                    required: true,
                    digits: true,
                },
                end_duty_date:{
                    required: true,
                },
                fastag_amount:{
                    digits: true,
                },
                fastag_image: {
                    maxsize: 2000000,
                },
                image:{
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                }
            },
            messages:{
                start_point_kilometer:{
                    required: "Please enter start point kilometer",
                },
                duty_on_kilometer:{
                    required: "Please enter duty on kilometer",
                },
                duty_start_time:{
                    required: "Please select duty start time",
                },
                duty_end_time:{
                    required: "Please select duty end time",
                },
                duty_closed_kilometer:{
                    required: "Please enter duty closed kilometer",
                },
                end_point_kilometer:{
                    required: "Please enter end point kilometer",
                },
                end_duty_date:{
                    required: "Please select end duty date",
                },
                image: {
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "image" ) {
                    $(".input-group").after(error);
                } else if (element.attr("name") == "fastag_image" ) {
                    $(".fastag-input-group").after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection