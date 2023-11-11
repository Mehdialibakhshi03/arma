<footer class="landing-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <a href='{{ route('home') }}'>
                    <img src="{{ imageExist(env('SETTING_UPLOAD_PATH'),$footer_logo) }}" alt="">
                </a>
            </div>
            <div class="col-md-10 d-flex justify-content-end align-items-center">
                <ul>
                    <li><a href='exchange-dark.html'>Exchange</a></li>
                    <li><a href='markets-dark.html'>Market</a></li>
                    <li><a href='settings-profile-dark.html'>Profile</a></li>
                    <li><a href='settings-wallet-dark.html'>Wallet</a></li>
                    <li><a href='settings-dark.html'>Settings</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
