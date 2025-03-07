@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Duty Details</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('shared.alert')
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control" name="booking_id" id="booking_id">
                                            <option value="">Select Booking ID</option>
                                            @foreach($bookings as $booking)
                                                <option value="{{$booking->booking_id}}">{{$booking->booking_id}} - {{$booking->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="booking_details">
                        @include('users.fetch-details', ['booking_data' => $booking_data])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(function () {
        $(document).on('change', '#booking_id', function(){
            $('.loader').show();
            $.ajax({
                url: "{{ route('users.details.fetch') }}",
                method: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                  'booking_id' : $(this).val(),
                },
                success: function (data) {
                    $('.loader').hide();
                    $("#booking_details").show();
                    $("#booking_details").html('');
                    $('#booking_details').append(data);
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
                    bsCustomFileInput.init();
                },
            });
        });
        $(document).on('click', '#start_duty', function(){
            $(".start_duty").show();
        });
        $(document).on('click', '#end_duty', function(){
            $(".end_duty").show();
        });
        $(document).on('click', '#submitBtn', function(){
            $('#duty-form').validate({
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
                    duty_closed_kilometer:{
                        required: true,
                        digits: true,
                    },
                    duty_end_time:{
                        required: true,
                    },
                    end_point_kilometer:{
                        required: true,
                        digits: true,
                    },
                    end_duty_date:{
                        required: true,
                    },
                    image: {
                        required: true,
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
                    duty_closed_kilometer:{
                        required: "Please enter duty closed kilometer",
                    },
                    duty_end_time:{
                        required: "Please select duty end time",
                    },
                    end_point_kilometer:{
                        required: "Please enter end point kilometer",
                    },
                    end_duty_date:{
                        required: "Please select ending date."
                    },
                    image: {
                        required: "Please upload image.",
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
    });
</script>
@endsection