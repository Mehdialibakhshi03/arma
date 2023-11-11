
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
                @role('Admin')
                @include('admin.layouts.admin_sidebar')
                @endrole
                @role('Seller')
                @include('admin.layouts.seller_sidebar')
                @endrole
            </ul>
        </div>
    </div>
</nav>
