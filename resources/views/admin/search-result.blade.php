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
                        <th width="100">Action</th>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Journey Date</th>
                        <th>Pickup From</th>
                        <th>Drop To</th>
                        <th>Vehicle Name</th>
                        <th>Journey Type</th>
                        <th>User Type</th>
                        <th>Company Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Journey Date</th>
                        <th>Pickup From</th>
                        <th>Drop To</th>
                        <th>Vehicle Name</th>
                        <th>Journey Type</th>
                        <th>User Type</th>
                        <th>Company Name</th>
                        <th>Email</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($enquiries as $enquiry)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center" style="min-width: 100px;">
                                <a href="{{route('admin.inquiries.edit', ['id' => $enquiry->id])}}" class="btn btn-outline-primary btn-circle">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{route('admin.inquiries.delete', ['id' => $enquiry->id])}}" class="btn btn-outline-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                @if($enquiry->status == 0)
                                    <div class="py-2 px-3 bg-secondary d-inline-flex">Pending</div>
                                @elseif($enquiry->status == 1)
                                    <div class="py-2 px-3 bg-warning d-inline-flex">Inprocess</div>
                                @elseif($enquiry->status == 2)
                                    <div class="py-2 px-3 bg-success d-inline-flex">Confirmed</div>
                                @elseif($enquiry->status == 3)
                                    <div class="py-2 px-3 bg-danger d-inline-flex">Cancelled</div>
                                @endif
                            </td>
                            <td>{{$enquiry->name}}</td>
                            <td>{{$enquiry->mobile_number}}</td>
                            <td>{{Carbon\Carbon::parse($enquiry->journey_date)->format('d/m/Y')}}</td>
                            <td>{{$enquiry->pickup_from}}</td>
                            <td>{{$enquiry->drop_to}}</td>
                            <td>{{$enquiry->vehicle_name}}</td>
                            <td>{{$enquiry->journey_type}}</td>
                            <td>{{$enquiry->user_type}}</td>
                            <td>{{$enquiry->company_name}}</td>
                            <td>{{$enquiry->email}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>