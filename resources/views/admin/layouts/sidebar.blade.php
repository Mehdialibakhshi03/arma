{{--  {{ dd($forms) }}  --}}
<nav class="dash-sidebar light-sidebar transprent-bg">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home') }}" class="b-brand text-center">
                <!-- ========   change your logo hear   ============ -->
                @if (Utility::getsettings('dark_mode') == 'on')
                    <img
                        src="{{ asset('/storage/app/uploads/avatar/avatar.png') }}"
                        class="app-logo img_setting w-75"/>
                @else
                    <img
                        src="{{ asset('/storage/app/uploads/appLogo/78x78.png') }}"
                        class="app-logo img_setting w-75"/>
                @endif
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar" style="display: block;">
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Dashboard') }}</span></a>
                </li>
                @php
                    $pending_count=\App\Models\User::where('active_status',0)->count();
                @endphp
                @can('user')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/users*') ? 'active dash-trigger' : 'collapsed' }}">

                        <a href="#!" class="dash-link position-relative"><span class="dash-micon"><i
                                    class="ti ti-layout-2"></i></span><span
                                class="dash-mtext">{{ __('Users') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span>
                            @if($pending_count>0)
                                <span
                                    class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>
                            @endif
                        </a>

                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('users/1*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.users.index',['type'=>1]) }}">{{ __('Registered Users') }}</a>
                            </li>
                            <li class="dash-item d-flex align-items-center {{ request()->is('users*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.users.index',['type'=>0]) }}">{{ __('Pending Users') }}</a>
                                @if($pending_count>0)
                                    <span class="circle-notification">{{ $pending_count }}</span>
                                @endif
                            </li>
                            <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.users.index',['type'=>2]) }}">{{ __('Denied Users') }}</a>
                            </li>


                            <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</a>
                            </li>
                            <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.permission.index') }}">{{ __('Permissions') }}</a>
                            </li>
                        </ul>

                    </li>
                @endcan
                @can('user-edit')
                    <li class="">
                        <a href="{{ route('admin.user.edit',['type'=>auth()->user()->active_status,'user'=>auth()->id()]) }}"
                           class="dash-link">
                            <span class="dash-micon">
                                <i class="fa fa-user"></i>
                            </span>
                            <span class="dash-mtext custom-weight">
                                {{ __('me') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('form')
                    <li class="">
                        <a href="{{ route('admin.forms.index') }}" class="dash-link">
                            <span class="dash-micon">
                                <i class="fa fa-pen"></i>
                            </span>
                            <span class="dash-mtext custom-weight">
                                {{ __('Forms Generator') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @php
                    $pending_count=\App\Models\FormValue::where('status',0)->count();
                @endphp
                @can('commodity')
                    <li class="dash-item">
                        <a href="#!" class="dash-link position-relative">
                                <span class="dash-micon">
                                <i class="ti ti-table"></i>
                            </span>

                            <span
                                class="dash-mtext custom-weight">{{ __('Commodity') }}</span><span
                                class="dash-arrow"><i data-feather="chevron-right"></i></span>
                            @if($pending_count>0)
                                <span
                                    class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>
                            @endif
                        </a>


                        <ul
                            class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.form.values',['status'=>0]) }}" class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Pending') }}
                                </a>

                                @if($pending_count>0)
                                    <span class="circle-notification">{{ $pending_count }}</span>
                                @endif
                            </li>
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.form.values',['status'=>2]) }}" class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Denied') }}
                                </a>
                            </li>
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.form.values',['status'=>1]) }}"
                                   class="dash-link font10pt"><span
                                        class="dash-mtext custom-weight">{{ __('Approved Commodity') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('setting')
                    <li class="dash-item dash-hasmenu {{ request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }} || {{ request()->is('create-language*') || request()->is('settings*') ? 'active' : '' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-apps"></i></span><span
                                class="dash-mtext">{{ __('Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">


                            <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('settings') }}">{{ __('Settings') }}</a>
                            </li>

                        </ul>
                    </li>
                @endcan

                @can('header-setting')
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/setting*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Header Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.header1.index') }}">{{ __('Header 1') }}</a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.header2.index') }}">{{ __('Header 2') }}</a>
                            </li>

                        </ul>
                    </li>
                @endcan
                @can('message')
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/messages*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Message') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/emails*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.emails.index') }}">{{ __('Email') }}</a>
                            </li>
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/alerts*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.alerts.index') }}">{{ __('Alert') }}</a>
                            </li>

                        </ul>
                    </li>
                @endcan
                @can('markets')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Markets') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets/open*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.markets.index',['status'=>'open']) }}">{{ __('Open Market') }}</a>
                            </li>
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets/close*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.markets.index',['status'=>'close']) }}">{{ __('Close Market') }}</a>
                            </li>

                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</nav>
