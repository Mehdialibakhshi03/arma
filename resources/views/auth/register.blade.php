@extends('home.homelayout.app')

@section('content')
    <div class="vh-100 d-flex justify-content-center">
        <div class="form-access my-auto">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <span>Create Account</span>
                <div class="form-group">
                    <input
                        id="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        placeholder="Full Name"
                        value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input
                        id="company_name"
                        type="text"
                        class="form-control @error('company_name') is-invalid @enderror"
                        name="company_name"
                        placeholder="Company Name"
                        value="{{ old('company_name') }}" required autofocus>

                    @error('company_name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input
                        id="field"
                        type="text"
                        class="form-control @error('field') is-invalid @enderror"
                        name="field"
                        placeholder="Field"
                        value="{{ old('field') }}" required autofocus>

                    @error('field')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <select
                        id="type"
                        type="text"
                        class="form-control @error('type') is-invalid @enderror"
                        name="type">
                        <option value="">Select User Type</option>
                        @foreach($types as $type)
                            <option {{ old('type')==$type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>

                    @error('type')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>


                <div class="form-group">
                    <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email Address"
                        required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input
                        id="mobile_number"
                        type="text"
                        class="form-control @error('mobile_number') is-invalid @enderror"
                        name="mobile_number"
                        placeholder="Mobile Number"
                        value="{{ old('mobile_number') }}"
                        required>
                    @error('mobile_number')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                {{--                <div class="custom-control custom-checkbox">--}}
                {{--                    <input type="checkbox" class="custom-control-input" id="form-checkbox">--}}
                {{--                    <label class="custom-control-label" for="form-checkbox">I agree to the <a href="#!">Terms &--}}
                {{--                            Conditions</a></label>--}}
                {{--                </div>--}}
                <button type="submit" class="btn btn-primary">{{ __('Create Account') }}</button>
            </form>
            <h2>Already have an account? <a href='{{ route('login') }}'>Sign in here</a></h2>
        </div>
    </div>
@endsection
