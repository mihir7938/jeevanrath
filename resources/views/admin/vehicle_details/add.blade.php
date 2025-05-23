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
                category:{
                    required: true
                },
                type:{
                    required:function(){
                        if($('#category').val() == 1){
                            return true;
                        }
                        return false;
                    }
                },
                vehicle_name:{
                    required:function(){
                        if($('#category').val() == 1){
                            return true;
                        }
                        return false;
                    }
                },
                rate: {
                    required:function(){
                        if($('#category').val() == 1){
                            return true;
                        }
                        return false;
                    },
                    digits: true
                },
                taxi_doors: {
                    required:function(){
                        if($('#category').val() == 1){
                            return true;
                        }
                        return false;
                    },
                    digits: true
                },
                passengers: {
                    required:function(){
                        if($('#category').val() == 1){
                            return true;
                        }
                        return false;
                    },
                    digits: true
                },
                luggage_carry: {
                    required:function(){
                        if($('#category').val() == 1){
                            return true;
                        }
                        return false;
                    },
                    digits: true
                },
                image: {
                    required:function(){
                        if($('#category').val() == 1){
                            return true;
                        }
                        return false;
                    },
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                },
                origin_trip:{
                    required:function(){
                        if($('#category').val() == 2){
                            return true;
                        }
                        return false;
                    }
                },
                return_trip:{
                    required:function(){
                        if($('#category').val() == 2){
                            return true;
                        }
                        return false;
                    }
                },
                vehicle1:{
                    required:function(){
                        if($('#category').val() == 2){
                            return true;
                        }
                        return false;
                    }
                },
                rate1:{
                    required:function(){
                        if($('#category').val() == 2){
                            return true;
                        }
                        return false;
                    }
                },
                image1:{
                    required:function(){
                        if($('#category').val() == 2){
                            return true;
                        }
                        return false;
                    },
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                },
                image2:{
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                },
                image3:{
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                },
                image4:{
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                },
                image5:{
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
                category:{
                    required: "Please select category."
                },
                type:{
                    required: "Please select vehicle type."
                },
                vehicle_name:{
                    required: "Please select vehicle name."
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
                },
                origin_trip:{
                    required: "Please enter origin trip."
                },
                return_trip:{
                    required: "Please enter return trip."
                },
                vehicle1:{
                    required: "Please enter vehicle name/type."
                },
                rate1:{
                    required: "Please enter rate."
                },
                image1: {
                    required: "Please select image.",
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                },
                image2: {
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                },
                image3: {
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                },
                image4: {
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                },
                image5: {
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "image" ) {
                    $(".input-group").after(error);
                } else if (element.attr("name") == "image1" ) {
                    $(".input-group1").after(error);
                } else if (element.attr("name") == "image2" ) {
                    $(".input-group2").after(error);
                } else if (element.attr("name") == "image3" ) {
                    $(".input-group3").after(error);
                } else if (element.attr("name") == "image4" ) {
                    $(".input-group4").after(error);
                } else if (element.attr("name") == "image5" ) {
                    $(".input-group5").after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection