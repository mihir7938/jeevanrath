@extends('layouts.admin-app')
@section('content')
    <div class="content-header"></div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.entries.update')}}" class="form" id="edit-entries-form" enctype="multipart/form-data">
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
                                        <div><label>Name :</label> {{$enquiry->name}}</div>
                                        <div><label>Mobile Number :</label> {{$enquiry->mobile_number}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($enquiry->journey_date)->format('d-m-Y')}}</div>
                                        <div><label>End Journey Date :</label> {{Carbon\Carbon::parse($enquiry->end_journey_date)->format('d-m-Y')}}</div>
                                    </div>
                                </div>
                                <div class="row">
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
                                            <label for="fastag_amount">Total Fastag Amount</label>
                                            <input type="text" class="form-control" id="fastag_amount" name="fastag_amount" placeholder="Total Fastag Amount" value="{{$enquiry->fastag_amount}}">
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
        $('#edit-entries-form').validate({
            rules:{
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