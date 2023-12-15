@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Contact</div>
            <div class="card-body">
                <form action="{{ route('customerUpdate') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email</label>
                        <div class="col-md-6">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" name="email" value="{{ $customerInfo['email'] }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">First Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" id="firstname" value="{{ ($customerInfo['firstname'])?$customerInfo['firstname']:old('firstname') }}">
                            @if ($errors->has('firstname'))
                                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Last Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" id="lastname" value="{{ ($customerInfo['lastname'])?$customerInfo['lastname']:old('lastname') }}">
                            @if ($errors->has('lastname'))
                                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Company Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" id="company" value="{{ ($customerInfo['company'])?$customerInfo['company']:old('company') }}">
                            @if ($errors->has('company'))
                                <span class="text-danger">{{ $errors->first('company') }}</span>
                            @endif
                        </div>
                    </div>
                    <input type="text" name="customerid" value="{{ $customerInfo['customerid'] }}" style="display:none">  
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Contact">
                    </div>                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection
