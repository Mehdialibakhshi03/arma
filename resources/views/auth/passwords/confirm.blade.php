@extends('layouts.app')
@section('title', __('Confirm Password'))

@section('content')
    <div class="card">
        <div class="card-body mx-auto">
            <div class="">
                <h4 class="text-primary mb-3">{{ __('Confirm Password') }}</h4>
            </div>
            <div class="text-start">
                {{ Form::open(['route' => ['password.confirm'], 'method' => 'POST','data-validate']) }}

                <div class="form-group mb-3">
                    {{ Form::label('password', __('Password'), ['class' => 'form-label mb-2']) }}
                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'placeholder' => __('Password'),
                        'required',
                        'id' => 'password',
                        'autocomplete' => 'current-password',
                    ]) !!}
                </div>

                <div class="d-grid">
                    {!! Form::submit(__('Confirm Password'), ['class' => 'btn btn-primary btn-block mt-2']) !!}
                    @if (Route::has('password.request'))
                        {!! Html::link(route('password.request'),__('Forgot Your Password?'),['class'=>'btn btn-link']) !!}
                    @endif
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
