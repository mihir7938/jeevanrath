@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoices</h1>
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
                            <h3 class="card-title">All Invoices</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableReports" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Action</th>
                                            <th>Duty Status</th>
                                            <th>Invoice Date</th>
                                            <th>DB Name (Company)</th>
                                            <th>Booking ID</th>
                                            <th>Vendor</th>
                                            <th>Driver</th>
                                            <th>Contact Number</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Duty Start Time</th>
                                            <th>Duty End Time</th>
                                            <th>Start Point Kilometer</th>
                                            <th>Duty On Kilometer</th>
                                            <th>Duty Closed Kilometer</th>
                                            <th>End Point Kilometer</th>
                                            <th>Fastag Amount</th>
                                            <th>Pickup Location</th>
                                            <th>Drop Location</th>
                                            <th>Journey Type</th>
                                            <th>Vehicle Type</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Number</th>
                                            <th>Guest Name</th>
                                            <th>Guest Mobile</th>
                                            <th>Company Name</th>
                                            <th>Remarks</th>
                                            <th>Image</th>
                                            <th>Fastag Statement</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Action</th>
                                            <th>Duty Status</th>
                                            <th>Invoice Date</th>
                                            <th>DB Name (Company)</th>
                                            <th>Booking ID</th>
                                            <th>Vendor</th>
                                            <th>Driver</th>
                                            <th>Contact Number</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Duty Start Time</th>
                                            <th>Duty End Time</th>
                                            <th>Start Point Kilometer</th>
                                            <th>Duty On Kilometer</th>
                                            <th>Duty Closed Kilometer</th>
                                            <th>End Point Kilometer</th>
                                            <th>Fastag Amount</th>
                                            <th>Pickup Location</th>
                                            <th>Drop Location</th>
                                            <th>Journey Type</th>
                                            <th>Vehicle Type</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Number</th>
                                            <th>Guest Name</th>
                                            <th>Guest Mobile</th>
                                            <th>Company Name</th>
                                            <th>Remarks</th>
                                            <th>Image</th>
                                            <th>Fastag Statement</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                            <tr>
                                                <td></td>
                                                <td style="text-align: center;">
                                                    @if($booking->duty_approved == 0)
                                                        <a href="{{route('admin.invoices.approve', ['id' => $booking->id])}}" class="btn btn-outline-primary btn-circle">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{route('admin.invoices.approve', ['id' => $booking->id])}}" class="btn btn-outline-primary btn-circle">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        {{--<button type="button" class="btn btn-outline-primary btn-circle" disabled><i class="far fa-thumbs-up"></i></button>--}}
                                                    @endif
                                                </td>
                                                <td class="status">
                                                    @if($booking->duty_approved == 0)
                                                        <div class="bg-danger d-inline-flex">Pending</div>
                                                    @else
                                                        <div class="bg-success d-inline-flex">Approved</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($booking->duty_approved_date)
                                                        {{Carbon\Carbon::parse($booking->duty_approved_date)->format('d-m-Y')}}
                                                    @endif
                                                </td>
                                                <td>{{$booking->companies ? $booking->companies->name : ''}}</td>
                                                <td>{{$booking->booking_id}}</td>
                                                <td>{{$booking->vendors->name}}</td>
                                                <td>{{$booking->drivers->name}}</td>
                                                <td>{{$booking->drivers->mobile_number}}</td>
                                                <td>{{Carbon\Carbon::parse($booking->journey_date)->format('d-m-Y')}}</td>
                                                <td>{{Carbon\Carbon::parse($booking->end_journey_date)->format('d-m-Y')}}</td>
                                                <td>{{$booking->duty_start_time}}</td>
                                                <td>{{$booking->duty_end_time}}</td>
                                                <td>{{$booking->start_point_kilometer}}</td>
                                                <td>{{$booking->duty_on_kilometer}}</td>
                                                <td>{{$booking->duty_closed_kilometer}}</td>
                                                <td>{{$booking->end_point_kilometer}}</td>
                                                <td>{{$booking->fastag_amount}}</td>
                                                <td>{{$booking->pickup_from}}</td>
                                                <td>{{$booking->drop_to}}</td>
                                                <td>{{$booking->journey_type}}</td>
                                                <td>{{$booking->vehicle_name}}</td>
                                                <td>{{$booking->vehicle}}</td>
                                                <td>{{$booking->vehicle_number}}</td>
                                                <td>{{$booking->name}}</td>
                                                <td>{{$booking->mobile_number}}</td>
                                                <td>{{$booking->company_name}}</td>
                                                <td>{{$booking->remarks}}</td>
                                                <td>
                                                    @if($booking->image)
                                                        <img src="{{asset('assets/'.$booking->image)}}" width="100px" />
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($booking->fastag_image)
                                                        <a href="{{asset('assets/'.$booking->fastag_image)}}" target="_blank"><i class="fas fa-download ml-1"></i></a>
                                                    @endif
                                                </td>
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
        $('#dataTableReports').DataTable({
            "buttons": ["csv", "excel"],
            "destroy": true,
            "responsive": true,
        }).buttons().container().appendTo('#dataTableReports_wrapper .col-md-6:eq(0) label');
    });
</script>
@endsection