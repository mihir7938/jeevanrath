<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Booking Details</h3>
    </div>
    <div class="card-body">
        @if($booking_data)
            <div class="row summary">
                <div class="col-md-6">
                    <div><label>Customer Name :</label> {{$booking_data->name}}</div>
                    @if($booking_data->company_name)
                        <div><label>Company Name :</label> {{$booking_data->company_name}}</div>
                    @endif
                    <div><label>Contact Number :</label> {{$booking_data->mobile_number}}</div>
                    @if($booking_data->email)
                        <div><label>Contact Email :</label> {{$booking_data->email}}</div>
                    @endif
                    <div><label>Vehicle Name :</label> {{$booking_data->vehicle_name}}</div>
                    <div><label>Vehicle Number :</label> {{$booking_data->vehicle_number}}</div>
                </div>
                <div class="col-md-6">
                    <div><label>Journey Date :</label> {{Carbon\Carbon::parse($booking_data->journey_date)->format('d-m-Y')}}</div>
                    <div><label>Pickup Time :</label> {{$booking_data->pickup_time}}</div>
                    <div><label>Pickup Location :</label> {{$booking_data->pickup_location}}</div>
                    {{--<div><label>Pickup From :</label> {{$booking_data->pickup_from}}</div>--}}
                    <div><label>Drop Location :</label> {{$booking_data->drop_to}}</div>
                    <div><label>Journey Type :</label> {{$booking_data->journey_type}}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($driver_duty_data)
                        @if($driver_duty_data->end_kilometre)
                            <button type="button" class="btn btn-primary mb-3" disabled>Duty Closed</button>
                            <div class="row">
                                <div class="col-md-6">
                                    <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($driver_duty_data->start_date)->format('d-m-Y')}}</div>
                                    <div><label>Start Journey Time :</label> {{$driver_duty_data->start_time}}</div>
                                    <div><label>Start Kilometre :</label> {{$driver_duty_data->start_kilometre}}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><label>End Journey Date :</label> {{Carbon\Carbon::parse($driver_duty_data->end_date)->format('d-m-Y')}}</div>
                                    <div><label>End Journey Time :</label> {{$driver_duty_data->end_time}}</div>
                                    <div><label>End Kilometre :</label> {{$driver_duty_data->end_kilometre}}</div>
                                </div>
                            </div>
                        @else
                            <button type="button" class="btn btn-primary" id="end_duty">End Duty</button>
                        @endif
                    @else
                        <button type="button" class="btn btn-primary" id="start_duty">Start Duty</button>
                    @endif
                </div>
            </div>
            <form method="POST" action="{{route('users.duty.save')}}" class="form" id="duty-form" enctype="multipart/form-data">
                @csrf
                @if($driver_duty_data)
                    <div class="end_duty">
                        <div class="row">
                            <div class="col-md-6">
                                <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($driver_duty_data->start_date)->format('d-m-Y')}}</div>
                                <div><label>Start Journey Time :</label> {{$driver_duty_data->start_time}}</div>
                                <div><label>Start Kilometre :</label> {{$driver_duty_data->start_kilometre}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="end_kilometre" name="end_kilometre" placeholder="End Kilometre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control datetimepicker-input" id="end_time" name="end_time" placeholder="End Time" data-toggle="datetimepicker">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date of Journey">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">             
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>              
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="journey" value="end">
                                <input type="hidden" name="id" value="{{$driver_duty_data->id}}">
                                <input type="hidden" name="start_date" id="start_date" value="{{Carbon\Carbon::parse($driver_duty_data->start_date)->format('m/d/Y')}}">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="start_duty">
                        <div class="row">
                            <div class="col-md-6">
                                <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($booking_data->journey_date)->format('d-m-Y')}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="start_kilometre" name="start_kilometre" placeholder="Start Kilometre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control datetimepicker-input" id="start_time" name="start_time" placeholder="Start Time" data-toggle="datetimepicker">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="journey" value="start">
                                <input type="hidden" name="booking_id" value="{{$booking_data->booking_id}}">
                                <input type="hidden" name="start_date" value="{{$booking_data->journey_date}}">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        @else
            <h5>No record found</h5>
        @endif
    </div>
</div>
