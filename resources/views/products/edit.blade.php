@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Product</div>
            <div class="card-body">
                <form action="{{ route('productUpdate') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Product Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $productInfo['name'] }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Product Description</label>
                        <div class="col-md-6">
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ ($productInfo['description'])?$productInfo['description']:old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">Product Price</label>
                        <div class="col-md-6">
                          <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ ($productInfo['price'])?$productInfo['price']:old('price') }}" pattern="[0-9]*" oninput="validateInput(this)">
                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>
                    <input type="text" name="productid" value="{{ $productInfo['productId'] }}" style="display:none">
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Product">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection