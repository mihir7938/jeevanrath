@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Drivers</h1>
                        <a href="{{route('admin.drivers.add')}}" class="btn btn-primary">Add New Driver</a>
                    </div>
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
                            <h3 class="card-title">All Drivers</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="100">Action</th>
                                            <th>Driver Name</th>
                                            <th>Vendor Name</th>
                                            <th>Address</th>
                                            <th>Mobile</th>
                                            <th>Alternative</th>
                                            <th>ID Proof</th>
                                            <th>Status</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Driver Name</th>
                                            <th>Vendor Name</th>
                                            <th>Address</th>
                                            <th>Mobile</th>
                                            <th>Alternative</th>
                                            <th>ID Proof</th>
                                            <th>Status</th>
                                            <th>Email</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($drivers as $driver)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{route('admin.users.change', ['id' => $driver->user_id])}}" class="btn btn-outline-dark btn-circle">
                                                        <i class="fas fa-unlock"></i>
                                                    </a>
                                                    <a href="{{route('admin.drivers.edit', ['id' => $driver->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('admin.drivers.delete', ['id' => $driver->id])}}" class="btn btn-outline-danger btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>{{$driver->name}}</td>
                                                <td>{{$driver->vendors->name}}</td>
                                                <td>{{$driver->address}}</td>
                                                <td>{{$driver->mobile_number}}</td>
                                                <td>{{$driver->alternative_number}}</td>
                                                <td>
                                                    @if($driver->id_proof == 'aadhaar_card')
                                                      <span>Aadhaar Card</span>
                                                    @elseif($driver->id_proof == 'driving_license')
                                                      <span>Driving License</span>
                                                    @elseif($driver->id_proof == 'pan_card')
                                                      <span>PAN Card</span>
                                                    @endif
                                                </td>
                                                <td>{{($driver->users->status == 1) ? 'Active' : 'Not Active'}}</td>
                                                <td>{{$driver->users->email}}</td>
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