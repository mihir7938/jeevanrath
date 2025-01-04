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
                    <form method="POST" action="{{route('admin.details.add.save')}}" class="form" id="add-details-form" enctype="multipart/form-data">
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
                        <div class="card card-light">
                            <div class="card-header">
                                <h3 class="card-title">Add Vehicle</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State*</label>
                                            <select id="state" name="state" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City*</label>
                                            <select id="city" name="city" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                                            <label for="category">Category*</label>
                                            <select id="category" name="category" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="vehicle_details">
                            @include('admin.vehicle_details.details-form', ['category_id' => $category_id])
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
        $(document).on('change','#state',function() {
            var state_value = $(this).val();
            var appendElement = $("#city");
            appendElement.empty();
            var newdata1 = '<option value="">Select</option>';
            $(newdata1).appendTo(appendElement);        
            $.ajax({
                url: "{{ route('get_cities') }}",
                type: 'get',
                data: {
                    'state_id' : state_value
                },
                dataType: 'json',
                success:function(response){
                    if(response.status){
                        $.each(response.cities, function(i,result){
                            newdata = "<option value='"+result.id+"'>"+result.name+"</option>";
                            $(newdata).appendTo(appendElement);
                        });
                    }
                }
            });
        });
        $(document).on('change','#type',function() {
            var type_value = $(this).val();
            var appendElement = $("#vehicle_name");
            appendElement.empty();
            var newdata1 = '<option value="">Select</option>';
            $(newdata1).appendTo(appendElement);        
            $.ajax({
                url: "{{ route('get_vehicles') }}",
                type: 'get',
                data: {
                    'type_id' : type_value
                },
                dataType: 'json',
                success:function(response){
                    if(response.status){
                        $.each(response.vehicles, function(i,result){
                            newdata = "<option value='"+result.id+"'>"+result.name+"</option>";
                            $(newdata).appendTo(appendElement);
                        });
                    }
                }
            });
        });
        $(document).on('change', '#category', function(){
            $('.loader').show();
            $.ajax({
                url: "{{ route('admin.details.fetch') }}",
                method: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                  'category_id' : $(this).val(),
                },
                success: function (data) {
                  $('.loader').hide();
                  $("#vehicle_details").html('');
                  $("#vehicle_details").show();
                  $('#vehicle_details').append(data);
                  bsCustomFileInput.init();
                },
            });
        });
        $('#add-details-form').validate({
            rules:{
                state:{
                    required: true
                },
                city:{
                    required: true
                },
                type:{
                    required: true
                },
                vehicle_name:{
                    required: true
                },
                category:{
                    required: true
                },
                rate: {
                    required: true,
                    digits: true
                },
                taxi_doors: {
                    required: true,
                    digits: true
                },
                passengers: {
                    required: true,
                    digits: true
                },
                luggage_carry: {
                    required: true,
                    digits: true
                },
                image: {
                    required: true,
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                }
            },
            messages:{
                state:{
                    required: "Please select state."
                },
                city:{
                    required: "Please select city."
                },
                type:{
                    required: "Please select vehicle type."
                },
                vehicle_name:{
                    required: "Please select vehicle name."
                },
                category:{
                    required: "Please select category."
                },
                rate:{
                    required: "Please enter rate."
                },
                taxi_doors:{
                    required: "Please enter total taxi doors."
                },
                passengers:{
                    required: "Please enter total passengers."
                },
                luggage_carry:{
                    required: "Please enter total carry luggage."
                },
                image: {
                    required: "Please select image.",
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "image" ) {
                    $(".input-group").after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection