@extends('layouts.app')
@section('content')
    <div class="container-fluid about bg-light py-5 mt-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 wow fadeInTop" data-wow-delay="0.2s">
                    <div class="search-form rounded p-5 mt-4">
                        <h4 class="display-7 mb-4 text-center">Search Rental Cars/Cabs</h4>
                        <form method="POST" action="{{route('search_rental')}}" class="search_form" id="search_form">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <select id="state" name="state" class="form-select py-2 border-primary bg-transparent">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <select id="city" name="city" class="form-select py-2 border-primary bg-transparent">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <select id="type" name="type" class="form-select py-2 border-primary bg-transparent">
                                        <option value="">Select Type</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <select id="vehicle_name" name="vehicle_name" class="form-select py-2 border-primary bg-transparent">
                                        <option value="">Select Vehicle</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary text-white w-100 py-2 px-5">SEARCH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
        <div id="search_result">
            @include("search.rental", ['vehicle_details' => $vehicle_details])
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
            var newdata1 = '<option value="">Select City</option>';
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
            var newdata1 = '<option value="">Select Vehicle</option>';
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
        $('#search_form').submit(function(e){
            e.preventDefault();
            $("#search_result").html('');
            popoluteResults("{{ route('get_rental_results') }}");
        });
    });
    function popoluteResults(url){
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append + $('#search_form').serialize();
        //window.history.pushState({}, null, finalURL);
        $('#spinner').addClass('show');
        $.get(finalURL, function(data) {
            $('#spinner').removeClass('show');
            $('#search_result').append(data);
        });
    }
</script>
@endsection