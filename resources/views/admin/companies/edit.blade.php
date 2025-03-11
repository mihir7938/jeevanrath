@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Companies</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('admin.companies.update.save')}}" class="form" id="edit-companies-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$company->id}}" />
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
                                <h3 class="card-title">Edit Company</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Company Name*</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Company Name" value="{{$company->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="db_name">Database Name*</label>
                                            <input type="text" class="form-control" id="db_name" name="db_name" placeholder="Database Name" value="{{$company->db_name}}">
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
        $('#edit-companies-form').validate({
            rules:{
                name: {
                    required: true
                },
                db_name: {
                    required: true
                }
            },
            messages:{
                name:{
                    required: "Please enter company name."
                },
                db_name:{
                    required: "Please enter database name."
                }
            }
        });
    });
</script>
@endsection