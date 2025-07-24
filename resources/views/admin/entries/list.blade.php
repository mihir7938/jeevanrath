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
                    <form method="POST" action="{{route('admin.entries.fetch')}}" class="form" id="fetch-entries-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="enquiry_id" value="{{$enquiry->id}}" />
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Search</button>
                            </div>
                        </div>
                    </form>
                    <div id="search_result">
                        @include('admin.entries.fetch-result', ['daily_entries' => $daily_entries, 'difference' => $difference, 'extra_km' => $extra_km, 'extra_ot' => $extra_ot])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script type="text/javascript">
    $(function(){
        $("#start_date").datepicker({
            'format': 'dd/mm/yyyy',
            'autoclose': true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', minDate);
            $(this).valid();
        });
        $("#end_date").datepicker({
            'format': 'dd/mm/yyyy',
            'autoclose': true
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', maxDate);
            $(this).valid();
        });
        $('#fetch_entry_data').DataTable({
            "buttons": [
                {
                    extend: 'excel',
                    footer: true,
                }
            ],
            "responsive": true,
            "pageLength": 100
        }).buttons().container().appendTo('#fetch_entry_data_wrapper .col-md-6:eq(0) label');
        $('#fetch-entries-form').validate({
            rules:{
                start_date:{
                    required:function(){
                        if($('#end_date').val()!='') {
                            return true;
                        }
                        return false;
                    },
                },
                end_date:{
                    required:function(){
                        if($('#start_date').val()!='') {
                            return true;
                        }
                        return false;
                    },
                }
            },
            messages:{
                start_date:{
                    required: "Please select start date."
                },
                end_date:{
                    required: "Please select end date."
                }
            },
            submitHandler: function (form) {
                url = "{{ route('admin.entries.fetch') }}";
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append + $('#fetch-entries-form').serialize();
                $('.loader').show();
                $.get(finalURL, function(data) {
                    $('.loader').hide();
                    $("#search_result").html('');
                    $('#search_result').append(data);
                    $('#fetch_entry_data').DataTable({
                        "buttons": [
                            {
                                extend: 'excel',
                                footer: true,
                            }
                        ],
                        "destroy": true,
                        "responsive": true,
                        "pageLength": 100
                    }).buttons().container().appendTo('#fetch_entry_data_wrapper .col-md-6:eq(0) label');
                });
            }
        });
    });
</script>
@endsection