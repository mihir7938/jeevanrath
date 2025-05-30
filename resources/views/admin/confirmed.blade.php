@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Confirm Inquiries</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.inquiries.fetch')}}" class="form" id="fetch-inquiries-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="status[]" value="2" />
                        <input type="hidden" name="status[]" value="3" />
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
                        @include('admin.search-result', ['enquiries' => $enquiries])
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
        $('#fetch_inquiry_data').DataTable({
            "buttons": ["csv", "excel"],
            "responsive": true,
        }).buttons().container().appendTo('#fetch_inquiry_data_wrapper .col-md-6:eq(0) label');
        $('#fetch-inquiries-form').validate({
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
                url = "{{ route('admin.inquiries.fetch') }}";
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append + $('#fetch-inquiries-form').serialize();
                $('.loader').show();
                $.get(finalURL, function(data) {
                    $('.loader').hide();
                    $("#search_result").html('');
                    $('#search_result').append(data);
                    $('#fetch_inquiry_data').DataTable({
                        "buttons": ["csv", "excel"],
                        "destroy": true,
                        "responsive": true,
                    }).buttons().container().appendTo('#fetch_inquiry_data_wrapper .col-md-6:eq(0) label');
                });
            }
        }); 
        $('.btn-delete').on('click',function(e){
            e.preventDefault();
            var url = e.currentTarget.getAttribute('href')
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href=url;
                }
            });
        });
    });
</script>
@endsection