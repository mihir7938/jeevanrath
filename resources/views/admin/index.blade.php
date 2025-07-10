@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquiries</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_enquiry }}</h3>
                            <p>Total Inquiries</p>
                        </div>
                        <a href="{{route('admin.inquiries.all')}}" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $total_pending_inquiry }}</h3>
                            <p>Total Pending</p>
                        </div>
                        <a href="{{route('admin.inquiries.all')}}?status=0" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $total_inprocess_inquiry }}</h3>
                            <p>Total Inprocess</p>
                        </div>
                        <a href="{{route('admin.inquiries.all')}}?status=1" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $total_booking_confirmed }}</h3>
                            <p>Total Booking Confirmed</p>
                        </div>
                        <a href="{{route('admin.inquiries.all')}}?status=2" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_trip_confirmed }}</h3>
                            <p>Total Trip Confirmed</p>
                        </div>
                        <a href="{{route('admin.inquiries.all')}}?status=3" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $total_cancelled_inquiry }}</h3>
                            <p>Total Cancelled</p>
                        </div>
                        <a href="{{route('admin.inquiries.all')}}?status=4" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Driver Duty Details (Call Based)</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_duties }}</h3>
                            <p>Total</p>
                        </div>
                        <a href="{{route('admin.duty')}}" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $total_not_duty_closed }}</h3>
                            <p>Not Closed</p>
                        </div>
                        <a href="{{route('admin.duty')}}?status=0" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_duty_closed }}</h3>
                            <p>Closed</p>
                        </div>
                        <a href="{{route('admin.duty')}}?status=1" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection