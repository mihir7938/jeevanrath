@if($category_id  == 1)
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">Add Details</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Vehicle Type*</label>
                    <select id="type" name="type" class="form-control">
                        <option value="">Select</option>
                        @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="vehicle_name">Vehicle*</label>
                    <select id="vehicle_name" name="vehicle_name" class="form-control">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rate">Rate (per km)*</label>
                    <input type="number" class="form-control" id="rate" name="rate" placeholder="Enter Rate" min="1" max="100">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="taxi_doors">Taxi Doors*</label>
                    <input type="number" class="form-control" id="taxi_doors" name="taxi_doors" placeholder="Enter Total Doors" min="1" max="100">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="passengers">Passengers*</label>
                    <input type="number" class="form-control" id="passengers" name="passengers" placeholder="Enter Total Passengers" min="1" max="100">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="luggage_carry">Luggage Carry*</label>
                    <input type="number" class="form-control" id="luggage_carry" name="luggage_carry" placeholder="Enter Total Carry Luggage" min="1" max="100">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="air_condition">Air Condition*</label>
                    <div class="d-flex align-items-center h-38">
                        <div class="custom-control custom-radio mr-3">
                          <input class="custom-control-input" type="radio" id="air_condition_radio1" name="air_condition" value="1" checked>
                          <label for="air_condition_radio1" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="air_condition_radio2" name="air_condition" value="0">
                          <label for="air_condition_radio2" class="custom-control-label">No</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gps_navigation">GPS Navigation*</label>
                    <div class="d-flex align-items-center h-38">
                        <div class="custom-control custom-radio mr-3">
                          <input class="custom-control-input" type="radio" id="gps_navigation_radio1" name="gps_navigation" value="1" checked>
                          <label for="gps_navigation_radio1" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="gps_navigation_radio2" name="gps_navigation" value="0">
                          <label for="gps_navigation_radio2" class="custom-control-label">No</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Vehicle Image* (allowed only JPG,JPEG &amp; PNG files)</label>
                    <div class="input-group">
                        <div class="custom-file">             
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>              
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Submit</button>
    </div>
</div>
@elseif($category_id  == 2)
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">Add Details</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="origin_trip">Origin Trip*</label>
                    <input type="text" class="form-control" id="origin_trip" name="origin_trip" placeholder="Enter Origin Trip">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="return_trip">Return Trip</label>
                    <input type="text" class="form-control" id="return_trip" name="return_trip" placeholder="Enter Return Trip">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="vehicle1">Vehicle*</label>
                    <input type="text" class="form-control" id="vehicle1" name="vehicle1" placeholder="Enter Vehicle Name/Type">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="rate1">Rate*</label>
                    <input type="number" class="form-control" id="rate1" name="rate1" placeholder="Enter Rate">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image1">Vehicle Image*</label>
                    <div class="input-group1">
                        <div class="custom-file">             
                            <input type="file" class="custom-file-input" id="image1" name="image1">
                            <label class="custom-file-label" for="image1">Choose file</label>
                        </div>              
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="vehicle2">Vehicle</label>
                    <input type="text" class="form-control" id="vehicle2" name="vehicle2" placeholder="Enter Vehicle Name/Type">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="rate2">Rate</label>
                    <input type="number" class="form-control" id="rate2" name="rate2" placeholder="Enter Rate">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image2">Vehicle Image</label>
                    <div class="input-group2">
                        <div class="custom-file">             
                            <input type="file" class="custom-file-input" id="image2" name="image2">
                            <label class="custom-file-label" for="image2">Choose file</label>
                        </div>              
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="vehicle3">Vehicle</label>
                    <input type="text" class="form-control" id="vehicle3" name="vehicle3" placeholder="Enter Vehicle Name/Type">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="rate3">Rate</label>
                    <input type="number" class="form-control" id="rate3" name="rate3" placeholder="Enter Rate">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image3">Vehicle Image</label>
                    <div class="input-group3">
                        <div class="custom-file">             
                            <input type="file" class="custom-file-input" id="image3" name="image3">
                            <label class="custom-file-label" for="image3">Choose file</label>
                        </div>              
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="vehicle4">Vehicle</label>
                    <input type="text" class="form-control" id="vehicle4" name="vehicle4" placeholder="Enter Vehicle Name/Type">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="rate4">Rate</label>
                    <input type="number" class="form-control" id="rate4" name="rate4" placeholder="Enter Rate">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image4">Vehicle Image</label>
                    <div class="input-group4">
                        <div class="custom-file">             
                            <input type="file" class="custom-file-input" id="image4" name="image4">
                            <label class="custom-file-label" for="image4">Choose file</label>
                        </div>              
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="vehicle5">Vehicle</label>
                    <input type="text" class="form-control" id="vehicle5" name="vehicle5" placeholder="Enter Vehicle Name/Type">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="rate5">Rate</label>
                    <input type="number" class="form-control" id="rate5" name="rate5" placeholder="Enter Rate">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image5">Vehicle Image</label>
                    <div class="input-group5">
                        <div class="custom-file">             
                            <input type="file" class="custom-file-input" id="image5" name="image5">
                            <label class="custom-file-label" for="image5">Choose file</label>
                        </div>              
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Submit</button>
    </div>
</div>
@endif