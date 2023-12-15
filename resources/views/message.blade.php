@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@else
    <div class="alert alert-error">
        {{ Session::get('error') }}
    </div>       
@endif      