<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ \App\Facades\UtilityFacades::getsettings('rtl') == '1' ? 'rtl' : '' }}">

<head>
    @php
        $primary_color = \App\Facades\UtilityFacades::getsettings('color');
        if (isset($primary_color)) {
            $color = $primary_color;
        } else {
            $color = 'theme-4';
        }
    @endphp
    <title>@yield('title')</title>
    <!-- Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon"
          href="{{ imageExist(env('UPLOAD_SETTING'),$fav_icon) }}"
          type="image/png">
    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">

    @if (Utility::getsettings('rtl') == '1')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif
    @if (Utility::getsettings('dark_mode') == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif
</head>

<body class="{{ $color }}">
<!-- [ auth-signup ] start -->
<div class="auth-wrapper auth-v3">
    <div class="bg-auth-side bg-primary">
    </div>
    <div class="auth-content">
        <nav class="navbar navbar-expand-md navbar-light default">
            {{-- <div class="row align-items-center justify-content-center text-start">
                <div class="col-xl-6 text-center">
                    <div class="mx-3 mx-md-5 mb-4">
                        {!! Form::image(
                            Utility::getsettings('app_logo')
                                ? Storage::url('uploads/appLogo/app-logo.png')
                                : Storage::url('uploads/appLogo/78x78.png'),
                            null,
                            [
                                'class' => 'cust-logo img_setting',
                            ],
                        ) !!}
                    </div>
                    @yield('content')
                </div>
            </div> --}}

            <div class="container-fluid pe-2">
                <a class="navbar-brand" href="#">
                    @if (Utility::getsettings('dark_mode') == 'on')
                        {!! Form::image(
                            Utility::getsettings('app_logo')
                                ? Storage::url('uploads/appLogo/app-logo.png')
                                : Storage::url('uploads/appLogo/78x78.png'),
                            null,
                            [
                                'class' => 'footers-logo img_setting',
                            ],
                        ) !!}
                    @else
                        {!! Form::image(
                            Utility::getsettings('app_dark_logo')
                                ? Storage::url('uploads/appLogo/app-dark-logo.png')
                                : Storage::url('uploads/appLogo/78x78.png'),
                            null,
                            ['class' => 'footers-logo img_setting'],
                        ) !!}
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('privacypolicy') }}">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contactus') }}">{{ __('Contact Us') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('faq') }}">{{ __('FAQs') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('termsandconditions') }}">{{ __('Terms And Conditions') }}</a>
                        </li>
                        @yield('auth-topbar')
                    </ul>
                </div>
            </div>
        </nav>


        <div class="card">
            <div class="row align-items-center text-start">
                <div class="col-xl-6">
                    @yield('content')
                </div>
                <div class="col-xl-6 img-card-side">
                    <div class="auth-img-content">
                        <img src="{{ Utility::getsettings('login_image')
                                ? Storage::url(Utility::getsettings('login_image'))
                                : asset('assets/images/auth/img-auth-3.svg') }}"
                             class="img-fluid"/>
                        <h3 class="text-white mb-4 mt-5">
                            {{ Utility::getsettings('login_title') ? Utility::getsettings('login_title') : 'Attention is the new currency' }}
                        </h3>
                        <p class="text-white">
                            {{ Utility::getsettings('login_subtitle') ? Utility::getsettings('login_subtitle') : 'The more effortless the writing looks, the more effort the writer actually put into the process.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <p>
                            © {{ date('Y') }}, {{ config('app.name') }}</p>
                        {{-- @include('layouts.front_footer') --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="auth-footer">
            <div class="container-fluid">
                <div class="row align-items-center d-flex">
                    <div class="col-6">
                        @if (Utility::getsettings('dark_mode') == 'on')
                            {!! Form::image(
                                Utility::getsettings('app_logo')
                                    ? Storage::url('uploads/appLogo/app-logo.png')
                                    : Storage::url('uploads/appLogo/78x78.png'),
                                null,
                                [
                                    'class' => 'footers-logo img_setting',
                                ],
                            ) !!}
                        @else
                            {!! Form::image(
                                Utility::getsettings('app_dark_logo')
                                    ? Storage::url('uploads/appLogo/app-dark-logo.png')
                                    : Storage::url('uploads/appLogo/78x78.png'),
                                null,
                                ['class' => 'footers-logo img_setting'],
                            ) !!}
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        &copy; {{ date('Y') }}
                        {!! Html::link('#', config('app.name'), ['target' => '_blank', 'class' => 'font-weight-bold ml-1']) !!}
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
</body>
<!-- [ auth-signup ] end -->
<script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor-font-awsome.js') }}"></script>
{{--<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>

<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.js') }}"></script>
<script src="{{ asset('vendor/js/custom.js') }}"></script>
<script>
    feather.replace();
</script>
<div class="pct-customizer">
    <div class="pct-c-btn">
        <button class="btn btn-primary" id="pct-toggler">
            <i data-feather="settings"></i>
        </button>
    </div>
    <div class="pct-c-content">
        <div class="pct-header bg-primary">
            <h5 class="mb-0 text-white f-w-500">{{ __('Theme Customizer') }}</h5>
        </div>
        <div class="pct-body">
            <h6 class="mt-2">
                <i data-feather="credit-card" class="me-2"></i>{{ __('Primary color settings') }}
            </h6>
            <hr class="my-2"/>
            <div class="theme-color themes-color">
                {!! Html::link('#!', '', ['data-value' => 'theme-1']) !!}
                {!! Html::link('#!', '', ['data-value' => 'theme-2']) !!}
                {!! Html::link('#!', '', ['data-value' => 'theme-3']) !!}
                {!! Html::link('#!', '', ['data-value' => 'theme-4']) !!}
            </div>
            <h6 class="mt-4">
                <i data-feather="layout" class="me-2"></i>{{ __('Sidebar settings') }}
            </h6>
            <hr class="my-2"/>
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="cust-theme-bg" checked/>
                <label class="form-check-label f-w-600 pl-1" for="cust-theme-bg">{{ __('Transparent layout') }}</label>
            </div>
            <h6 class="mt-4">
                <i data-feather="sun" class="me-2"></i>{{ __('Layout settings') }}
            </h6>
            <hr class="my-2"/>
            <div class="form-check form-switch mt-2">
                <input type="checkbox" class="form-check-input" id="cust-darklayout"/>
                <label class="form-check-label f-w-600 pl-1" for="cust-darklayout">{{ __('Dark Layout') }}</label>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
@if (setting('rtl') == '1')
@endif
<script>
    @if (session('failed'))
    notifier.show('Failed!', '{{ session('failed') }}', 'danger',
        '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
    @endif
    @if (session('errors'))
    notifier.show('Error!', '{{ session('errors') }}', 'danger',
        '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
    @endif
    @if (session('successful'))
    notifier.show('SuccessfulLY!', '{{ session('successful') }}', 'success',
        '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
    @endif
    @if (session('success'))
    notifier.show('Done!', '{{ session('success') }}', 'success',
        '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
    @endif
    @if (session('warning'))
    notifier.show('Warning!', '{{ session('warning') }}', 'warning',
        '{{ asset('assets/images/notification/medium_priority-48.png') }}', 4000);
    @endif
</script>
<script>
    @if (session('status'))
    notifier.show('Great!', '{{ session('status') }}', 'info',
        '{{ asset('assets/images/notification/survey-48.png') }}', 4000);
    @endif
</script>
<script>
    $(document).on('click', '.delete-action', function () {
        var form_id = $(this).attr('data-form-id')
        $.confirm({
            title: '{{ __('Alert !') }}',
            content: '{{ __('Are You sure ?') }}',
            buttons: {
                confirm: function () {
                    $("#" + form_id).submit();
                },
                cancel: function () {
                }
            }
        });
    });
</script>
@stack('script')
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
    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>


</html>
