@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jeevan Rath Vehicles</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.jrvehicles.update.save')}}" class="form" id="edit-jrvehicles-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$jrvehicle->id}}" />
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
                                <h3 class="card-title">Edit Vehicle</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_name">Vehicle Name*</label>
                                            <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" placeholder="Vehicle Name" value="{{$jrvehicle->vehicle_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="owner_name">Owner Name*</label>
                                            <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Owner Name" value="{{$jrvehicle->owner_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Mobile Number*</label>
                                            <input type="phone" class="form-control" id="phone" name="phone" placeholder="Mobile Number" value="{{$jrvehicle->mobile_number}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alternative_number">Alternative Number</label>
                                            <input type="phone" class="form-control" id="alternative_number" name="alternative_number" placeholder="Alternative Number" value="{{$jrvehicle->alternative_number}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State*</label>
                                            <select id="state" name="state" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" @if($jrvehicle->cities->state_id == $state->id) selected @endif>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City*</label>
                                            @if($jrvehicle->city_id)
                                                <select id="city" name="city" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" @if($jrvehicle->city_id == $city->id) selected @endif>{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select id="city" name="city" class="form-control">
                                                    <option value="">Select</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_number">Vehicle Number*</label>
                                            <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" placeholder="Vehicle Number" oninput="this.value = this.value.toUpperCase()" value="{{$jrvehicle->vehicle_number}}">
                                        </div>
                                    </div>
                                </div>
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
        $.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0; 
        });
        $.validator.addMethod("alphaNumeric", function(value, element) {
            return this.optional(element) || /^[a-z0-9\s]+$/i.test(value);
        });
        $('#edit-jrvehicles-form').validate({
            rules:{
                vehicle_name:{
                    required: true
                },
                owner_name: {
                    required: true
                },
                phone: {
                    required: true,
                    digits: true,
                },
                alternative_number: {
                    digits: true,
                },
                state:{
                    required: true
                },
                city:{
                    required: true
                },
                vehicle_number: {
                    required: true,
                    noSpace: true,
                    alphaNumeric: true
                }
            },
            messages:{
                vehicle_name:{
                    required: "Please enter vehicle name."
                },
                owner_name:{
                    required: "Please enter owner name."
                },
                phone:{
                    required: "Please enter mobile number."
                },
                state:{
                    required: "Please select state."
                },
                city:{
                    required: "Please select city."
                },
                vehicle_number:{
                    required: "Please enter vehicle number.",
                    noSpace: "Space not allowed",
                    alphaNumeric: "Please enter only letters and numbers.",
                }
            }
        });
    });
</script>
@endsection