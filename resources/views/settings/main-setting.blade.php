@php
    use App\Facades\UtilityFacades;
    $lang = \App\Facades\UtilityFacades::getValByName('default_language');
    $primary_color = \App\Facades\UtilityFacades::getsettings('color');
    if (isset($primary_color)) {
        $color = $primary_color;
    } else {
        $color = 'theme-4';
    }
    $roles = App\Models\Role::whereNotIn('name', ['Super Admin', 'Admin'])
        ->pluck('name', 'name')
        ->all();
@endphp
@extends('admin.layouts.main')
@section('title', __('Settings'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Settings') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Settings') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1"
                                class="list-group-item list-group-item-action border-0">{{ __('App Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-2"
                               class="list-group-item list-group-item-action border-0">{{ __('Meta Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">

                    <div id="useradd-1" class="pt-0 card">
                        {!! Form::open([
                            'route' => ['settings/app-name/update'],
                            'method' => 'POST',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('App Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row pt-0">

                                <div class="col-lg-4 col-sm-6 col-md-6 d-flex">
                                    <div class="card w-100">
                                        <div class="card-header">
                                            <h5>{{ __('App Light Logo') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="inner-content">
                                                <div class="logo-content mt-4 text-center py-2">
                                                    <a href="{{ asset('storage/app/uploads/appLogo/app-logo.png') }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/app/uploads/appLogo/app-logo.png') }}"
                                                            class="img_setting" width="170px">
                                                    </a>
                                                </div>
                                                <div class="text-center choose-files mt-5">
                                                    <label for="app_logo">
                                                        <div class="bg-primary company_logo_update"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        {{ Form::file('app_logo', ['class' => 'form-control file', 'id' => 'app_logo', 'data-filename' => 'app_logo']) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-md-6 d-flex">
                                    <div class="card w-100">
                                        <div class="card-header">
                                            <h5>{{ __('App Dark Logo') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="inner-content">
                                                <div class="logo-content mt-4 text-center py-2">
                                                    <a href="{{ asset('storage/app/uploads/appLogo/app-dark-logo.png') }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/app/uploads/appLogo/app-dark-logo.png') }}"
                                                            class="img_setting" width="170px">
                                                    </a>
                                                </div>
                                                <div class="text-center choose-files mt-5">
                                                    <label for="app_dark_logo">
                                                        <div class="bg-primary company_logo_update"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        {{ Form::file('app_dark_logo', ['class' => 'form-control file', 'id' => 'app_dark_logo', 'data-filename' => 'app_dark_logo']) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-md-6 d-flex">
                                    <div class="card w-100">
                                        <div class="card-header">
                                            <h5>{{ __('App Favicon Logo') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="inner-content">
                                                <div class="logo-content mt-4 text-center py-2">
                                                    <a href="{{ asset('storage/app/uploads/appLogo/app-favicon-logo.png') }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/app/uploads/appLogo/app-favicon-logo.png') }}"
                                                            class=" img_setting" width="50px">
                                                    </a>
                                                </div>
                                                <div class="text-center choose-files mt-5">
                                                    <label for="favicon_logo">
                                                        <div class="bg-primary company_logo_update"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        {{ Form::file('favicon_logo', ['class' => 'form-control file', 'id' => 'favicon_logo', 'data-filename' => 'favicon_logo']) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('app_name', __('Application Name'), ['class' => 'form-label']) }}
                                    {!! Form::text('app_name', Utility::getsettings('app_name'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter application name'),
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary', 'id' => 'save-btn']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <div id="useradd-2" class="pt-0 card">
                        {!! Form::open([
                            'route' => ['settings/meta/update'],
                            'method' => 'POST',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Meta Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row pt-0">



                                <div class="form-group">
                                    {{ Form::label('meta_tag', __('Meta Tag'), ['class' => 'form-label']) }}
                                    {!! Form::text('meta_tag', Utility::getsettings('meta_tag'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter Meta Tag'),
                                    ]) !!}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'form-label']) }}
                                    {!! Form::text('meta_keywords', Utility::getsettings('meta_keywords'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter Meta Keywords'),
                                    ]) !!}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('meta_description', __('Meta Description'), ['class' => 'form-label']) }}
                                    {!! Form::textarea('meta_description', Utility::getsettings('meta_description'), [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter Meta Description'),
                                    ]) !!}
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    {{ Form::label('meta_description', __('Meta Description'), ['class' => 'form-label']) }}--}}
{{--                                    {!! Form::text('meta_description', Utility::getsettings('meta_description'), [--}}
{{--                                        'class' => 'form-control',--}}
{{--                                        'placeholder' => __('Enter Meta Description'),--}}
{{--                                    ]) !!}--}}
{{--                                </div>--}}
                                <div class="col-3 py-2">
                                    <div class="">
                                        <label for="meta_robot" class="form-label"> {{ __('Meta Robots') }} </label>
                                    </div>
                                </div>
                                <div class="col-3 py-2">
                                    <div class="form-group">
                                        <div class="form-switch custom-switch-v1 d-inline-block">
                                            {!! Form::checkbox(
                                                'meta_robot',
                                                'on',
                                                UtilityFacades::getsettings('meta_robot') == 'on' ? true : false,
                                                [
                                                    'class' => 'form-check-input input-primary',
                                                    'id' => 'meta_robot',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary', 'id' => 'save-btn']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
@push('script')
    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }
        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];
            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }
        var custdarklayout = document.querySelector("#cust-darklayout");
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {
                document.querySelector(".m-header > .b-brand > .logo-lg").setAttribute("src",
                    "../assets/images/logo.svg");
                document.querySelector("#main-style-link").setAttribute("href", "../assets/css/style-dark.css");
            } else {
                document.querySelector(".m-header > .b-brand > .logo-lg").setAttribute("src",
                    "../assets/images/logo-dark.svg");
                document.querySelector("#main-style-link").setAttribute("href", "../assets/css/style.css");
            }
        });

        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }
        $('body').on('click', '.send_mail', function() {
            var action = $(this).data('action');
            var modal = $('#common_modal');
            $.get(action, function(response) {
                modal.find('.modal-title').html('{{ __('Test Mail') }}');
                modal.find('.body').html(response);
                modal.modal('show');
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".socialsetting").trigger("select");
        });
        $(document).on('change', ".socialsetting", function() {
            var test = $(this).val();
            if ($(this).is(':checked')) {
                if (test == 'google') {
                    $("#google").fadeIn(500);
                    $("#google").removeClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeIn(500);
                    $("#facebook").removeClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeIn(500);
                    $("#github").removeClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeIn(500);
                    $("#linkedin").removeClass('d-none');
                }
            } else {
                if (test == 'google') {
                    $("#google").fadeOut(500);
                    $("#google").addClass('d-none');
                } else if (test == 'facebook') {
                    $("#facebook").fadeOut(500);
                    $("#facebook").addClass('d-none');
                } else if (test == 'github') {
                    $("#github").fadeOut(500);
                    $("#github").addClass('d-none');
                } else if (test == 'linkedin') {
                    $("#linkedin").fadeOut(500);
                    $("#linkedin").addClass('d-none');
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            if ($("input[name$='captcha']").is(':checked')) {
                $("#recaptcha").fadeIn(500);
                $("#recaptcha").removeClass('d-none');
            } else {
                $("#recaptcha").fadeOut(500);
                $("#recaptcha").addClass('d-none');
            }
            $(".paymenttsetting").trigger("select");
        });
        $(document).on('change', ".paymenttsetting", function() {
            var test = $(this).val();
            if ($(this).is(':checked')) {
                if (test == 'razorpay') {
                    $("#razorpay").fadeIn(500);
                    $("#razorpay").removeClass('d-none');
                } else if (test == 'stripe') {
                    $("#stripe").fadeIn(500);
                    $("#stripe").removeClass('d-none');
                } else if (test == 'paytm') {
                    $("#paytm").fadeIn(500);
                    $("#paytm").removeClass('d-none');
                } else if (test == 'paypal') {
                    $("#paypal").fadeIn(500);
                    $("#paypal").removeClass('d-none');
                } else if (test == 'flutterwave') {
                    $("#flutterwave").fadeIn(500);
                    $("#flutterwave").removeClass('d-none');
                } else if (test == 'paystack') {
                    $("#paystack").fadeIn(500);
                    $("#paystack").removeClass('d-none');
                } else if (test == 'mercado') {
                    $("#mercado").fadeIn(500);
                    $("#mercado").removeClass('d-none');
                } else if (test == 'offline') {
                    $("#offline").fadeIn(500);
                    $("#offline").removeClass('d-none');
                }
            } else {
                if (test == 'razorpay') {
                    $("#razorpay").fadeOut(500);
                    $("#razorpay").addClass('d-none');
                } else if (test == 'paytm') {
                    $("#paytm").fadeOut(500);
                    $("#paytm").removeClass('d-none');
                } else if (test == 'stripe') {
                    $("#stripe").fadeOut(500);
                    $("#stripe").addClass('d-none');
                } else if (test == 'flutterwave') {
                    $("#flutterwave").fadeIn(500);
                    $("#flutterwave").removeClass('d-none');
                } else if (test == 'paypal') {
                    $("#paypal").fadeOut(500);
                    $("#paypal").addClass('d-none');
                } else if (test == 'paystack') {
                    $("#paystack").fadeOut(500);
                    $("#paystack").addClass('d-none');
                } else if (test == 'mercado') {
                    $("#mercado").fadeIn(500);
                    $("#mercado").removeClass('d-none');
                } else if (test == 'offline') {
                    $("#offline").fadeOut(500);
                    $("#offline").addClass('d-none');
                }
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='captchasetting']", function() {
            if (this.checked) {
                $('#captcha_setting').fadeIn(500);
                $("#captcha_setting").removeClass('d-none');
                $("#captcha_setting").addClass('d-block');
            } else {
                $('#captcha_setting').fadeOut(500);
                $("#captcha_setting").removeClass('d-block');
                $("#captcha_setting").addClass('d-none');
            }
        });
        $(document).on('click', "input[name$='captcha']", function() {
            var test = $(this).val();
            if (test == 'hcaptcha') {
                $("#hcaptcha").fadeIn(500);
                $("#hcaptcha").removeClass('d-none');
                $("#recaptcha").addClass('d-none');
            } else {
                $("#recaptcha").fadeIn(500);
                $("#recaptcha").removeClass('d-none');
                $("#hcaptcha").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('click', "input[name$='settingtype']", function() {
            var test = $(this).val();
            if (test == 's3') {
                $("#s3").fadeIn(500);
                $("#s3").removeClass('d-none');
            } else {
                $("#s3").fadeOut(500);
            }
        });
        $(document).on('change', "#multi_sms", function() {
            if ($(this).is(':checked')) {
                $(".multi_sms").fadeIn(500);
                $('.multi_sms').removeClass('d-none');
                $('#twilio').removeClass('d-none');
            } else {
                $(".multi_sms").fadeOut(500);
                $(".multi_sms").addClass('d-none');
            }
        });
        $(document).on('click', "input[name$='smssetting']", function() {
            var test = $(this).val();
            $("#twilio").fadeOut(500);
            if (test == 'twilio') {
                $("#twilio").fadeIn(500);
                $("#twilio").removeClass('d-none');
                $("#nexmo").fadeOut(500);
            } else {
                $("#nexmo").fadeIn(500);
                $("#nexmo").removeClass('d-none');
                $("#twilio").fadeOut(500);
            }
        });
    </script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
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
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
@endpush
