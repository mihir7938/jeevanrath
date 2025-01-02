@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Vehicles</h1>
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
                                            <th width="100">Delete Vehicle</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Type Name</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Delete Vehicle</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Type Name</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($vehicles as $vehicle)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{route('admin.vehicles.delete', ['id' => $vehicle->id])}}" class="btn btn-outline-danger btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>{{$vehicle->name}}</td>
                                                <td>{{$vehicle->types->name}}</td>
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