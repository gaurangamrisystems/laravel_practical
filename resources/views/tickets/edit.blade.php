@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Ticket</div>
            <div class="card-body">
                <form action="{{ route('ticketUpdate') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Product Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ $ticketInfo['subject'] }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="content" class="col-md-4 col-form-label text-md-end text-start">Product content</label>
                        <div class="col-md-6">
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror">{{ ($ticketInfo['content'])?$ticketInfo['content']:old('content') }}</textarea>
                            @if ($errors->has('content'))
                                <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif
                        </div>
                    </div>
                    <input type="text" name="ticketid" value="{{ $ticketInfo['ticketid'] }}" style="display:none">
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Ticket">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection