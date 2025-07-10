@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Assign Packages</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.packages.assign.update')}}" class="form" id="edit-packages-form" enctype="multipart/form-data">
                        @csrf
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
                                <h3 class="card-title">Companies</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <select id="company" name="company" class="form-control">
                                                <option value="">Select Company Name</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->id}}">{{$account->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="search_result" class="hidden">
                            @include('admin.assign_packages.result', ['packages' => $packages])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(function () {
        $(document).on('change', '#company', function(){
            $('.loader').show();
            $.ajax({
                url: "{{ route('admin.packages.fetch') }}",
                method: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                  'company_id' : $(this).val(),
                },
                success: function (data) {
                    $('.loader').hide();
                    $("#search_result").show();
                    $("#search_result").html('');
                    $('#search_result').append(data);
                },
            });
        });
        $(document).on("click", "#btnsubmit", function(e) {
            $('#edit-packages-form').validate({
                rules:{
                    company: {
                        required: true
                    }
                },
                messages:{
                    company:{
                        required: "Please select company name."
                    }
                }
            });
            validatePackage();
        });
    });
    function validatePackage(){
        var package = $('body').find('[name^="package"]');
        package.filter('input[name$="[rate]"]').each(function() {
            $(this).rules("add", {
                required: true,
                digits: true,
                messages: {
                    required: "Please enter rate"
                }
            });
        });
        package.filter('input[name$="[ex_km_rate]"]').each(function() {
            $(this).rules("add", {
                required: true,
                digits: true,
                messages: {
                    required: "Please enter ex km rate"
                }
            });
        });
        package.filter('input[name$="[ex_hr_rate]"]').each(function() {
            $(this).rules("add", {
                required: true,
                digits: true,
                messages: {
                    required: "Please enter ex hr rate"
                }
            });
        });
    }
</script>
@endsection