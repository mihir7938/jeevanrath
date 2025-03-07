@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
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
                            <h3 class="card-title">All Bookings</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Journey Date</th>
                                            <th>Customer Name</th>
                                            <th>Customer Number</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Journey Date</th>
                                            <th>Customer Name</th>
                                            <th>Customer Number</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                            <tr>
                                                <td>{{$booking->booking_id}}</td>
                                                <td>{{Carbon\Carbon::parse($booking->journey_date)->format('d-m-Y')}}</td>
                                                <td>{{$booking->name}}</td>
                                                <td>{{$booking->mobile_number}}</td>
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
@endsection