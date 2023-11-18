@extends('admin.layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10">{{ __('Edit Form') }}</h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.forms.index') }}">{{ __('Forms') }}</a></li>
                    <li class="breadcrumb-item"> {{ __('Edit Form') }} </li>
                </ul>
            </div>
            <div class="float-end">
                <div class="d-flex align-items-center">
                    <a href="@if (!empty($previous)) {{ route('admin.forms.edit', [$previous->id]) }}@else javascript:void(0) @endif"
                        type="button" class="btn btn-outline-primary"><i class="me-2"
                            data-feather="chevrons-left"></i>Previous</a>
                    <a href="@if (!empty($next)) {{ route('admin.forms.edit', [$next->id]) }}@else javascript:void(0) @endif"
                        class="btn btn-outline-primary ms-1"><i class="me-2" data-feather="chevrons-right"></i>Next</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        {{ Form::model($form, ['route' => ['admin.forms.update', $form->id], 'data-validate', 'method' => 'PUT', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('General') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('title', __('Title of form'), ['class' => 'form-label']) }}
                            {!! Form::text('title', $form->title, [
                                'class' => 'form-control',
                                'id' => 'password',
                                'placeholder' => __('Enter title of form'),
                            ]) !!}
                            @if ($errors->has('form'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('form') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            @if ($form->logo)
                                <div class="form-group text-center">
                                    {!! Form::image(
                                        Storage::exists($form->logo) ? asset('storage/app/' . $form->logo) : Storage::url('uploads/appLogo/78x78.png'),
                                        null,
                                        [
                                            'class' => 'img img-responsive justify-content-center text-center form-img',
                                            'id' => 'app-dark-logo',
                                        ],
                                    ) !!}
                                </div>
                            @endif
                            <div class="form-group">
                                {{ Form::label('form_logo', __('Select Logo'), ['class' => 'form-label']) }}
                                {!! Form::file('form_logo', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('success_msg', __('Success Message'), ['class' => 'form-label']) }}
                                {!! Form::textarea('success_msg', $form->success_msg, [
                                    'id' => 'success_msg',
                                    'placeholder' => __('Enter success message'),
                                    'class' => 'form-control',
                                ]) !!}
                                @if ($errors->has('success_msg'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('success_msg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('thanks_msg', __('Thanks Message'), ['class' => 'form-label']) }}
                                {!! Form::textarea('thanks_msg', $form->thanks_msg, [
                                    'id' => 'thanks_msg',
                                    'placeholder' => __('Enter client message'),
                                    'class' => 'form-control',
                                ]) !!}
                                @if ($errors->has('thanks_msg'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('thanks_msg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('assignform', __('Assign Form'), ['class' => 'form-label']) }}
                                <div class="assignform" id="assign_form">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    {!! Form::label('assign_type_role', __('Role'), ['class' => 'form-label']) !!}
                                                    <label class="form-switch   custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'role', $form_role ? true : false, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_role',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                                <div>
                                                    {!! Form::label('assign_type_user', __('User'), ['class' => 'form-label tesk-1']) !!}
                                                    <label class="form-switch   custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'user', $form_user ? true : false, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_user',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                                <div>
                                                    {!! Form::label('assign_type_public', __('Public'), ['class' => 'form-label tesk-1']) !!}
                                                    <label class="form-switch custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'public', null, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_public',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="role" class="desc {{ $formRole ? 'd-block' : 'd-none' }}">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            {{ Form::label('roles', __('Role'), ['class' => 'form-label']) }}
                                                            <select name="roles[]" class="form-select" multiple
                                                                id="choices-multiple-remove-button">
                                                                @foreach ($form_role as $k => $role)
                                                                    <option value="{{ $k }}"
                                                                        {{ in_array($k, $formRole) ? 'selected' : '' }}>
                                                                        {{ $role }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="user" class="desc {{ $formUser ? 'd-block' : 'd-none' }}">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            {{ Form::label('users', __('User'), ['class' => 'form-label']) }}
                                                            <select name="users[]" class="form-select" multiple
                                                                id="choices-multiples-remove-button">
                                                                @foreach ($form_user as $key => $user)
                                                                    <option value="{{ $key }}"
                                                                        {{ in_array($key, $formUser) ? 'selected' : '' }}>
                                                                        {{ $user }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('allow_comments', __('Allow comments'), ['class' => 'form-label']) }}
                                <label class="form-switch mt-2 float-end custom-switch-v1">
                                    <input type="checkbox" name="allow_comments" id="allow_comments"
                                        class="form-check-input input-primary"
                                        {{ $form->allow_comments == 1 ? 'checked' : 'unchecked' }}>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('allow_share_section', __('Allow Share Section'), ['class' => 'form-label']) }}
                                <label class="form-switch mt-2 float-end custom-switch-v1">
                                    <input type="checkbox" name="allow_share_section" id="allow_share_section"
                                        class="form-check-input input-primary"
                                        {{ $form->allow_share_section == 1 ? 'checked' : 'unchecked' }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Email Setting') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('email[]', __('Recipient Email'), ['class' => 'form-label']) }}
                                {!! Form::text('email[]', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter recipient email'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('ccemail[]', __('Enter cc emails (Optional)'), ['class' => 'form-label']) }}
                                {!! Form::text('ccemail[]', null, [
                                    'class' => 'form-control inputtags',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('bccemail[]', __('Enter bcc emails (Optional)'), ['class' => 'form-label']) }}
                                {!! Form::text('bccemail[]', null, [
                                    'class' => 'form-control inputtags',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Payment Setting') }}</h5>
                    </div>
                    <div class="card-body">
                        @if (Auth::user()->type == 'Admin')
                            @if ($payment_type)
                                <div class="row">
                                    <div class="col-md-8">
                                        <b>
                                            {{ Form::label('customswitchv1-1', __('Payment getway (active)'), ['class' => 'd-block']) }}
                                        </b>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check form-switch custom-switch-v1 float-end">
                                            {!! Form::checkbox('payment', null, $form->payment_status == '1' ? true : false, [
                                                'id' => 'customswitchv1-1',
                                                'class' => 'form-check-input input-primary',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div
                                        class="col-lg-12 paymenttype {{ $form->payment_status == '1' ? 'd-block' : 'd-none' }}">
                                        <div class="form-group">
                                            {{ Form::label('payment_type', __('Payment Type'), ['class' => 'form-label']) }}
                                            {!! Form::select('payment_type', $payment_type, $form->payment_type, [
                                                'class' => 'form-control',
                                                'data-trigger',
                                            ]) !!}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('amount', __('Amount'), ['class' => 'form-label']) }}
                                            {!! Form::number('amount', $form->amount, [
                                                'id' => 'amount',
                                                'placeholder' => __('Enter amount'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('currency_symbol', __('Currency symbol'), ['class' => 'form-label']) }}
                                            {!! Form::text('currency_symbol', $form->currency_symbol, [
                                                'id' => 'currency_symbol',
                                                'placeholder' => __('Enter currency symbol'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @if ($errors->has('currency_symbol'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('currency_symbol') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('currency_name', __('Currency Name'), ['class' => 'form-label']) }}
                                            {!! Form::text('currency_name', $form->currency_name, [
                                                'id' => 'currency_name',
                                                'placeholder' => __('Enter currency name'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            <p>{{ __('The name of currency is to be taken frome this document.') }}
                                                {!! Html::link('https://stripe.com/docs/currencies', __('Document'), ['target' => '_blank', 'class' => 'm-2']) !!}
                                            </p>
                                            @if ($errors->has('currency_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('currency_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            {!! Html::link(route('admin.forms.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                            {!! Form::submit(__('Save'), ['class' => 'form_payment btn btn-primary ']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );
        var multipleCancelButton = new Choices(
            '#choices-multiples-remove-button', {
                removeItemButton: true,
            }
        );
        $(".inputtags").tagsinput('items');
    </script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).on('click', "input[name$='payment']", function() {
            if (this.checked) {
                $('#payment').fadeIn(500);
                $("#payment").removeClass('d-none');
                $("#payment").addClass('d-block');
            } else {
                $('#payment').fadeOut(500);
                $("#payment").removeClass('d-block');
                $("#payment").addClass('d-none');
            }
        });
        $(document).on('click', "#customswitchv1-1", function() {
            if (this.checked) {
                $(".paymenttype").fadeIn(500);
                $('.paymenttype').removeClass('d-none');
            } else {
                $(".paymenttype").fadeOut(500);
                $('.paymenttype').addClass('d-none');
            }
        });
    </script>
    <script>
        CKEDITOR.replace('success_msg', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('thanks_msg', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        $(document).on('click', "input[name$='assignform']", function() {
            if (this.checked) {
                $('#assign_form').fadeIn(500);
                $("#assign_form").removeClass('d-none');
                $("#assign_form").addClass('d-block');
            } else {
                $('#assign_form').fadeOut(500);
                $("#assign_form").removeClass('d-block');
                $("#assign_form").addClass('d-none');
            }
        });

        $(document).on('click', "input[name$='assign_type']", function() {
            var test = $(this).val();
            if (test == 'role') {
                $("#role").fadeIn(500);
                $("#role").removeClass('d-none');
                $("#user").addClass('d-none');
                $("#public").addClass('d-none');
            } else if (test == 'user') {
                $("#user").fadeIn(500);
                $("#user").removeClass('d-none');
                $("#role").addClass('d-none');
                $("#public").addClass('d-none');
            } else {
                $("#public").fadeIn(500);
                $("#public").removeClass('d-none');
                $("#role").addClass('d-none');
                $("#user").addClass('d-none');
            }
        });
        // $(document).on('click', "input[name$='assign_type']", function() {
        //     var test = $(this).val();
        //     if (test == 'role') {
        //         $("#role").fadeIn(500);
        //         $("#role").removeClass('d-none');
        //         $("#user").addClass('d-none');
        //     } else {
        //         $("#user").fadeIn(500);
        //         $("#user").removeClass('d-none');
        //         $("#role").addClass('d-none');
        //     }
        // });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
    </script>
@endpush
