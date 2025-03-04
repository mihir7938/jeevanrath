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
                    <div id="search_result">
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
                        $("#search_result").show();
                        $("#search_result").html('');
                        $('#search_result').append(data);
                    },
                });
            }
        });
    });
</script>
@endsection