@extends('layouts.app')
@section('title', __('Verify Email'))
@section('content')
    <div class="card">
        <div class="card-body mx-auto">
            <div class="">
                <h4 class="text-primary mb-3">{{ __('Verify Your Email Address') }}</h4>
            </div>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <div class="text-start">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                {{ Form::open(['route' => ['verification.resend'], 'method' => 'POST', 'class' => 'd-inline']) }}
                {!! Form::submit(__('click here to request another'), ['class' => 'btn btn-link p-0 m-0 align-baseline']) !!}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
