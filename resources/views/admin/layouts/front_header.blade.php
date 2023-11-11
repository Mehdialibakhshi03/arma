@php
    $users = \Auth::user();
    $languages = Utility::languages();
    $profile = asset(Storage::url('uploads/avatar/'));
@endphp
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ setting('app_name') }}</title>
    <link rel="icon"
        href="{{ setting('favicon_logo') ? Storage::url('uploads/appLogo/app-favicon-logo.png') : asset('assets/images/app-favicon-logo.png') }}"
        type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $primary_color = \App\Facades\UtilityFacades::getsettings('color');
        if (isset($primary_color)) {
            $color = $primary_color;
        } else {
            $color = 'theme-1';
        }
    @endphp
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}" />
    @if (Utility::getsettings('dark_mode') == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">

</head>
<body class="{{ $color }}">
    <nav class="navbar navbar-expand-md navbar-dark default top-nav-collapse">
        <div class="container">
            <a class="navbar-brand bg-transparent" href="{{ route('landingpage') }}">
                <img src="{{ Storage::url(setting('app_logo')) ? Storage::url('uploads/appLogo/app-logo.png') : asset('assets/images/app-logo.png') }}"
                    class="cust-logo img_setting" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('landingpage*') ? 'active' : '' }}"
                            href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('landingpage') }}#features" class="nav-link">{{ __('Features') }}</a>
                    </li>
                    @if ($users)
                        <li class="nav-item">
                            <a href="{{ url('/home') }}" class="nav-link">{{ __('Dashboard') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ url('/home') }}" class="nav-link">{{ __('Login') }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <select class="custom_btn btn-light ms-2 me-2 language_option_bg" name="language"
                            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
                            id="language" data-trigger>
                            @foreach ($languages as $language)
                                <option class="" @if ($lang == $language) selected @endif
                                    value="{{ route('landingpage', $language) }}">{{ Str::upper($language) }}</option>
                            @endforeach
                        </select>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
