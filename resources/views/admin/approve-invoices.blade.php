@extends('layouts.admin-app')
@section('content')
    <div class="content-header"></div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.invoices.approve.update')}}" class="form" id="approve-invoices-form" enctype="multipart/form-data">
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
                                <h3 class="card-title">Approve Duty</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div><label>Booking ID :</label> {{$enquiry->booking_id}}</div>
                                        <div><label>Driver Name :</label> {{$enquiry->drivers->name}}</div>
                                        <div><label>Driver Number :</label> {{$enquiry->drivers->mobile_number}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Duty Status</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="0" @if($enquiry->duty_approved == "0") selected @endif>Pending</option>
                                                <option value="1" @if($enquiry->duty_approved == "1") selected @endif>Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Company Name</label>
                                            <select id="company_name" name="company_name" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" @if($enquiry->company_id == $company->id) selected @endif>{{$company->name}}</option>
                                                @endforeach
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
        bsCustomFileInput.init();
        $('#approve-invoices-form').validate({
            rules:{
                company_name:{
                    required: true
                }
            },
            messages:{
                company_name:{
                    required: "Please select company name."
                }
            }
        });
    });
</script>
@endsection