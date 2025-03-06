@csrf
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Booking Details</h3>
    </div>
    <div class="card-body">
        @if($booking_data)
            <div class="row">
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
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" id="start_duty">Start Duty</button>
                </div>
            </div>
            <div class="start_duty">
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
                        <button type="submit" class="btn btn-primary" id="startsubmit">Submit</button>
                    </div>
                </div>
            </div>
        @else
            <h5>No record found</h5>
        @endif
    </div>
</div>
<script type="text/javascript">
    $('#start_time').datetimepicker({
        'format': 'LT'
    })
</script>