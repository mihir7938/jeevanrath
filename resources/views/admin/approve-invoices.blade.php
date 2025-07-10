@extends('layouts.admin-app')
@section('content')
    <div class="content-header"></div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.invoices.approve.update')}}" class="form" id="approve-invoices-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="enquiry_id" value="{{$enquiry->id}}" />
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
                                    <div class="col-md-4">
                                        <div><label>Booking ID :</label> {{$enquiry->booking_id}}</div>
                                        <div><label>Driver Name :</label> {{$enquiry->drivers->name}}</div>
                                        <div><label>Driver Number :</label> {{$enquiry->drivers->mobile_number}}</div>
                                        @if($enquiry->company_name)
                                            <div><label>Company Name :</label> {{$enquiry->company_name}}</div>
                                        @endif
                                        <div><label>Journey Type :</label> {{$enquiry->journey_type}}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($enquiry->journey_date)->format('d-m-Y')}}</div>
                                        <div><label>End Journey Date :</label> {{Carbon\Carbon::parse($enquiry->end_journey_date)->format('d-m-Y')}}</div>
                                        <div><label>Pickup Time :</label> {{$enquiry->pickup_time}}</div>
                                        <div><label>Pickup Location :</label> {{$enquiry->pickup_from}}</div>
                                        <div><label>Drop Location :</label> {{$enquiry->drop_to}}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div><label>Vehicle Type :</label> {{$enquiry->vehicle_name}}</div>
                                        <div><label>Vehicle Name :</label> {{$enquiry->vehicle}}</div>
                                        <div><label>Vehicle Number :</label> {{$enquiry->vehicle_number}}</div>
                                        @if($enquiry->journey_type !== "Monthly")
                                            <div class="text-danger"><label>Duty On KM :</label> {{$enquiry->duty_on_kilometer}}</div>
                                            <div class="text-danger"><label>Duty Closed KM :</label> {{$enquiry->duty_closed_kilometer}}</div>
                                        @endif
                                        @if($enquiry->total_kilometer)
                                            <div class="text-danger"><label>Duty Total KM:</label> {{$enquiry->total_kilometer}}</div>
                                        @else
                                            <div class="text-danger"><label>Duty Total KM:</label> {{((int)$enquiry->duty_closed_kilometer - (int)$enquiry->duty_on_kilometer)}}</div>
                                        @endif
                                    </div>
                                </div>
                                {{--<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Duty Status</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="0" @if($enquiry->duty_approved == "0") selected @endif>Pending</option>
                                                <option value="1" @if($enquiry->duty_approved == "1") selected @endif>Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="package_category" name="package_category" class="form-control" @if($enquiry->duty_approved == 1) disabled @endif>
                                                <option value="">Select Category</option>
                                                @foreach($package_categories as $package_category)
                                                    @php
                                                        $selected = '';
                                                        if($total_packages > 0) {
                                                            if($category_id == $package_category->id) {
                                                                $selected = 'selected';
                                                            }
                                                        }
                                                    @endphp
                                                    <option value="{{$package_category->id}}" {{$selected}}>{{$package_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="company_name" name="company_name" class="form-control" @if($enquiry->duty_approved == 1) disabled @endif>
                                                <option value="">Select Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" @if($enquiry->company_id == $company->id) selected @endif>{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="package_grid" style="{{($total_packages > 0) ? 'display: block;' : 'display: none;' }}">
                            @include('admin.package-grid', ['category_id' => $category_id, 'packages' => $packages, 'package_grid' => $package_grid, 'total_packages' => $total_packages, 'enquiry' => $enquiry])
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
        $(document).on('change','#package_category',function() {
            $('.loader').show();
            $.ajax({
                url: "{{ route('admin.invoices.fetch') }}",
                method: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                  'category_id' : $("#package_category").val(),
                  'enquiry_id' : $("#enquiry_id").val(),
                },
                success: function (data) {
                  $('.loader').hide();
                  $("#package_grid").html('');
                  $("#package_grid").show();
                  $('#package_grid').append(data);
                },
            });
        });
        $(document).on('change', '.package', function(){
            var quantity = $(this).closest('.box').find('.quantity');
            var rate = $(this).closest('.box').find('.rate');
            var amount = $(this).closest('.box').find('.amount');
            var remarks = $(this).closest('.box').find('.remarks');
            if($(this).val()) {
                $('.loader').show();
                $.ajax({
                    url: "{{ route('admin.invoices.fetch.rate') }}",
                    method: "GET",
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                      'package_id' : $(this).val(),
                    },
                    success:function(response){
                        if(response.status){
                            $('.loader').hide();
                            $(quantity).val(response.package.quantity);
                            $(rate).val(response.package.rate);
                            $(amount).val(response.package.quantity*response.package.rate);
                            $(quantity).prop('disabled', false);
                            $(rate).prop('disabled', false);
                            $(remarks).prop('disabled', false);
                        }
                    }
                });
            }
        });
        $(document).on('keyup', '.quantity', function(){
            var qnt = $(this).val();
            var rat = $(this).closest('.box').find('.rate').val();
            var amt = $(this).closest('.box').find('.amount');
            $(amt).val(qnt*rat);
        });
        $(document).on('keyup', '.rate', function(){
            var qnt = $(this).closest('.box').find('.quantity').val();
            var rat = $(this).val();
            var amt = $(this).closest('.box').find('.amount');
            $(amt).val(qnt*rat);
        });
        $(document).on('click', '#btnsubmit', function(e){
            e.preventDefault();
            if ($("#duty_approved").prop('checked')==true && $("#duty_approved_date").val() != ''){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to edit the package in future!",
                    type: 'warning',
                    showCancelButton: true,
                    focusCancel: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, submit it!'
                }).then((result) => {
                    if (result.value) {
                        if ($('#approve-invoices-form').valid()) {
                            $('#approve-invoices-form').submit();
                        }
                    }
                });
            } else {
                if ($('#approve-invoices-form').valid()) {
                    $('#approve-invoices-form').submit();
                }
            }
        });
        $(document).on('click', '#duty_approved', function(){
            if($(this).prop('checked')==true) {
                $("#package_grid .hidden").show();
            } else {
                $("#package_grid .hidden").hide();
            }
        });   
        $("#duty_approved_date").datepicker({
            'format': 'dd/mm/yyyy',
            'autoclose': true
        });
        $('#approve-invoices-form').validate({
            rules:{
                package_category:{
                    required: true
                },
                company_name:{
                    required: true
                },
                "package[0][name]":{
                    required: true
                },
                "package[0][quantity]":{
                    required: true,
                    digits: true
                },
                "package[0][rate]":{
                    required: true,
                    digits: true
                },
                duty_approved_date: {
                    required:function(){
                        if($("#duty_approved").prop('checked')==true) {
                            return true;
                        }
                        return false;
                    },
                }
            },
            messages:{
                package_category:{
                    required: "Please select package category."
                },
                company_name:{
                    required: "Please select company name."
                },
                "package[0][name]":{
                    required: "Please select package."
                },
                "package[0][quantity]":{
                    required: "Please enter quantity."
                },
                "package[0][rate]":{
                    required: "Please enter rate."
                },
                duty_approved_date:{
                    required: "Please select invoice date."
                }
            }
        });
    });
</script>
@endsection