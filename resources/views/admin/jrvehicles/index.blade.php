@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Jeevan Rath Vehicles</h1>
                        <a href="{{route('admin.jrvehicles.add')}}" class="btn btn-primary">Add New Vehicle</a>
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
                            <h3 class="card-title">All Vehicles</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="100">Action</th>
                                            <th>Vehicle Name</th>
                                            <th>Owner Name</th>
                                            <th>Mobile Number</th>
                                            <th>Alternative Number</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Vehicle Number</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Vehicle Name</th>
                                            <th>Owner Name</th>
                                            <th>Mobile Number</th>
                                            <th>Alternative Number</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Vehicle Number</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($jrvehicles as $vehicle)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{route('admin.jrvehicles.edit', ['id' => $vehicle->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('admin.jrvehicles.delete', ['id' => $vehicle->id])}}" class="btn btn-outline-danger btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>{{$vehicle->vehicle_name}}</td>
                                                <td>{{$vehicle->owner_name}}</td>
                                                <td>{{$vehicle->mobile_number}}</td>
                                                <td>{{$vehicle->alternative_number}}</td>
                                                <td>{{$vehicle->cities->states->name}}</td>
                                                <td>{{$vehicle->cities->name}}</td>
                                                <td>{{$vehicle->vehicle_number}}</td>
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