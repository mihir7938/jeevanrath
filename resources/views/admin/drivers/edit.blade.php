@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Drivers</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.drivers.update.save')}}" class="form" id="edit-drivers-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$driver->id}}" />
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
                                <h3 class="card-title">Edit Driver</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$driver->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address*</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{$driver->address}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile_number">Mobile Number*</label>
                                            <input type="phone" class="form-control" id="mobile_number" name="mobile_number" placeholder="Mobile Number" value="{{$driver->mobile_number}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alternative_number">Alternative Number*</label>
                                            <input type="phone" class="form-control" id="alternative_number" name="alternative_number" placeholder="Alternative Number" value="{{$driver->alternative_number}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_proof">ID Proof*</label>
                                            <select class="form-control" name="id_proof" id="id_proof">
                                                <option value="">Select ID Proof</option>
                                                <option value="aadhaar_card" @if($driver->id_proof == "aadhaar_card") selected @endif>Aadhaar Card</option>
                                                <option value="driving_license" @if($driver->id_proof == "driving_license") selected @endif>Driving License</option>
                                                <option value="pan_card" @if($driver->id_proof == "pan_card") selected @endif>PAN Card</option>
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
                                        @if($driver->id_proof_document)
                                            <a href="{{asset('assets/'.$driver->id_proof_document)}}" class="btn btn-primary" target="_blank">View ID Proof</a>
                                        @endif
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
        $('#edit-drivers-form').validate({
            rules:{
                name: {
                    required: true
                },
                address: {
                    required: true
                },
                mobile_number: {
                    required: true,
                    digits: true,
                },
                alternative_number: {
                    required: true,
                    digits: true,
                },
                id_proof: {
                    required: true
                },
                id_proof_document: {
                    maxsize: 2000000
                }
            },
            messages:{
                name:{
                    required: "Please enter driver name."
                },
                address:{
                    required: "Please enter address."
                },
                mobile_number:{
                    required: "Please enter mobile number."
                },
                alternative_number:{
                    required: "Please enter alternative number."
                },
                id_proof:{
                    required: "Please select id proof."
                },
                id_proof_document:{
                    maxsize: "File size must be less than 2MB."
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