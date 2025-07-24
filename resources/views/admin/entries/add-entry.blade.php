@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Daily Entries</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.entries.save')}}" class="form" id="add-entries-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="enquiry_id" value="{{$enquiry->id}}" />
                        <input type="hidden" id="category_id" value="{{$enquiry->package_category_id}}" />
                        <input type="hidden" id="package_km" value="{{$package->package_km}}" />
                        <input type="hidden" id="package_hr" value="{{$package->package_hr}}" />
                        @include('shared.alert')
                        @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Booking ID - {{$enquiry->booking_id}} [{{$enquiry->name}} - {{$enquiry->mobile_number}}]</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label>Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0">
                                            <label>Starting KM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0">
                                            <label>Closing KM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0">
                                            <label>In Time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0">
                                            <label>Out Time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0">
                                            <label>Total KM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0">
                                            <label>Extra KM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0">
                                            <label>Extra Time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <label>Remarks</label>
                                        </div>
                                    </div>
                                </div>
                                @php 
                                    $row = 0;
                                @endphp
                                @foreach($daily_entries as $daily_entry)
                                    <div class="box box_{{$row}}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="journey_date{{$row}}" name="entry[{{$row}}][journey_date]" placeholder="Date" value="{{Carbon\Carbon::parse($daily_entry->journey_date)->format('d/m/Y')}}" readonly>
                                                    <input type="hidden" name="entry[{{$row}}][entry_id]" value="{{$daily_entry->id}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control starting_kilometer" id="starting_kilometer{{$row}}" name="entry[{{$row}}][starting_kilometer]" placeholder="Starting" value="{{$daily_entry->starting_kilometer}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control closing_kilometer" id="closing_kilometer{{$row}}" name="entry[{{$row}}][closing_kilometer]" placeholder="Closing" value="{{$daily_entry->closing_kilometer}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control datetimepicker-input in_time" id="in_time{{$row}}" name="entry[{{$row}}][in_time]" placeholder="In Time" data-toggle="datetimepicker" value="{{$daily_entry->in_time}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control datetimepicker-input out_time" id="out_time{{$row}}" name="entry[{{$row}}][out_time]" placeholder="Out Time" data-toggle="datetimepicker" value="{{$daily_entry->out_time}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control total_km" id="total_km{{$row}}" name="entry[{{$row}}][total_km]" value="{{$daily_entry->difference}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control extra_km" id="extra_km{{$row}}" name="entry[{{$row}}][extra_km]" value="{{$daily_entry->extra_km}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control extra_time" id="extra_time{{$row}}" name="entry[{{$row}}][extra_time]" value="{{$daily_entry->ot_hrs}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="remarks{{$row}}" name="entry[{{$row}}][remarks]" placeholder="Remarks" value="{{$daily_entry->remarks}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $row++; @endphp
                                @endforeach
                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-circle" id="add_more" name="add_more" onclick="addMoreEntryRow(event, this)">Add more</a>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script type="text/javascript">
    $(function(){
        $('.in_time').datetimepicker({
            'format': 'LT'
        });
        $('.out_time').datetimepicker({
            'format': 'LT'
        });
        $(document).on('keyup', '.starting_kilometer', function(){
            var starting = $(this).val();
            var closing = $(this).closest('.box').find('.closing_kilometer').val();
            var total_km = $(this).closest('.box').find('.total_km');
            var extra_km = $(this).closest('.box').find('.extra_km');
            $(total_km).val("");
            $(extra_km).val("");
            if(starting && closing) {
                diff = closing - starting;
                if (diff > 0) {
                    $(total_km).val(diff);
                }
                if ($("#category_id").val() != '3') {
                    var package_km = $("#package_km").val();
                    extra = diff - package_km;
                    if (extra > 0) {
                        $(extra_km).val(extra);
                    }
                }
            }
        });
        $(document).on('keyup', '.closing_kilometer', function(){
            var starting = $(this).closest('.box').find('.starting_kilometer').val();
            var closing = $(this).val();
            var total_km = $(this).closest('.box').find('.total_km');
            var extra_km = $(this).closest('.box').find('.extra_km');
            $(total_km).val("");
            $(extra_km).val("");
            if(starting && closing) {
                diff = closing - starting;
                if (diff > 0) {
                    $(total_km).val(diff);
                }
                if ($("#category_id").val() != '3') {
                    var package_km = $("#package_km").val();
                    extra = diff - package_km;
                    if (extra > 0) {
                        $(extra_km).val(extra);
                    }
                }
            }
        });
        $(".in_time").on("change.datetimepicker", function(e){
            var in_time = $(this).val();
            var out_time = $(this).closest('.box').find('.out_time').val();
            var package_hr = $("#package_hr").val();
            var extra_time = $(this).closest('.box').find('.extra_time');
            $(extra_time).val("");
            if(in_time && out_time && package_hr) {
                const d = new Date();
                var today = (d.getMonth()+1)+'/'+(d.getDate())+'/'+(d.getFullYear());
                var it = new Date(today+" "+in_time);
                var ot = new Date(today+" "+out_time);
                var diff = (ot - it) / 60000;
                var minutes = diff % 60;
                let min_hr = minutes / 60;
                let m = min_hr.toFixed(2);
                var hours = (diff - minutes) / 60;
                var extrahr = hours - package_hr;
                var extra = Number(extrahr) + Number(m);
                if (extra > 0) {
                    $(extra_time).val(extra);
                }
            }
        })
        $(".out_time").on("change.datetimepicker", function(e){
            var out_time = $(this).val();
            var in_time = $(this).closest('.box').find('.in_time').val();
            var package_hr = $("#package_hr").val();
            var extra_time = $(this).closest('.box').find('.extra_time');
            $(extra_time).val("");
            if(in_time && out_time && package_hr) {
                const d = new Date();
                var today = (d.getMonth()+1)+'/'+(d.getDate())+'/'+(d.getFullYear());
                var it = new Date(today+" "+in_time);
                var ot = new Date(today+" "+out_time);
                var diff = (ot - it) / 60000;
                var minutes = diff % 60;
                let min_hr = minutes / 60;
                let m = min_hr.toFixed(2);
                var hours = (diff - minutes) / 60;
                var extrahr = hours - package_hr;
                var extra = Number(extrahr) + Number(m);
                if (extra > 0) {
                    $(extra_time).val(extra);
                }
            }
        })
        $(document).on("click", "#btnsubmit", function(e) {
            $('#add-entries-form').valid();
            validateEntry();
        });
    });
    function validateEntry(){
        var entry = $('body').find('[name^="entry"]');
        entry.filter('input[name$="[starting_kilometer]"]').each(function() {
            $(this).rules("add", {
                digits: true,
                messages: {
                    digits: "only digits"
                }
            });
        });
        entry.filter('input[name$="[closing_kilometer]"]').each(function() {
            $(this).rules("add", {
                digits: true,
                messages: {
                    digits: "only digits"
                }
            });
        });
    }
    function addMoreEntryRow(event, element){
        let rowId = $(document).find('.box').length;
        let last_id = (rowId-1);
        var jdate = moment($("#journey_date"+last_id).val(), 'DD/MM/YYYY'); 
        var jd = moment(jdate).format("MM/DD/YYYY");
        var obj = new Date(jd);
        obj.setDate(obj.getDate() + 1);
        var newdate = moment(obj).format("DD/MM/YYYY");
        let html = `<div class="box box_${rowId}">`+
            `<div class="row">`+
                `<div class="col-md-2">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control" id="journey_date${rowId}" name="entry[${rowId}][journey_date]" placeholder="Date" value="${newdate}" readonly>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-1">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control starting_kilometer" id="starting_kilometer${rowId}" name="entry[${rowId}][starting_kilometer]" placeholder="Starting">`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-1">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control closing_kilometer" id="closing_kilometer${rowId}" name="entry[${rowId}][closing_kilometer]" placeholder="Closing">`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-1">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control datetimepicker-input in_time" id="in_time${rowId}" name="entry[${rowId}][in_time]" placeholder="In Time" data-toggle="datetimepicker">`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-1">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control datetimepicker-input out_time" id="out_time${rowId}" name="entry[${rowId}][out_time]" placeholder="Out Time" data-toggle="datetimepicker">`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-1">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control total_km" id="total_km${rowId}" name="entry[${rowId}][total_km]" readonly>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-1">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control extra_km" id="extra_km${rowId}" name="entry[${rowId}][extra_km]" readonly>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-1">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control extra_time" id="extra_time${rowId}" name="entry[${rowId}][extra_time]" readonly>`+
                    `</div>`+
                `</div>`+
                `<div class="col-md-3">`+
                    `<div class="form-group">`+
                        `<input type="text" class="form-control" id="remarks${rowId}" name="entry[${rowId}][remarks]" placeholder="Remarks">`+
                    `</div>`+
                `</div>`+
            `</div>`+
        `</div>`;
        $(element).before(html);
        $('.in_time').datetimepicker({
            'format': 'LT'
        });
        $('.out_time').datetimepicker({
            'format': 'LT'
        });
        $(".in_time").on("change.datetimepicker", function(e){
            var in_time = $(this).val();
            var out_time = $(this).closest('.box').find('.out_time').val();
            var package_hr = $("#package_hr").val();
            var extra_time = $(this).closest('.box').find('.extra_time');
            $(extra_time).val("");
            if(in_time && out_time && package_hr) {
                const d = new Date();
                var today = (d.getMonth()+1)+'/'+(d.getDate())+'/'+(d.getFullYear());
                var it = new Date(today+" "+in_time);
                var ot = new Date(today+" "+out_time);
                var diff = (ot - it) / 60000;
                var minutes = diff % 60;
                let min_hr = minutes / 60;
                let m = min_hr.toFixed(2);
                var hours = (diff - minutes) / 60;
                var extrahr = hours - package_hr;
                var extra = Number(extrahr) + Number(m);
                if (extra > 0) {
                    $(extra_time).val(extra);
                }
            }
        })
        $(".out_time").on("change.datetimepicker", function(e){
            var out_time = $(this).val();
            var in_time = $(this).closest('.box').find('.in_time').val();
            var package_hr = $("#package_hr").val();
            var extra_time = $(this).closest('.box').find('.extra_time');
            $(extra_time).val("");
            if(in_time && out_time && package_hr) {
                const d = new Date();
                var today = (d.getMonth()+1)+'/'+(d.getDate())+'/'+(d.getFullYear());
                var it = new Date(today+" "+in_time);
                var ot = new Date(today+" "+out_time);
                var diff = (ot - it) / 60000;
                var minutes = diff % 60;
                let min_hr = minutes / 60;
                let m = min_hr.toFixed(2);
                var hours = (diff - minutes) / 60;
                var extrahr = hours - package_hr;
                var extra = Number(extrahr) + Number(m);
                if (extra > 0) {
                    $(extra_time).val(extra);
                }
            }
        })
    }
</script>
@endsection