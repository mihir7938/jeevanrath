@if($category_id  == 1)
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Rental Vehicles</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered display nowrap" id="dataTableVehicle" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Action</th>
                        <th>Image</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Name</th>
                        <th>Type</th>
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
                        <th></th>
                        <th>Action</th>
                        <th>Image</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Rate</th>
                        <th>Doors</th>
                        <th>Passengers</th>
                        <th>Luggage</th>
                        <th>AC</th>
                        <th>GPS</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($vehicles as $vehicle_detail)
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
                            <td>{{$vehicle_detail->states->name}}</td>
                            <td>{{$vehicle_detail->cities->name}}</td>
                            <td>{{$vehicle_detail->vehicles->name}}</td>
                            <td>{{$vehicle_detail->types->name}}</td>
                            <td>₹{{$vehicle_detail->rate}}/km</td>
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
@elseif($category_id  == 2)
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Fixed Vehicles</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered display nowrap" id="dataTableVehicle" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Action</th>
                        <th>Image</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Origin Trip</th>
                        <th>Return Trip</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Action</th>
                        <th>Image</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Origin Trip</th>
                        <th>Return Trip</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Name</th>
                        <th>Rate</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($vehicles as $fixed)
                        <tr>
                            <td></td>
                            <td>
                                <a href="{{route('admin.details.edit', ['id' => $fixed->id])}}" class="btn btn-outline-primary btn-circle">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{route('admin.details.delete', ['id' => $fixed->id])}}" class="btn btn-outline-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td>@if($fixed->vehicle_image) <img src="{{asset('assets/'.$fixed->vehicle_image)}}" width="100px"/> @endif</td>
                            <td>{{$fixed->states->name}}</td>
                            <td>{{$fixed->cities->name}}</td>
                            <td>{{$fixed->origin_trip}}</td>
                            <td>{{$fixed->return_trip}}</td>
                            <td>{{$fixed->vehicle1}}</td>
                            <td>₹{{$fixed->rate1}}</td>
                            <td>{{$fixed->vehicle2}}</td>
                            <td>₹{{$fixed->rate2}}</td>
                            <td>{{$fixed->vehicle3}}</td>
                            <td>₹{{$fixed->rate3}}</td>
                            <td>{{$fixed->vehicle4}}</td>
                            <td>₹{{$fixed->rate4}}</td>
                            <td>{{$fixed->vehicle5}}</td>
                            <td>₹{{$fixed->rate5}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif