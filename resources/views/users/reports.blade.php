@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reports</h1>
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
                            <h3 class="card-title">All Reports</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableReports" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Booking ID</th>
                                            @if(Auth::user()->category_id == 1)
                                                <th>Driver Name</th>
                                                <th>Driver Mobile</th>
                                            @endif
                                            <th>Guest Name</th>
                                            <th>Guest Mobile</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Pickup Location</th>
                                            <th>Drop Location</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Number</th>
                                            <th>Journey Type</th>
                                            <th>Start Point Kilometer</th>
                                            <th>Duty Start Time</th>
                                            <th>Duty On Kilometer</th>
                                            <th>Duty End Time</th>
                                            <th>Duty Closed Kilometer</th>
                                            <th>End Point Kilometer</th>
                                            <th>Fastag Amount</th>
                                            <th>Company Name</th>
                                            <th>Remarks</th>
                                            <th>Image</th>
                                            <th>Fastag Statement</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Booking ID</th>
                                            @if(Auth::user()->category_id == 1)
                                                <th>Driver Name</th>
                                                <th>Driver Mobile</th>
                                            @endif
                                            <th>Guest Name</th>
                                            <th>Guest Mobile</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Pickup Location</th>
                                            <th>Drop Location</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Number</th>
                                            <th>Journey Type</th>
                                            <th>Start Point Kilometer</th>
                                            <th>Duty Start Time</th>
                                            <th>Duty On Kilometer</th>
                                            <th>Duty End Time</th>
                                            <th>Duty Closed Kilometer</th>
                                            <th>End Point Kilometer</th>
                                            <th>Fastag Amount</th>
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
                                                <td>{{$booking->booking_id}}</td>
                                                @if(Auth::user()->category_id == 1)
                                                    <td>{{$booking->driver_name}}</td>
                                                    <td>{{$booking->drivers->mobile_number}}</td>
                                                @endif
                                                <td>{{$booking->name}}</td>
                                                <td>{{$booking->mobile_number}}</td>
                                                <td>{{Carbon\Carbon::parse($booking->journey_date)->format('d-m-Y')}}</td>
                                                <td>{{Carbon\Carbon::parse($booking->end_duty_date)->format('d-m-Y')}}</td>
                                                <td>{{$booking->pickup_from}}</td>
                                                <td>{{$booking->drop_to}}</td>
                                                <td>{{$booking->vehicle_name}}</td>
                                                <td>{{$booking->vehicle_number}}</td>
                                                <td>{{$booking->journey_type}}</td>
                                                <td>{{$booking->start_point_kilometer}}</td>
                                                <td>{{$booking->duty_start_time}}</td>
                                                <td>{{$booking->duty_on_kilometer}}</td>
                                                <td>{{$booking->duty_end_time}}</td>
                                                <td>{{$booking->duty_closed_kilometer}}</td>
                                                <td>{{$booking->end_point_kilometer}}</td>
                                                <td>{{$booking->fastag_amount}}</td>
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