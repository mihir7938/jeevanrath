@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Packages</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.packages.add.save')}}" class="form" id="add-packages-form" enctype="multipart/form-data">
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
                                <h3 class="card-title">Add Package</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="package_category">Package Category*</label>
                                            <select id="package_category" name="package_category" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($package_categories as $package_category)
                                                    <option value="{{$package_category->id}}">{{$package_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Name*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_km">Package KM</label>
                                            <input type="text" class="form-control" id="package_km" name="package_km" placeholder="Package KM">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_hr">Package HR</label>
                                            <input type="text" class="form-control" id="package_hr" name="package_hr" placeholder="Package HR">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rate">Rate*</label>
                                            <input type="text" class="form-control" id="rate" name="rate" placeholder="Rate">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ex_km_rate">Extra KM Rate*</label>
                                            <input type="text" class="form-control" id="ex_km_rate" name="ex_km_rate" placeholder="Extra KM Rate">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ex_hr_rate">Extra HR Rate*</label>
                                            <input type="text" class="form-control" id="ex_hr_rate" name="ex_hr_rate" placeholder="Extra HR Rate">
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
        $('#add-packages-form').validate({
            rules:{
                package_category: {
                    required: true
                },
                name: {
                    required: true
                },
                package_km: {
                    digits: true
                },
                package_hr: {
                    digits: true
                },
                rate: {
                    required: true,
                    digits: true
                },
                ex_km_rate: {
                    required: true,
                    digits: true
                },
                ex_hr_rate: {
                    required: true,
                    digits: true
                }
            },
            messages:{
                package_category:{
                    required: "Please select package category."
                },
                name:{
                    required: "Please enter package name."
                },
                quantity: {
                    required: "Please enter quantity."
                },
                rate:{
                    required: "Please enter rate."
                },
                ex_km_rate:{
                    required: "Please enter extra km rate."
                },
                ex_hr_rate:{
                    required: "Please enter extra hr rate."
                }
            }
        });
    });
</script>
@endsection