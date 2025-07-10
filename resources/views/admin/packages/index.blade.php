@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Packages</h1>
                        <a href="{{route('admin.packages.add')}}" class="btn btn-primary">Add New Package</a>
                    </div>
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
                            <h3 class="card-title">All Packages</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="100">Action</th>
                                            <th>Package Name</th>
                                            <th>Category Name</th>
                                            <th>Rate</th>
                                            <th>Extra KM Rate</th>
                                            <th>Extra HR Rate</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Package Name</th>
                                            <th>Category Name</th>
                                            <th>Rate</th>
                                            <th>Extra KM Rate</th>
                                            <th>Extra HR Rate</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($packages as $package)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{route('admin.packages.edit', ['id' => $package->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('admin.packages.delete', ['id' => $package->id])}}" class="btn btn-outline-danger btn-circle btn-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>{{$package->name}}</td>
                                                <td>{{$package->categories->name}}</td>
                                                <td>{{$package->rate}}</td>
                                                <td>{{$package->ex_km_rate}}</td>
                                                <td>{{$package->ex_hr_rate}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script type="text/javascript">
    $(function(){
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