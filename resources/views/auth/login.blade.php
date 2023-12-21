@extends('home.homelayout.app')

@section('content')
    <div class="vh-100 d-flex justify-content-center">
        <div class="form-access my-auto">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <span>Sign In</span>
                <div class="form-group">
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}"
                           placeholder="{{ __('Email Address') }}"
                           required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input
                        id="password"
                        type="password"
                        placeholder="{{ __('Password') }}"
                        class="form-control @error('password') is-invalid @enderror" name="password"
                        required
                        autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                @if (Route::has('password.request'))
                    <div class="text-right">
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif
                <div class="custom-control custom-checkbox">
                    <input {{ old('remember') ? 'checked' : '' }} type="checkbox" name="remember" id="remember"  class="custom-control-input">
                    <label class="custom-control-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Sign In') }}
                </button>
            </form>
            <h2>Don't have an account? <a href='{{ route('register') }}'>Sign up here</a></h2>
        </div>
    </div>

@endsection
