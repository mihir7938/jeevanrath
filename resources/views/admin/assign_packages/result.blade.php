@if($company)
@php
    $company_assign_packages = $company->company_assign_packages()->with('packages')->get();
    $selected_package = [];
@endphp
@foreach($company_assign_packages as $row)
    @php
        $selected_package[] = $row->packages->id;
    @endphp
@endforeach
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Packages</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Package Name*</label>
            </div>
            <div class="col-md-2">
                <label for="rate">Rate*</label>
            </div>
            <div class="col-md-2">
                <label for="ex_km_rate">Extra KM Rate*</label>
            </div>
            <div class="col-md-2">
                <label for="ex_hr_rate">Extra HR Rate*</label>
            </div>
        </div>
        @php 
            $row = 0;
        @endphp
        @foreach($packages as $package)
            @if(in_array($package->id, $selected_package))
                @php
                    $assign_packages = $package->assign_packages()->where('company_id', $company->id)->first();
                @endphp
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="bg-success form-control d-flex justify-content-center align-items-center">Assigned</div>
                            <input type="hidden" class="form-control" name="package[{{$row}}][status]" value="yes">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$package->name}}" disabled>
                            <input type="hidden" class="form-control" name="package[{{$row}}][id]" value="{{$package->id}}">
                            <input type="hidden" class="form-control" name="package[{{$row}}][assign_id]" value="{{$assign_packages->id}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="rate{{$row}}" name="package[{{$row}}][rate]" placeholder="Rate" value="{{$assign_packages->rate}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="ex_km_rate{{$row}}" name="package[{{$row}}][ex_km_rate]" placeholder="Extra KM Rate" value="{{$assign_packages->ex_km_rate}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="ex_hr_rate{{$row}}" name="package[{{$row}}][ex_hr_rate]" placeholder="Extra HR Rate" value="{{$assign_packages->ex_hr_rate}}">
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="bg-danger form-control d-flex justify-content-center align-items-center">Not Assigned</div>
                            <input type="hidden" class="form-control" name="package[{{$row}}][status]" value="no">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$package->name}}" disabled>
                            <input type="hidden" class="form-control" name="package[{{$row}}][id]" value="{{$package->id}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="rate{{$row}}" name="package[{{$row}}][rate]" placeholder="Rate" value="{{$package->rate}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="ex_km_rate{{$row}}" name="package[{{$row}}][ex_km_rate]" placeholder="Extra KM Rate" value="{{$package->ex_km_rate}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="ex_hr_rate{{$row}}" name="package[{{$row}}][ex_hr_rate]" placeholder="Extra HR Rate" value="{{$package->ex_hr_rate}}">
                        </div>
                    </div>
                </div>
            @endif
            @php $row++; @endphp
        @endforeach
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Submit</button>
    </div>
</div>
@endif