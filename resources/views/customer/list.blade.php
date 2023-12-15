@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        @include('customer.delete')
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('message')
                    <div id="result"></div>
                    <a href="{{ url('customer/create') }}" class="edit btn btn-success btn-sm">Create Contact</a>
                    <br>
                    <br>
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Company Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>    
    </div>
@endsection