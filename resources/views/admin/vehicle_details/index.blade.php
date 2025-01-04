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
                                <table class="table table-bordered display nowrap" id="dataTableVehicle" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Action</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Rate</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Doors</th>
                                            <th>Passengers</th>
                                            <th>Luggage</th>
                                            <th>AC</th>
                                            <th>GPS</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Action</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Rate</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Doors</th>
                                            <th>Passengers</th>
                                            <th>Luggage</th>
                                            <th>AC</th>
                                            <th>GPS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($vehicle_details as $vehicle_detail)
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <a href="{{route('admin.details.edit', ['id' => $vehicle_detail->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('admin.details.delete', ['id' => $vehicle_detail->id])}}" class="btn btn-outline-danger btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>@if($vehicle_detail->vehicle_image) <img src="{{asset('assets/'.$vehicle_detail->vehicle_image)}}" width="100px"/> @endif</td>
                                                <td>{{$vehicle_detail->vehicles->name}}</td>
                                                <td>{{$vehicle_detail->types->name}}</td>
                                                <td>₹{{$vehicle_detail->rate}}/km</td>
                                                <td>{{$vehicle_detail->states->name}}</td>
                                                <td>{{$vehicle_detail->cities->name}}</td>
                                                <td>{{$vehicle_detail->taxi_doors}}</td>
                                                <td>{{$vehicle_detail->passengers}}</td>
                                                <td>{{$vehicle_detail->luggage_carry}}</td>
                                                <td>{{$vehicle_detail->air_condition ? 'Yes' : 'No'}}</td>
                                                <td>{{$vehicle_detail->gps_navigation ? 'Yes' : 'No'}}</td>
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
<script>
    $(function () {
        $('#dataTableVehicle').DataTable({
            "paging": true,
            "ordering": false,
            "responsive": true,
        });
    });
</script>
@endsection