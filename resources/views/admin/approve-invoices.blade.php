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
                        <input type="hidden" name="package_id" value="{{$enquiry->package_id}}" />
                        <input type="hidden" name="ex_km" id="ex_km" value="{{$enquiry->extra_kilometer}}">
                        <input type="hidden" name="ex_hr" id="ex_hr" value="{{$enquiry->extra_time}}">
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
                                        {{--<div><label>Driver Name :</label> {{$enquiry->drivers->name}}</div>
                                        <div><label>Driver Number :</label> {{$enquiry->drivers->mobile_number}}</div>
                                        @if($enquiry->company_name)
                                            <div><label>Company Name :</label> {{$enquiry->company_name}}</div>
                                        @endif --}}
                                        <div><label>Journey Type :</label> {{$enquiry->journey_type}}</div>
                                        <div class="text-danger"><label>Package Company :</label> {{$enquiry->package_company_name}}</div>
                                        <div class="text-danger"><label>Package Category :</label> {{$enquiry->package_category_name}}</div>
                                        <div class="text-danger"><label>Package :</label> {{$enquiry->package_name}}</div>
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
                                        @if($enquiry->journey_date == $enquiry->end_journey_date)
                                            {{--<div class="text-danger"><label>Duty On KM :</label> {{$enquiry->duty_on_kilometer}}</div>
                                            <div class="text-danger"><label>Duty Closed KM :</label> {{$enquiry->duty_closed_kilometer}}</div>--}}
                                        @endif
                                        @if($enquiry->total_kilometer)
                                            <div class="text-danger"><label>Total KM:</label> {{$enquiry->total_kilometer}}</div>
                                        @else
                                            <div class="text-danger"><label>Total KM:</label> {{((int)$enquiry->duty_closed_kilometer - (int)$enquiry->duty_on_kilometer)}}</div>
                                        @endif
                                        <div class="text-danger"><label>Extra KM:</label> {{$enquiry->extra_kilometer}}</div>
                                        <div class="text-danger"><label>Extra Time:</label> {{$enquiry->extra_time}} hrs</div>
                                    </div>
                                </div>
                                {{--<div class="row mt-3">
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
                                </div>--}}
                            </div>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Package Grid</h3>
                            </div>
                            <div class="card-body">
                                <div class="box box_0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name0">Package*</label>
                                                <input type="text" class="form-control package" id="name0" name="package[0][name]" value="{{$enquiry->package_name}}" readonly>
                                                <input type="hidden" name="package[0][flag]" value="1" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="rate0">Rate*</label>
                                                <input type="text" class="form-control rate" id="rate0" name="package[0][rate]" placeholder="Rate" value="{{isset($package_data->rate) ? $package_data->rate : $assign_package->rate}}" autocomplete="off" @if($enquiry->duty_approved == 1) disabled @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="amount0">Amount</label>
                                                <input type="text" class="form-control amount" id="amount0" name="package[0][amount]" placeholder="Amount" value="{{isset($package_data->amount) ? $package_data->amount : $assign_package->rate}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="remarks0">Remarks</label>
                                                <input type="text" class="form-control remarks" id="remarks0" name="package[0][remarks]" placeholder="Remarks" value="{{isset($package_data->remarks) ? $package_data->remarks : ''}}" @if($enquiry->duty_approved == 1) disabled @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box box_1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control package" id="name1" name="package[1][name]" value="Extra KM" readonly>
                                                <input type="hidden" name="package[1][flag]" value="2" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" placeholder="Rate" class="form-control" id="rate1" name="package[1][rate]" value="{{isset($extra_km->rate) ? $extra_km->rate : $assign_package->ex_km_rate}}" autocomplete="off" @if($enquiry->duty_approved == 1) disabled @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control amount" id="amount1" name="package[1][amount]" placeholder="Amount" value="{{isset($extra_km->amount) ? $extra_km->amount : $assign_package->ex_km_rate*$enquiry->extra_kilometer}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control remarks" id="remarks1" name="package[1][remarks]" placeholder="Remarks" value="{{isset($extra_km->remarks) ? $extra_km->remarks : ''}}" @if($enquiry->duty_approved == 1) disabled @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box box_2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control package" id="name2" name="package[2][name]" value="Extra HR" readonly>
                                                <input type="hidden" name="package[2][flag]" value="3" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" placeholder="Rate" class="form-control" id="rate2" name="package[2][rate]" value="{{isset($extra_hr->rate) ? $extra_hr->rate : $assign_package->ex_hr_rate}}" autocomplete="off" @if($enquiry->duty_approved == 1) disabled @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control amount" id="amount2" name="package[2][amount]" placeholder="Amount" value="{{isset($extra_hr->amount) ? $extra_hr->amount : $assign_package->ex_hr_rate*$enquiry->extra_time}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control remarks" id="remarks2" name="package[2][remarks]" placeholder="Remarks" value="{{isset($extra_hr->remarks) ? $extra_km->remarks : ''}}" @if($enquiry->duty_approved == 1) disabled @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php 
                                    $row = 3;
                                    $selected_charge = [];
                                @endphp
                                @foreach($charge_grid as $grid)
                                    @php
                                        $selected_charge[] = $grid->charge_id;
                                    @endphp
                                @endforeach
                                @foreach($charges as $charge)
                                    <div class="box box_{{$row}}">
                                        @if(in_array($charge->id, $selected_charge))
                                            @php
                                                $packages = $charge->charges()->where('enquiry_id', $enquiry->id)->first();
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control package" id="name{{$row}}" name="package[{{$row}}][name]" value="{{$charge->name}}" readonly>
                                                        <input type="hidden" name="package[{{$row}}][charge_id]" value="{{$charge->id}}" />
                                                        <input type="hidden" name="package[{{$row}}][flag]" value="0" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Rate" class="form-control rate" id="rate{{$row}}" name="package[{{$row}}][rate]" value="{{$packages->rate}}" autocomplete="off" @if($enquiry->duty_approved == 1) disabled @endif>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control amount" id="amount{{$row}}" name="package[{{$row}}][amount]" placeholder="Amount" value="{{$packages->amount}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control remarks" id="remarks{{$row}}" name="package[{{$row}}][remarks]" placeholder="Remarks" @if($enquiry->duty_approved == 1) disabled @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control package" id="name{{$row}}" name="package[{{$row}}][name]" value="{{$charge->name}}" readonly>
                                                        <input type="hidden" name="package[{{$row}}][charge_id]" value="{{$charge->id}}" />
                                                        <input type="hidden" name="package[{{$row}}][flag]" value="0" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Rate" class="form-control rate" id="rate{{$row}}" name="package[{{$row}}][rate]" autocomplete="off" @if($enquiry->duty_approved == 1) disabled @endif>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control amount" id="amount{{$row}}" name="package[{{$row}}][amount]" placeholder="Amount" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control remarks" id="remarks{{$row}}" name="package[{{$row}}][remarks]" placeholder="Remarks" @if($enquiry->duty_approved == 1) disabled @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @php $row++; @endphp
                                @endforeach
                                <label>Total Amount : </label><span class="total_amount ml-2"></span>
                                <div class="row mt-2">
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
                                    @if($enquiry->duty_approved == 0)
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                  <input class="custom-control-input" type="checkbox" id="duty_approved" name="duty_approved">
                                                  <label for="duty_approved" class="custom-control-label">Duty Approved</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 hidden">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="duty_approved_date" name="duty_approved_date" placeholder="Invoice Date*">
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="final_remarks" name="final_remarks" placeholder="Remarks" value="{{$enquiry->final_remarks}}">
                                            </div>
                                        </div>
                                    @endif
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
        /*$(document).on('change', '.package', function(){
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
        });*/
        let amounts = document.getElementsByClassName('amount');
        let sum = 0;
        for(let i=0;i<amounts.length;i++){
            if(amounts[i].value) {
                sum += parseFloat(amounts[i].value);
            }
        }
        $(".total_amount").html(sum);
        $(document).on('keyup', '#rate1', function(){
            var ex_km = $("#ex_km").val();
            var rat = $(this).val();
            var amt = $(this).closest('.box').find('.amount');
            $(amt).val(ex_km*rat);
            let amounts = document.getElementsByClassName('amount');
            let sum = 0;
            for(let i=0;i<amounts.length;i++){
                if(amounts[i].value) {
                    sum += parseFloat(amounts[i].value);
                }
            }
            $(".total_amount").html(sum);
        });
        $(document).on('keyup', '#rate2', function(){
            var ex_hr = $("#ex_hr").val();
            var rat = $(this).val();
            var amt = $(this).closest('.box').find('.amount');
            $(amt).val(ex_hr*rat);
            let amounts = document.getElementsByClassName('amount');
            let sum = 0;
            for(let i=0;i<amounts.length;i++){
                if(amounts[i].value) {
                    sum += parseFloat(amounts[i].value);
                }
            }
            $(".total_amount").html(sum);
        });
        $(document).on('keyup', '.rate', function(){
            var rat = $(this).val();
            var amt = $(this).closest('.box').find('.amount');
            $(amt).val(rat);
            let amounts = document.getElementsByClassName('amount');
            let sum = 0;
            for(let i=0;i<amounts.length;i++){
                if(amounts[i].value) {
                    sum += parseFloat(amounts[i].value);
                }
            }
            $(".total_amount").html(sum);
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
                $("#approve-invoices-form .hidden").show();
            } else {
                $("#approve-invoices-form .hidden").hide();
            }
        });   
        $("#duty_approved_date").datepicker({
            'format': 'dd/mm/yyyy',
            'autoclose': true
        });
        $('#approve-invoices-form').validate({
            rules:{
                company_name:{
                    required: true
                },
                /*"package[0][name]":{
                    required: true
                },
                "package[0][quantity]":{
                    required: true,
                    digits: true
                },*/
                "package[0][rate]":{
                    required: true,
                    digits: true
                },
                "package[1][rate]":{
                    required: true,
                    digits: true
                },
                "package[2][rate]":{
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
                company_name:{
                    required: "Please select company name."
                },
                /*"package[0][name]":{
                    required: "Please select package."
                },
                "package[0][quantity]":{
                    required: "Please enter quantity."
                },*/
                "package[0][rate]":{
                    required: "Please enter rate."
                },
                "package[1][rate]":{
                    required: "Please enter rate."
                },
                "package[2][rate]":{
                    required: "Please enter rate."
                },
                duty_approved_date:{
                    required: "Please select invoice date."
                }
            }
        });
        validatePackage();
    });
    function validatePackage(){
        var package = $('body').find('[name^="package"]');
        package.filter('input[name$="[rate]"]').each(function() {
            $(this).rules("add", {
                digits: true,
            });
        });
    }
</script>
@endsection