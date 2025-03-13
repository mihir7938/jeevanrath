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
                        <th>Booking ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Journey Date</th>
                        <th>Pickup From</th>
                        <th>Drop To</th>
                        <th>Vehicle Name</th>
                        <th>Journey Type</th>
                        <th>User Type</th>
                        <th>Company Name</th>
                        <th>Guest Name</th>
                        <th>Guest Number</th>
                        <th>Email</th>
                        <th>Driver/Vendor</th>
                        <th>Vehicle Number</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Booking ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Journey Date</th>
                        <th>Pickup From</th>
                        <th>Drop To</th>
                        <th>Vehicle Name</th>
                        <th>Journey Type</th>
                        <th>User Type</th>
                        <th>Company Name</th>
                        <th>Guest Name</th>
                        <th>Guest Number</th>
                        <th>Email</th>
                        <th>Driver/Vendor</th>
                        <th>Vehicle Number</th>
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
                                <a href="{{route('admin.inquiries.delete', ['id' => $enquiry->id])}}" class="btn btn-outline-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td class="text-center status">
                                @if($enquiry->status == 0)
                                    <div class="bg-secondary d-inline-flex">Pending</div>
                                @elseif($enquiry->status == 1)
                                    <div class="bg-warning d-inline-flex">Inprocess</div>
                                @elseif($enquiry->status == 2)
                                    <div class="bg-success d-inline-flex">Confirmed</div>
                                @elseif($enquiry->status == 3)
                                    <div class="bg-danger d-inline-flex">Cancelled</div>
                                @endif
                            </td>
                            <td>{{$enquiry->booking_id}}</td>
                            <td>{{$enquiry->name}}</td>
                            <td>{{$enquiry->mobile_number}}</td>
                            <td>{{Carbon\Carbon::parse($enquiry->journey_date)->format('d/m/Y')}}</td>
                            <td>{{$enquiry->pickup_from}}</td>
                            <td>{{$enquiry->drop_to}}</td>
                            <td>{{$enquiry->vehicle_name}}</td>
                            <td>{{$enquiry->journey_type}}</td>
                            <td>{{$enquiry->user_type}}</td>
                            <td>{{$enquiry->company_name}}</td>
                            <td>{{$enquiry->guest_name}}</td>
                            <td>{{$enquiry->guest_number}}</td>
                            <td>{{$enquiry->email}}</td>
                            @if($enquiry->status == 2)
                                <td>({{$enquiry->drivers->type}} - {{$enquiry->drivers->name}} - {{$enquiry->drivers->mobile_number}})</td>
                                <td>{{$enquiry->vehicle_number}}</td>
                            @else
                                <td></td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>