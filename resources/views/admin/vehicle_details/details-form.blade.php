@if($category_id  == 1)
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">Add Details</h3>
    </div>
    <div class="card-body">
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
    Fixed Route
@endif