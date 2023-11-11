<li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class="dash-link"><span class="dash-micon"><i
                class="ti ti-home"></i></span>
        <span class="dash-mtext custom-weight">{{ __('Dashboard') }}</span></a>
</li>
@canany(['manage-user', 'manage-role'])
    @php
        $pending_count=\App\Models\User::where('active_status',0)->count();
    @endphp
    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/users*') ? 'active dash-trigger' : 'collapsed' }}">
        <a href="#!" class="dash-link position-relative"><span class="dash-micon"><i
                    class="ti ti-layout-2"></i></span><span
                class="dash-mtext">{{ __('Users') }}</span><span class="dash-arrow"><i
                    data-feather="chevron-right"></i></span>
            @if($pending_count>0)
                <span class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>
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

            {{--                            @can('manage-role')--}}
            {{--                                <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">--}}
            {{--                                    <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>--}}
            {{--                                </li>--}}
            {{--                            @endcan--}}
        </ul>
    </li>
@endcanany
@canany(['manage-form', 'manage-submitted-form'])
    <li class="">
        <a href="{{ route('forms.index') }}" class="dash-link">
                            <span class="dash-micon">
                                <i class="ti ti-table"></i>
                            </span>
            <span class="dash-mtext custom-weight">
                                {{ __('Forms Generator') }}
                            </span>
        </a>
    </li>
    @can('manage-form')
        @php
            $pending_count=\App\Models\FormValue::where('status',0)->count();
        @endphp
        <li class="dash-item">
            <a href="#!" class="dash-link position-relative">
                                <span class="dash-micon">
                                <i class="ti ti-table"></i>
                            </span>

                <span
                    class="dash-mtext custom-weight">{{ __('Commodity') }}</span><span
                    class="dash-arrow"><i data-feather="chevron-right"></i></span>
                @if($pending_count>0)
                    <span class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>
                @endif
            </a>


            <ul
                class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                <li class="dash-item d-flex align-items-center">
                    <a href="{{ route('view.form.values',['status'=>0]) }}" class="dash-link"><span
                            class="dash-mtext custom-weight">{{ __('Pending') }}
                    </a>

                    @if($pending_count>0)
                        <span class="circle-notification">{{ $pending_count }}</span>
                    @endif
                </li>
                <li class="dash-item d-flex align-items-center">
                    <a href="{{ route('view.form.values',['status'=>2]) }}" class="dash-link"><span
                            class="dash-mtext custom-weight">{{ __('Denied') }}
                    </a>
                </li>
                <li class="dash-item d-flex align-items-center">
                    <a href="{{ route('view.form.values',['status'=>1]) }}" class="dash-link font10pt"><span
                            class="dash-mtext custom-weight">{{ __('Approved Commodity') }}
                    </a>
                </li>
                {{--                                @foreach ($forms as $form)--}}
                {{--                                    <li class="dash-item">--}}
                {{--                                        <a class="dash-link {{ Request::route()->getName() == 'view.form.values' ? 'show' : '' }}"--}}
                {{--                                           href="{{ route('view.form.values', $form->id) }}">{{ $form->title }}</a>--}}
                {{--                                    </li>--}}
                {{--                                @endforeach--}}
            </ul>
        </li>
    @endcan
@endcanany
@canany(['manage-mailtemplate', 'manage-language', 'manage-setting'])
    <li
        class="dash-item dash-hasmenu {{ request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }} || {{ request()->is('create-language*') || request()->is('settings*') ? 'active' : '' }}">
        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-apps"></i></span><span
                class="dash-mtext">{{ __('Account Setting') }}</span><span class="dash-arrow"><i
                    data-feather="chevron-right"></i></span></a>
        <ul class="dash-submenu">
            {{--                            @can('manage-mailtemplate')--}}
            {{--                                <li class="dash-item {{ request()->is('mailtemplate*') ? 'active' : '' }}">--}}
            {{--                                    <a class="dash-link"--}}
            {{--                                        href="{{ route('mailtemplate.index') }}">{{ __('Email Templates') }}</a>--}}
            {{--                                </li>--}}
            {{--                            @endcan--}}
            {{--                            <li class="dash-item {{ request()->is('sms-template*') ? 'active' : '' }}">--}}
            {{--                                <a class="dash-link"--}}
            {{--                                    href="{{ route('sms-template.index') }}">{{ __('Sms Templates') }}</a>--}}
            {{--                            </li>--}}
            {{--                            @can('manage-language')--}}
            {{--                                <li--}}
            {{--                                    class="dash-item {{ request()->is('manage-language*') || request()->is('create-language*') ? 'active' : '' }}">--}}
            {{--                                    <a class="dash-link"--}}
            {{--                                        href="{{ route('manage.language', [$currantLang]) }}">{{ __('Manage Languages') }}</a>--}}
            {{--                                </li>--}}
            {{--                            @endcan--}}
            @can('manage-setting')
                <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">
                    <a class="dash-link" href="{{ route('settings') }}">{{ __('Settings') }}</a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
@canany(['manage-chat'])
    @if (setting('pusher_status') == '1')
        <li
            class="dash-item dash-hasmenu {{ request()->is('chat*') ? 'active dash-trigger' : 'collapsed' }}">
            <a href="#!" class="dash-link"><span class="dash-micon"><i
                        class="ti ti-table"></i></span><span
                    class="dash-mtext">{{ __('Support') }}</span><span class="dash-arrow"><i
                        data-feather="chevron-right"></i></span></a>
            <ul class="dash-submenu">
                @can('manage-chat')
                    <li class="dash-item">
                        <a class="dash-link" href="{{ route('chats') }}">{{ __('Chats') }}</a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif
@endcanany
@can('manage-setting')
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
    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
        <a href="#!" class="dash-link"><span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                class="dash-mtext">{{ __('Markets') }}</span><span class="dash-arrow"><i
                    data-feather="chevron-right"></i></span></a>
        <ul class="dash-submenu">
            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets/open*') ? 'active' : '' }}">
                <a class="dash-link" href="{{ route('admin.markets.index',['status'=>'open']) }}">{{ __('Open Market') }}</a>
            </li>
            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets/close*') ? 'active' : '' }}">
                <a class="dash-link" href="{{ route('admin.markets.index',['status'=>'close']) }}">{{ __('Close Market') }}</a>
            </li>

        </ul>
    </li>
@endcan
