@if(session()->exists('success'))
    <div class="alert alert-success text-center mt-2 mb-2 message_box">
        {{ session('success') }}
    </div>
@endif
@if(session()->exists('failed'))
    <div class="alert alert-danger text-center mt-2 mb-2 message_box">
        {{ session('failed') }}
    </div>
@endif
