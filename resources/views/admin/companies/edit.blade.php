@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Companies</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.accounts.update.save')}}" class="form" id="edit-companies-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$account->id}}" />
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
                                <h3 class="card-title">Edit Company</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Company Name*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Company Name" value="{{$account->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="acc_id">ACC ID*</label>
                                            <input type="text" class="form-control" id="acc_id" name="acc_id" placeholder="ACC ID" value="{{$account->acc_id}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mobile_number">Mobile Number*</label>
                                            <input type="phone" class="form-control" id="mobile_number" name="mobile_number" placeholder="Mobile Number" value="{{$account->mobile_number}}">
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
        $('#edit-companies-form').validate({
            rules:{
                name: {
                    required: true
                },
                acc_id: {
                    required: true
                },
                mobile_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                }
            },
            messages:{
                name:{
                    required: "Please enter company name."
                },
                acc_id:{
                    required: "Please enter acc id."
                },
                mobile_number:{
                    required: "Please enter mobile number."
                }
            }
        });
    });
</script>
@endsection