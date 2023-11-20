@php
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
@endphp
<header class="dash-header transprent-bg" style="background-color: {{ $top_bar_color }} !important;">
    <div class="header-wrapper">
        <div class="ms-auto rtlheader">
            <ul class="list-unstyled">
                <li class="dropdown dash-h-item">
                    <a class="dash-head-link custom-headers dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ imageExist(env('UPLOAD_SETTING'),$admin_avatar) }}" class="user-avtar ms-2" />
                        <span class="pr-1">
                            <h6 class="f-w-500 fs-6 d-inline-flex mb-0">{{ Auth::user()->name }}</h6>
                        </span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="#" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="ti ti-power"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                        {!! Form::open([
                            'route' => ['logout'],
                            'method' => 'POST',
                            'id' => 'logout-form',
                            'class' => 'd-none',
                        ]) !!}
                        {!! Form::close() !!}
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
