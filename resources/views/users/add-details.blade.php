@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('users.details.fetch')}}" class="form" id="fetch-details-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="status" value="2" />
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="booking_id" name="booking_id" placeholder="Booking ID">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Search</button>
                            </div>
                        </div>
                    </form>
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
        $('#fetch-details-form').validate({
            rules:{
                booking_id:{
                    required: true,
                    digits: true,
                }
            },
            messages:{
                booking_id:{
                    required: "Please enter booking id",
                }
            },
            submitHandler: function (form) {
                $('.loader').show();
                $.ajax({
                    url: "{{ route('users.details.fetch') }}",
                    method: "POST",
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                      'booking_id' : $("#booking_id").val(),
                    },
                    success: function (data) {
                        $('.loader').hide();
                        $("#booking_details").show();
                        $("#booking_details").html('');
                        $('#booking_details').append(data);
                        $('#start_time').datetimepicker({
                            'format': 'LT'
                        });
                        $('#end_time').datetimepicker({
                            'format': 'LT'
                        });
                        var startDate = new Date($("#start_date").val());
                        $("#end_date").datepicker({
                            'format': 'dd/mm/yyyy',
                            'startDate': startDate,
                            'autoclose': true
                        });
                        bsCustomFileInput.init();
                    },
                });
            }
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
                    start_kilometre:{
                        required: true,
                        digits: true,
                    },
                    start_time:{
                        required: true,
                    },
                    end_kilometre:{
                        required: true,
                        digits: true,
                    },
                    end_time:{
                        required: true,
                    },
                    end_date:{
                        required: true,
                    },
                    image: {
                        required: true,
                        extension: "png|jpg|jpeg",
                        maxsize: 2000000,
                    }
                },
                messages:{
                    start_kilometre:{
                        required: "Please enter starting kilometre",
                    },
                    start_time:{
                        required: "Please select starting time",
                    },
                    end_kilometre:{
                        required: "Please enter ending kilometre",
                    },
                    end_time:{
                        required: "Please select ending time",
                    },
                    end_date:{
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