@extends('admin.layouts')

@section('title')
    Setting - Config
@endsection

@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    @include('admin.sections.alert')

                                    <div class="row">
                                        <div class="col-12 col-md-4 text-center">
                                            <img  src="{{ imageExist(env('SETTING_UPLOAD_PATH'),$logo) }}">
                                            <div class="mt-3 text-white">
                                                LOGO
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 text-center">
                                            <img width="100" src="{{ imageExist(env('SETTING_UPLOAD_PATH'),$footer_logo) }}">
                                            <div class="mt-3 text-white">
                                                Footer Logo
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 text-center">
                                            <img width="100" src="{{ imageExist(env('SETTING_UPLOAD_PATH'),$fav_icon) }}">
                                            <div class="mt-3 text-white">
                                                FAVICON
                                            </div>
                                        </div>

                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="form-row mt-4">

                                                <div class="col-md-4">
                                                    <input type="file" class="custom-file-input" id="logo" name="logo">
                                                    <label class="custom-file-label" for="logo">Choose
                                                        logo</label>
                                                    @error('logo')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="file" class="custom-file-input" id="footer_logo" name="footer_logo">
                                                    <label class="custom-file-label" for="footer_logo">Choose
                                                        footer logo</label>
                                                    @error('footer_logo')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="file" class="custom-file-input" id="fav_icon" name="fav_icon">
                                                    <label class="custom-file-label" for="favicon">Choose Favicon</label>
                                                    @error('fav_icon')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="title">Title</label>
                                                    <input id="title" type="text" name="title" class="form-control"
                                                           placeholder="Title" value="{{ $title }}">
                                                    @error('title')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="meta_keywords">Meta Keywords</label>
                                                    <input id="meta_keywords" type="text" name="meta_keywords"
                                                           class="form-control"
                                                           placeholder="Meta Keywords" value="{{ $meta_keywords }}">
                                                    @error('meta_keywords')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="start_market">Market Start At</label>
                                                    <input id="start_market" type="time" name="start_market"
                                                           class="form-control"
                                                           value="{{ $start_market }}">
                                                    @error('start_market')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="end_market">Market End At</label>
                                                    <input id="end_market" type="time" name="end_market"
                                                           class="form-control"
                                                           value="{{ $end_market }}">
                                                    @error('end_market')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="meta_description">Meta Description</label>
                                                    <textarea rows="4" id="meta_description" type="text"
                                                              name="meta_description" class="form-control"
                                                              placeholder="Meta Description">{{ $meta_description }}</textarea>
                                                    @error('meta_description')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="settings-notification col-12 col-md-4 mt-2">
                                                    <ul>
                                                        <li>
                                                            <div class="notification-info">
                                                                <p>Meta Robot</p>
                                                                <span>Active Robot index</span>
                                                            </div>
                                                            <div class="custom-control custom-switch">
                                                                <input {{ $robot_index==1 ? 'checked' : '' }} type="checkbox" class="custom-control-input" id="robot_index" name="robot_index">
                                                                <label class="custom-control-label" for="robot_index"></label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="submit" value="Update">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

