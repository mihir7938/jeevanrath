<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Booking Details</h3>
    </div>
    <div class="card-body">
        @if($booking_data)
            <div class="row summary">
                <div class="col-md-6">
                    <div><label>Booking ID :</label> {{$booking_data->booking_id}}</div>
                    @if(Auth::user()->category_id == 1)
                        <div><label>Driver Name :</label> {{$booking_data->driver_name}}</div>
                        <div><label>Driver Mobile Number :</label> {{$booking_data->drivers->mobile_number}}</div>
                    @endif
                    <div><label>Guest Name :</label> {{$booking_data->name}}</div>
                    <div><label>Guest Mobile Number :</label> {{$booking_data->mobile_number}}</div>
                    @if($booking_data->company_name)
                        <div><label>Company Name :</label> {{$booking_data->company_name}}</div>
                    @endif
                    <div><label>Vehicle Type :</label> {{$booking_data->vehicle_name}}</div>
                    <div><label>Vehicle Name :</label> {{$booking_data->vehicle}}</div>
                    <div><label>Vehicle Number :</label> {{$booking_data->vehicle_number}}</div>
                </div>
                <div class="col-md-6">
                    <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($booking_data->journey_date)->format('d-m-Y')}}</div>
                    <div><label>End Journey Date :</label> {{Carbon\Carbon::parse($booking_data->end_journey_date)->format('d-m-Y')}}</div>
                    <div><label>Pickup Time :</label> {{$booking_data->pickup_time}}</div>
                    <div><label>Pickup Location :</label> {{$booking_data->pickup_from}}</div>
                    <div><label>Drop Location :</label> {{$booking_data->drop_to}}</div>
                    <div><label>Journey Type :</label> {{$booking_data->journey_type}}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($booking_data->start_point_kilometer && $booking_data->duty_on_kilometer && $booking_data->duty_start_time)
                        <button type="button" class="btn btn-primary" id="end_duty">End Duty</button>
                    @else
                        <button type="button" class="btn btn-primary" id="start_duty">Start Duty</button>
                    @endif
                </div>
            </div>
            <form method="POST" action="{{route('users.duty.save')}}" class="form" id="duty-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$booking_data->id}}">
                @if($booking_data->start_point_kilometer && $booking_data->duty_on_kilometer && $booking_data->duty_start_time)
                    <div class="end_duty">
                        <div class="row">
                            <div class="col-md-6">
                                <div><label>Start Journey Date :</label> {{Carbon\Carbon::parse($booking_data->journey_date)->format('d-m-Y')}}</div>
                                <div><label>Duty Start Time :</label> {{$booking_data->duty_start_time}}</div>
                                <div><label>Start Point Kilometer :</label> {{$booking_data->start_point_kilometer}}</div>
                                <div><label>Duty On Kilometer :</label> {{$booking_data->duty_on_kilometer}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="duty_closed_kilometer" name="duty_closed_kilometer" placeholder="Duty Closed Kilometer" value="{{$booking_data->duty_closed_kilometer}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control datetimepicker-input" id="duty_end_time" name="duty_end_time" placeholder="Duty End Time" data-toggle="datetimepicker" value="{{$booking_data->duty_end_time}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="end_point_kilometer" name="end_point_kilometer" placeholder="End Point Kilometer" value="{{$booking_data->end_point_kilometer}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="end_duty_date" name="end_duty_date" placeholder="End Date of Journey" value="{{$booking_data->end_duty_date ? Carbon\Carbon::parse($booking_data->end_duty_date)->format('d-m-Y') : ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="fastag_amount" name="fastag_amount" placeholder="Total Fastag Amount" value="{{$booking_data->fastag_amount}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">             
                                            <input type="file" class="custom-file-input" id="fastag_image" name="fastag_image">
                                            <label class="custom-file-label" for="fastag_image">Fastag Statement</label>
                                        </div>              
                                    </div>
                                    @if($booking_data->fastag_image)
                                        <a href="{{asset('assets/'.$booking_data->fastag_image)}}" class="download d-block mt-2" target="_blank">
                                            <button type="button" class="btn btn-primary">Statement <i class="fas fa-download ml-1"></i></button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Remarks" style="height: 50px;">{{$booking_data->remarks}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">             
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">Duty Slip Image</label>
                                        </div>              
                                    </div>
                                    @if($booking_data->image)
                                        <img src="{{asset('assets/'.$booking_data->image)}}" width="200px" class="mt-2 d-block" />
                                    @endif
                                    <input type="hidden" id="booking_image" value="{{$booking_data->image ? $booking_data->image : ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" type="checkbox" id="duty_closed" name="duty_closed">
                                      <label for="duty_closed" class="custom-control-label">Duty Closed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="journey" value="end">
                                <input type="hidden" name="start_date" id="start_date" value="{{Carbon\Carbon::parse($booking_data->journey_date)->format('m/d/Y')}}">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
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
                                    <input type="text" class="form-control" id="start_point_kilometer" name="start_point_kilometer" placeholder="Start Point Kilometer" value="{{$booking_data->start_point_kilometer}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="duty_on_kilometer" name="duty_on_kilometer" placeholder="Duty On Kilometer" value="{{$booking_data->duty_on_kilometer}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control datetimepicker-input" id="duty_start_time" name="duty_start_time" placeholder="Duty Start Time" data-toggle="datetimepicker" value="{{$booking_data->duty_start_time}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="journey" value="start">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
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
