@extends('home.homelayout.app')
@section('title')
    اطلاعات حساب کاربری
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/profile_panel.css') }}">

    <style>
        .position-relative {
            position: relative;
        }

        #close_alert {
            position: absolute;
            cursor: pointer;
            top: 5px;
            left: 5px;
        }

        .my-2 {
            margin: 2rem 0;
        }

        .ht-btn {
            border: none !important;
            color: white !important;
        }

        .ht-btn:hover {
            background-color: #E8D2A6 !important;
            color: #000 !important;
        }

        .single-input-item > label, .single-input-item > input {
            font-size: 14px !important;
        }
    </style>
@endsection

@section('script')
    <script>
        $('.mobile-menu-toggle').click(function () {
            $('.loaded').addClass('mmenu-active');
        })
        $('.mobile-menu-close').click(function () {
            $('.loaded').removeClass('mmenu-active');
        })
        $('div#categories > ul.mobile-menu > li > a').append('<span class="toggle-btn"> </span>');
        $('div#categories > ul.mobile-menu > li > a > span.toggle-btn').click(function (e) {
            e.preventDefault();
            $(this).parent().next().slideToggle(300).parent().toggleClass("show");
        })
        // Show File Name
        $('#profile_image').change(function () {
            //get the file name
            let fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
        $('#close_alert').click(function () {
            $(this).parent().slideUp();
        })
        $('#mobile_menu_nav').click(function () {
            $('#icon-panel').toggleClass('negative');
            $('#icon-panel').toggleClass('positive');
            $('.negative').html('-');
            $('.positive').html('+');
        })
    </script>
@endsection

@section('content')
    <div class="my-account-wrapper main">
        <div class="container card">
            <div class="row card-body">
                <div class="col-lg-3 col-md-4">
                    <div class="myaccount-tab-menu nav" role="tablist">
                        <div>
                            <button id="mobile_menu_nav" class="btn btn-blue d-block d-md-none d-lg-none" style="width: 100%">
                                <span class="  w-100"><span style="float:right">ناحیه کاربری</span><span id="icon-panel" class="positive" style="float:left">+</span></span>
                            </button>
                        </div>
                        <div id="mobile_menu_nav_ul">
                            <ul class="profile_sidebar_items">
                                <li>
                                    <a href="#"
                                       class="">
                                        <i class="w-icon-orders ml-1"></i>
                                        سفارش های من
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('logout') }}">
                                        <i class="fa fa-sign-out-alt ml-1"></i>
                                        logout
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-9 col-md-8">


                    <div class="tab-content" id="myaccountContent">
                        <div class="myaccount-content">
                            <h3> اطلاعات حساب کاربری </h3>
                            <div class="account-details-form">
                                <form action="" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <label style="font-weight:bold" for="first_name" class="required">
                                                    نام:
                                                </label>
                                                <input class="form-control form-control-sm" type="text" id="first_name"
                                                       name="first_name" value="{{ $user->first_name }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <label style="font-weight:bold" for="last_name" class="required">
                                                    نام خانوادگی:
                                                </label>
                                                <input class="form-control form-control-sm" type="text" id="last_name"
                                                       name="last_name" value="{{ $user->last_name }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <label style="font-weight:bold" for="national_code" class="required">
                                                    کد ملی:
                                                </label>
                                                <input class="form-control form-control-sm" id="national_code"
                                                       name="national_code" value="{{ $user->national_code }}"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <label style="font-weight:bold" for="cellphone" class="required">
                                                    شماره همراه:
                                                </label>
                                                <input id="cellphone" class="form-control form-control-sm" disabled
                                                       value="{{ $user->cellphone }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-input-item mt-3">

                                        @if($user->first_name==null)
                                            <button type="submit" class="ht-btn btn-blue black-btn"> تکمیل ثبت نام
                                            </button>
                                        @else
                                            <button type="submit" style="font-size: 13px !important;
height: 40px !important;" class="btn btn-blue black-btn"> ویرایش اطلاعات
                                            </button>
                                        @endif
                                    </div>

                                </form>
                            </div>
                            <div class="col-12 mt-3 mb-3">
                                <hr>
                            </div>
                            <div class="account-details-form mt-3">
                                <form action="" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <label for="password">رمز عبور:</label>
                                                <input name="password" id="password" class="form-control mb-2 border">
                                                @error('password')
                                                <p class="input-error-validation">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <label for="password_confirmation">تکرار رمز عبور:</label>
                                                <input name="password_confirmation" id="password_confirmation"
                                                       class="form-control mb-2 border">
                                                @error('password_confirmation')
                                                <p class="input-error-validation">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-input-item mt-3">
                                        <button type="submit" style="font-size: 13px !important;
height: 40px !important;" class="btn btn-blue black-btn"> ویرایش رمز عبور
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
