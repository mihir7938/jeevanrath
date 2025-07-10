@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Add New Entry</h1>
                        <a href="{{route('admin.entries.list', ['id' => $enquiry->id])}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.entries.save.day')}}" class="form" id="add-entries-form" enctype="multipart/form-data">
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
                                <h3 class="card-title">Booking ID - {{ $enquiry->booking_id}} [{{$enquiry->name}} - {{$enquiry->mobile_number}}]</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="journey_date">Date*</label>
                                            <input type="text" class="form-control" id="journey_date" name="journey_date" placeholder="Date*">
                                            <input type="hidden" name="start_journey_date" id="start_journey_date" value="{{Carbon\Carbon::parse($enquiry->journey_date)->format('m/d/Y')}}">
                                            <input type="hidden" name="end_journey_date" id="end_journey_date" value="{{Carbon\Carbon::parse($enquiry->end_journey_date)->format('m/d/Y')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="starting_kilometer">Starting Kilometer</label>
                                            <input type="text" class="form-control" id="starting_kilometer" name="starting_kilometer" placeholder="Starting Kilometer">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="closing_kilometer">Closing Kilometer</label>
                                            <input type="text" class="form-control" id="closing_kilometer" name="closing_kilometer" placeholder="Closing Kilometer">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="in_time">In Time</label>
                                            <input type="text" class="form-control datetimepicker-input" id="in_time" name="in_time" placeholder="In Time" data-toggle="datetimepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="out_time">Out Time</label>
                                            <input type="text" class="form-control datetimepicker-input" id="out_time" name="out_time" placeholder="Out Time" data-toggle="datetimepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ot_hrs">OT Hrs.</label>
                                            <input type="text" class="form-control datetimepicker-input" id="ot_hrs" name="ot_hrs" placeholder="OT Hrs" data-toggle="datetimepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks">
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
        var startDate = new Date($("#start_journey_date").val());
        var endDate = new Date($("#end_journey_date").val());
        $("#journey_date").datepicker({
            'format': 'dd/mm/yyyy',
            'startDate': startDate,
            'endDate': endDate,
            'autoclose': true
        });
        $('#in_time').datetimepicker({
            'format': 'LT'
        });
        $('#out_time').datetimepicker({
            'format': 'LT'
        });
        $('#ot_hrs').datetimepicker({
            'format': 'HH:mm',
        });
        $('#add-entries-form').validate({
            rules:{
                journey_date:{
                    required: true
                },
                starting_kilometer:{
                    digits: true,
                },
                closing_kilometer:{
                    digits: true,
                }
            },
            messages:{
                journey_date:{
                    required: "Please select journey date."
                }
            }
        });
    });
</script>
@endsection