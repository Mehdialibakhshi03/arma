@php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
@endphp
@extends('layouts.app')
@section('title', __('Send Mail'))
@section('content')
    <div class="card-body">
        <div class="">
            <h2 class="mb-3 f-w-600">{{ __('Email verify') }}</h2>
        </div>
        <div class="">
            {{ Form::open(['route' => ['password.email'], 'method' => 'POST', 'data-validate']) }}
            <div class="form-group mb-3">
                {{ Form::label('email', __('Email Address'), ['class' => 'form-label']) }}
                {!! Form::email('email', null, [
                    'class' => 'form-control',
                    'id' => 'email',
                    'required',
                    'placeholder' => __('Enter email address'),
                    'onfocus',
                ]) !!}
            </div>
            @if (Utility::getsettings('login_recaptcha_status') == '1')
                <div class="text-center">
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                </div>
            @endif
            <br>
            <div class="text-center">
                {!! Form::submit(__('Forgot Password'), ['class' => 'btn btn-primary']) !!}
                {!! Html::link(route('login'), __('Back'), ['class' => 'btn btn-secondary text-white']) !!}
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
