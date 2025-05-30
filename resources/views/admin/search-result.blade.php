<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Inquiries</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="fetch_inquiry_data" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th width="70">Action</th>
                        <th>Status</th>
                        <th>Sr. No</th>
                        <th>Booking ID</th>
                        <th>Guest Name</th>
                        <th>Guest Mobile</th>
                        <th>Pickup Location</th>
                        <th>Vehicle Number</th>
                        <th>Start Journey</th>
                        <th>End Journey</th>
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
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Sr. No</th>
                        <th>Booking ID</th>
                        <th>Guest Name</th>
                        <th>Guest Mobile</th>
                        <th>Pickup Location</th>
                        <th>Vehicle Number</th>
                        <th>Start Journey</th>
                        <th>End Journey</th>
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
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($enquiries as $enquiry)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center" style="min-width: 70px;">
                                <a href="{{route('admin.inquiries.edit', ['id' => $enquiry->id])}}" class="btn btn-outline-primary btn-circle">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{route('admin.inquiries.delete', ['id' => $enquiry->id])}}" class="btn btn-outline-danger btn-circle btn-delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td class="text-center status" style="min-width: 120px;">
                                @if($enquiry->status == 0)
                                    <div class="bg-dark d-inline-flex">Pending</div>
                                @elseif($enquiry->status == 1)
                                    <div class="bg-warning d-inline-flex">Inprocess</div>
                                @elseif($enquiry->status == 2)
                                    <div class="bg-info d-inline-flex">Booking Confirmed</div>
                                @elseif($enquiry->status == 3)
                                    <div class="bg-success d-inline-flex">Trip Confirmed</div>
                                @elseif($enquiry->status == 4)
                                    <div class="bg-danger d-inline-flex">Cancelled</div>
                                @endif
                            </td>
                            <td>{{$enquiry->id}}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>