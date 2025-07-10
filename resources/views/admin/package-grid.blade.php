<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Package Grid</h3>
    </div>
    <div class="card-body">
        @php 
            $row = 0;
        @endphp
        @if($total_packages > 0)
            @foreach($package_grid as $grid)
                <div class="box box_{{$row}}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                @if($row == 0)<label for="name{{$row}}">Package*</label>@endif
                                <select id="name{{$row}}" name="package[{{$row}}][name]" class="form-control package" @if($enquiry->duty_approved == 1) disabled @endif>
                                    <option value="">Select</option>
                                    @foreach($packages as $package)
                                        <option value="{{$package->id}}" @if($grid->package_id == $package->id) selected @endif>{{$package->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                @if($row == 0)<label for="quantity{{$row}}">Quantity*</label>@endif
                                <input type="text" class="form-control quantity" id="quantity{{$row}}" name="package[{{$row}}][quantity]" placeholder="Enter Quantity" value="{{$grid->quantity}}" @if($enquiry->duty_approved == 1) disabled @endif>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                @if($row == 0)<label for="rate{{$row}}">Rate*</label>@endif
                                <input type="text" class="form-control rate" id="rate{{$row}}" name="package[{{$row}}][rate]" placeholder="Enter Rate" value="{{$grid->rate}}" @if($enquiry->duty_approved == 1) disabled @endif>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                @if($row == 0)<label for="amount{{$row}}">Amount</label>@endif
                                <input type="text" class="form-control amount" id="amount{{$row}}" name="package[{{$row}}][amount]" placeholder="Amount" value="{{$grid->amount}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @if($row == 0)<label for="remarks{{$row}}">Remarks</label>@endif
                                <input type="text" class="form-control remarks" id="remarks{{$row}}" name="package[{{$row}}][remarks]" placeholder="Remarks" value="{{$grid->remarks}}" @if($enquiry->duty_approved == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                </div>
                @php $row++; @endphp
            @endforeach
        @else
            <div class="box box_{{$row}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name{{$row}}">Package*</label>
                            <select id="name{{$row}}" name="package[{{$row}}][name]" class="form-control package">
                                <option value="">Select</option>
                                @foreach($packages as $package)
                                    <option value="{{$package->id}}">{{$package->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="quantity{{$row}}">Quantity*</label>
                            <input type="text" class="form-control quantity" id="quantity{{$row}}" name="package[{{$row}}][quantity]" placeholder="Enter Quantity" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="rate{{$row}}">Rate*</label>
                            <input type="text" class="form-control rate" id="rate{{$row}}" name="package[{{$row}}][rate]" placeholder="Enter Rate" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="amount{{$row}}">Amount</label>
                            <input type="text" class="form-control amount" id="amount{{$row}}" name="package[{{$row}}][amount]" placeholder="Amount" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="remarks{{$row}}">Remarks</label>
                            <input type="text" class="form-control remarks" id="remarks{{$row}}" name="package[{{$row}}][remarks]" placeholder="Remarks" disabled>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($enquiry->duty_approved == 0)
            <a href="javascript:void(0)" class="btn btn-outline-primary btn-circle" id="add_more" name="add_more" onclick="addMorePackageRow(event, this)">Add more</a>
            <div class="row mt-2">
                <div class="col-md-2">
                    <div class="form-group mt-2">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="duty_approved" name="duty_approved">
                          <label for="duty_approved" class="custom-control-label">Duty Approved</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 hidden">
                    <div class="form-group">
                        <input type="text" class="form-control" id="duty_approved_date" name="duty_approved_date" placeholder="Invoice Date*">
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if($enquiry->duty_approved == 0)
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Submit</button>
        </div>
    @endif
</div>
<script type="text/javascript">
    function addMorePackageRow(event, element){
        let rowId = $(document).find('.box').length;
        let html = `<div class="box box_${rowId}">`+
            `<div class="row">`+
                `<div class="col-md-3">`+
                    `<div class="form-group">`+
                        `<select id="name${rowId}" name="package[${rowId}][name]" class="form-control package">`+
                            `<option value="">Select</option>`+
                            @foreach($packages as $package)
                                `<option value="{{$package->id}}">{{$package->name}}</option>`+
                            @endforeach
                        `</select>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-2">`+
                    `<div class="form-group">`+
                        `<input type="text" id="quantity${rowId}" name="package[${rowId}][quantity]" placeholder="Enter Quantity" class="form-control quantity" disabled>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-2">`+
                    `<div class="form-group">`+
                        `<input type="text" id="rate${rowId}" name="package[${rowId}][rate]" placeholder="Enter Rate" class="form-control rate" disabled>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-2">`+
                    `<div class="form-group">`+
                        `<input type="text" id="amount${rowId}" name="package[${rowId}][amount]" placeholder="Amount" class="form-control amount" readonly>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-3">`+
                    `<div class="form-group">`+
                        `<input type="text" id="remarks${rowId}" name="package[${rowId}][remarks]" placeholder="Remarks" class="form-control remarks" disabled>`+
                    `</div>`+
                `</div>`+
            `</div>`+
        `</div>`;
        $(element).before(html);
    }
</script>