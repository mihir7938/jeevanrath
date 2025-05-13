@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Vendors</h1>
                        <a href="{{route('admin.vendors.add')}}" class="btn btn-primary">Add New Vendor</a>
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
                            <h3 class="card-title">All Vendors</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="100">Action</th>
                                            <th>Vendor Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Vendor Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($vendors as $vendor)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{route('admin.users.change', ['id' => $vendor->user_id])}}" class="btn btn-outline-dark btn-circle">
                                                        <i class="fas fa-unlock"></i>
                                                    </a>
                                                    <a href="{{route('admin.vendors.edit', ['id' => $vendor->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('admin.vendors.delete', ['id' => $vendor->id])}}" class="btn btn-outline-danger btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td>{{$vendor->name}}</td>
                                                <td>{{$vendor->mobile_number}}</td>
                                                <td>{{$vendor->email}}</td>
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