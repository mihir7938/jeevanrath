@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Monthly Trip</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('shared.alert')
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">All Monthly Trip</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="fetch_inquiry_data" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th width="70">Action</th>
                                            <th>Duty</th>
                                            <th>Booking ID</th>
                                            <th>Guest Name</th>
                                            <th>Guest Mobile</th>
                                            <th>Vehicle Number</th>
                                            <th>Start Journey</th>
                                            <th>End Journey</th>
                                            <th>Vehicle Type</th>
                                            <th>Vehicle Name</th>
                                            <th>User Type</th>
                                            <th>Company Name</th>
                                            <th>Booker Name</th>
                                            <th>Booker Mobile</th>
                                            <th>Vendor</th>
                                            <th>Driver</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Action</th>
                                            <th>Duty</th>
                                            <th>Booking ID</th>
                                            <th>Guest Name</th>
                                            <th>Guest Mobile</th>
                                            <th>Vehicle Number</th>
                                            <th>Start Journey</th>
                                            <th>End Journey</th>
                                            <th>Vehicle Type</th>
                                            <th>Vehicle Name</th>
                                            <th>User Type</th>
                                            <th>Company Name</th>
                                            <th>Booker Name</th>
                                            <th>Booker Mobile</th>
                                            <th>Vendor</th>
                                            <th>Driver</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($packages as $enquiry)
                                            <tr>
                                                <td class="text-center"></td>
                                                <td class="text-center" style="min-width: 70px;">
                                                    <a href="{{route('admin.entries.list', ['id' => $enquiry->id])}}" class="btn btn-outline-dark btn-circle">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </a>
                                                    <a href="{{route('admin.entries.edit', ['id' => $enquiry->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-hand-pointer"></i>
                                                    </a>
                                                </td>
                                                @if($enquiry->duty_closed == 1)
                                                    <td class="status"><div class="bg-success d-inline-flex">Closed</div></td>
                                                @else
                                                    <td class="status" style="min-width: 70px;"><div class="bg-danger d-inline-flex">Not Closed</div></td>
                                                @endif
                                                <td>{{$enquiry->booking_id}}</td>
                                                <td>{{$enquiry->name}}</td>
                                                <td>{{$enquiry->mobile_number}}</td>
                                                @if($enquiry->status == 3)
                                                    <td>{{$enquiry->vehicle_number}}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>{{Carbon\Carbon::parse($enquiry->journey_date)->format('d/m/Y')}}</td>
                                                <td>{{Carbon\Carbon::parse($enquiry->end_journey_date)->format('d/m/Y')}}</td>
                                                <td>{{$enquiry->vehicle_name}}</td>
                                                <td>{{$enquiry->vehicle}}</td>
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script type="text/javascript">
    $(function(){
        $('#fetch_inquiry_data').DataTable({
            "buttons": ["csv", "excel"],
            "responsive": true,
        }).buttons().container().appendTo('#fetch_inquiry_data_wrapper .col-md-6:eq(0) label');
    });
</script>
@endsection