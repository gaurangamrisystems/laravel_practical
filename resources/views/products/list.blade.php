@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        @include('products.delete')
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('message')
                    <div id="result"></div>
                    <a href="{{ url('product/create') }}" class="edit btn btn-success btn-sm">Create Product</a>
                    <br>
                    <br>
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
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