<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Inquiries</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="fetch_reports_data" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Status</th>
                        <th>Booking ID</th>
                        <th>Guest Name</th>
                        <th>Guest Mobile</th>
                        <th>Pickup Location</th>
                        <th>Vehicle Number</th>
                        <th>Start Journey</th>
                        <th>End Journey</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle Name</th>
                        <th>Journey Type</th>
                        <th>Pickup Time</th>
                        <th>User Type</th>
                        <th>Company Name</th>
                        <th>Booker Name</th>
                        <th>Booker Mobile</th>
                        <th>Vendor</th>
                        <th>Driver</th>
                        <th>Drop Location</th>
                        <th>Package</th>
                        <th>Package Company</th>
                        <th>Total Amount</th>
                        <th>DB Name</th>
                        <th>Duty Approved Date</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Status</th>
                        <th>Booking ID</th>
                        <th>Guest Name</th>
                        <th>Guest Mobile</th>
                        <th>Pickup Location</th>
                        <th>Vehicle Number</th>
                        <th>Start Journey</th>
                        <th>End Journey</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle Name</th>
                        <th>Journey Type</th>
                        <th>Pickup Time</th>
                        <th>User Type</th>
                        <th>Company Name</th>
                        <th>Booker Name</th>
                        <th>Booker Mobile</th>
                        <th>Vendor</th>
                        <th>Driver</th>
                        <th>Drop Location</th>
                        <th>Package</th>
                        <th>Package Company</th>
                        <th>Total Amount</th>
                        <th>DB Name</th>
                        <th>Duty Approved Date</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($enquiries as $enquiry)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center status" style="min-width: 120px;">
                                @if($enquiry->duty_approved == 1)
                                    <div class="bg-success d-inline-flex">Duty Approved</div>
                                @else
                                    @if($enquiry->duty_closed == 1)
                                        <div class="bg-dark d-inline-flex">Duty Closed</div>
                                    @else
                                        @if($enquiry->status == 0)
                                            <div class="bg-secondary d-inline-flex">Pending</div>
                                        @elseif($enquiry->status == 1)
                                            <div class="bg-warning d-inline-flex">Inprocess</div>
                                        @elseif($enquiry->status == 2)
                                            <div class="bg-info d-inline-flex">Booking Confirmed</div>
                                        @elseif($enquiry->status == 3)
                                            <div class="bg-primary d-inline-flex">Trip Confirmed</div>
                                        @elseif($enquiry->status == 4)
                                            <div class="bg-danger d-inline-flex">Cancelled</div>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>{{$enquiry->booking_id}}</td>
                            <td>{{$enquiry->name}}</td>
                            <td>{{$enquiry->mobile_number}}</td>
                            <td>{{$enquiry->pickup_from}}</td>
                            @if($enquiry->status == 3)
                                <td>{{$enquiry->vehicle_number}}</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{Carbon\Carbon::parse($enquiry->journey_date)->format('d/m/Y')}}</td>
                            <td>{{Carbon\Carbon::parse($enquiry->end_journey_date)->format('d/m/Y')}}</td>
                            <td>{{$enquiry->vehicle_name}}</td>
                            <td>{{$enquiry->vehicle}}</td>
                            <td>{{$enquiry->journey_type}}</td>
                            <td>{{$enquiry->pickup_time}}</td>
                            <td>{{$enquiry->user_type}}</td>
                            <td>{{$enquiry->company_name}}</td>
                            <td>{{$enquiry->booker_name}}</td>
                            <td>{{$enquiry->booker_mobile}}</td>
                            @if($enquiry->status == 3)
                                <td>({{$enquiry->vendors->name}} - {{$enquiry->vendors->mobile_number}})</td>
                                <td>({{$enquiry->drivers->name}} - {{$enquiry->drivers->mobile_number}})</td>
                            @else
                                <td></td>
                                <td></td>
                            @endif
                            <td>{{$enquiry->drop_to}}</td>
                            <td>{{$enquiry->package_name}}</td>
                            <td>{{$enquiry->package_company_name}}</td>
                            <td>{{$enquiry->total_amount}}</td>
                            <td>{{$enquiry->db_name}}</td>
                            <td>{{Carbon\Carbon::parse($enquiry->duty_approved_date)->format('d/m/Y')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>