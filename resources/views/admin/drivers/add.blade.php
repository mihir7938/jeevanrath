@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Drivers/Vendors</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.drivers.add.save')}}" class="form" id="add-drivers-form" enctype="multipart/form-data">
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
                                <h3 class="card-title">Add Driver/Vendor</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center">
                                                <div class="custom-control custom-radio mr-3">
                                                  <input class="custom-control-input" type="radio" id="driver_radio" name="type" value="Driver" checked>
                                                  <label for="driver_radio" class="custom-control-label">Driver</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" type="radio" id="vendor_radio" name="type" value="Vendor">
                                                  <label for="vendor_radio" class="custom-control-label">Vendor</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address*</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Mobile Number*</label>
                                            <input type="phone" class="form-control" id="phone" name="phone" placeholder="Mobile Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alternative_number">Alternative Number*</label>
                                            <input type="phone" class="form-control" id="alternative_number" name="alternative_number" placeholder="Alternative Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="active">Active</label>
                                            <div class="d-flex align-items-center">
                                                <div class="custom-control custom-radio mr-3">
                                                  <input class="custom-control-input" type="radio" id="yes" name="active" value="1" checked>
                                                  <label for="yes" class="custom-control-label">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" type="radio" id="no" name="active" value="0">
                                                  <label for="no" class="custom-control-label">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_proof">ID Proof*</label>
                                            <select class="form-control" name="id_proof" id="id_proof">
                                                <option value="">Select ID Proof</option>
                                                <option value="aadhaar_card">Aadhaar Card</option>
                                                <option value="driving_license">Driving License</option>
                                                <option value="pan_card">PAN Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_proof_document">Upload ID Proof*</label>
                                            <div class="input-group">
                                                <div class="custom-file">             
                                                    <input type="file" class="custom-file-input" id="id_proof_document" name="id_proof_document">
                                                    <label class="custom-file-label" for="id_proof_document">Choose file</label>
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
        $('#add-drivers-form').validate({
            rules:{
                name: {
                    required: true
                },
                address: {
                    required: true
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                alternative_number: {
                    required: true,
                    digits: true,
                },
                id_proof: {
                    required: true
                },
                id_proof_document: {
                    required: true,
                    maxsize: 2000000
                },
                email: {
                    alphanumeric: true
                }
            },
            messages:{
                name:{
                    required: "Please enter driver/vendor name."
                },
                address:{
                    required: "Please enter address."
                },
                phone:{
                    required: "Please enter mobile number."
                },
                alternative_number:{
                    required: "Please enter alternative number."
                },
                id_proof:{
                    required: "Please select id proof."
                },
                id_proof_document:{
                    required: "Please upload id proof.",
                    maxsize: "File size must be less than 2MB."
                },
                email:{
                    email: "Please provide a valid email."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "id_proof_document" ) {
                    $(".input-group").after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection