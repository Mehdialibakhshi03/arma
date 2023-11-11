@extends('layouts.app')
@section('title', __('Reset Password'))
@section('content')
    <div class="card">
        <div class="card-body mx-auto">
            <div class="">
                <h4 class="text-primary mb-3">{{ __('Reset Password') }}</h4>
            </div>
            <div class="text-start">

                {{ Form::open(['route' => ['password.update'], 'method' => 'POST','data-validate']) }}
                {!! Form::hidden('token', $token, ['class' => 'form-control']) !!}
                <div class="form-group mb-3">
                    {{ Form::label('email', __('E-Mail Address'), ['class' => 'form-label mb-2']) }}
                    {!! Form::email('email', $email ?? old('email'), [
                        'class' => 'form-control',
                        'id' => 'email',
                        'required',
                        'placeholder' => __('E-Mail Address'),
                        'autocomplete' => 'email',
                        'onfocus',
                    ]) !!}
                </div>
                <div class="form-group mb-3">
                    {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'placeholder' => __('Password'),
                        'required',
                        'id' => 'password',
                        'autocomplete' => 'new-password',
                    ]) !!}
                </div>
                <div class="form-group mb-3">
                    {{ Form::label('password_confirmation', __('Confirm Password'), ['class' => 'form-label']) }}
                    {!! Form::password('password_confirmation', [
                        'class' => 'form-control',
                        'placeholder' => __('Confirm Password'),
                        'required',
                        'id' => 'password-confirm',
                        'autocomplete' => 'new-password',
                    ]) !!}
                </div>
                <div class="d-grid">
                    {!! Form::submit(__('Reset Password'), ['class' => 'btn btn-primary btn-block mt-2']) !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
