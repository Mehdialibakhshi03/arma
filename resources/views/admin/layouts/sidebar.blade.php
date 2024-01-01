{{--  {{ dd($forms) }}  --}}
<nav class="dash-sidebar light-sidebar transprent-bg" style="background-color: {{ $side_bar_color }} !important;">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home.index') }}" class="b-brand text-center">
                <!-- ========   change your logo hear   ============ -->
                <img width="100" src="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}"
                     class="app-logo img_setting"/>

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
                    <li class="">
                        <a href="{{ route('sale_form',['page_type'=>'Create']) }}" class="dash-link">
                            <span class="dash-micon">
                                <i class="fa fa-pen"></i>
                            </span>
                            <span class="dash-mtext custom-weight">
                                Sales Order
                            </span>
                        </a>
                    </li>
                @php
                    $inbox_count=\App\Models\SalesOfferForm::where('status',1)->count();
                    $cash_pending_count=\App\Models\SalesOfferForm::where('status',2)->count();
                    $data_pending_count=\App\Models\SalesOfferForm::where('status',3)->count();
                    $reject_count=\App\Models\SalesOfferForm::where('status',4)->count();
                    $approved_count=\App\Models\SalesOfferForm::where('status',5)->count();
                @endphp

                <li class="dash-item">
                    <a href="#!" class="dash-link position-relative">
                                <span class="dash-micon">
                                <i class="ti ti-table"></i>
                            </span>

                        <span
                            class="dash-mtext custom-weight">{{ __('Inquiries') }}</span><span
                            class="dash-arrow"><i data-feather="chevron-right"></i></span>
{{--                        @if($pending_count>0)--}}
{{--                            <span--}}
{{--                                class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>--}}
{{--                        @endif--}}
                    </a>

                    @php
                        $need_to_confirm_count=\App\Models\FormValue::where('status',3)->count();
                    @endphp
                    <ul class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>1]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Inbox').'('.$inbox_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>2]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Cash Pending').'('.$cash_pending_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>3]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Data Pending').'('.$data_pending_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>4]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Rejected').'('.$reject_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>5]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Approved').'('.$approved_count.')' }}
                            </a>
                        </li>
                    </ul>
                </li>

                    <li class="dash-item dash-hasmenu {{ request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }} || {{ request()->is('create-language*') || request()->is('settings*') ? 'active' : '' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-apps"></i></span><span
                                class="dash-mtext">{{ __('Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">


                            <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.settings.index') }}">{{ __('Settings') }}</a>
                            </li>

                        </ul>
                    </li>
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
                        <a href="#!" class="dash-link">
                            <span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Markets') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.markets.index') }}">{{ __('Markets') }}</a>
                            </li>
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.markets.settings') }}">{{ __('Market Setting') }}</a>
                            </li>
                        </ul>
                    </li>

            </ul>
        </div>
    </div>
</nav>
