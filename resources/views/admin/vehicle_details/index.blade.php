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
                    @include('shared.alert')
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Category</h3>
                        </div>
                        <div class="card-body">
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
                    <div id="vehicle_list">
                        @include('admin.vehicle_details.list', ['category_id' => $category_id, 'vehicles' => $vehicles])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(function () {
        $(document).on('change', '#category', function(){
            $('.loader').show();
            $.ajax({
                url: "{{ route('admin.list.fetch') }}",
                method: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                  'category_id' : $(this).val(),
                },
                success: function (data) {
                    $('.loader').hide();
                    $("#vehicle_list").html('');
                    $("#vehicle_list").show();
                    $('#vehicle_list').append(data);
                    $('#dataTableVehicle').DataTable({
                        "paging": true,
                        "ordering": false,
                        "responsive": true,
                    });
                },
            });
        });
    });
</script>
@endsection