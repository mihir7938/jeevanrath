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
                                <table class="table table-bordered" id="dataTableCar" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Rate</th>
                                            <th>Doors</th>
                                            <th>Passengers</th>
                                            <th>Luggage</th>
                                            <th>AC</th>
                                            <th>GPS</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Rate</th>
                                            <th>Doors</th>
                                            <th>Passengers</th>
                                            <th>Luggage</th>
                                            <th>AC</th>
                                            <th>GPS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($cars as $car)
                                            <tr>
                                                <td>
                                                    <a href="{{route('admin.cars.edit', ['id' => $car->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('admin.cars.delete', ['id' => $car->id])}}" class="btn btn-outline-danger btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>@if($car->car_image) <img src="{{asset('assets/'.$car->car_image)}}" width="100px"/> @endif</td>
                                                <td>{{$car->car_name}}</td>
                                                <td>₹{{$car->rate}}/km</td>
                                                <td>{{$car->taxi_doors}}</td>
                                                <td>{{$car->passengers}}</td>
                                                <td>{{$car->luggage_carry}}</td>
                                                <td>{{$car->air_condition ? 'Yes' : 'No'}}</td>
                                                <td>{{$car->gps_navigation ? 'Yes' : 'No'}}</td>
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
        $('#dataTableCar').DataTable({
            "paging": true,
            "ordering": true,
            "responsive": true,
        });
    });
</script>
@endsection