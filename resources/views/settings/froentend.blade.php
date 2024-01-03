@php
    use App\Facades\UtilityFacades;
    $lang = \App\Facades\UtilityFacades::getValByName('default_language');
    $primary_color = \App\Facades\UtilityFacades::getsettings('color');
    if (isset($primary_color)) {
        $color = $primary_color;
    } else {
        $color = 'theme-4';
    }
    $roles = App\Models\Role::whereNotIn('name', ['Super Admin', 'Admin'])
        ->pluck('name', 'name')
        ->all();
@endphp

@extends('admin.layouts.main')
@section('title', __('Frontend Page'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Frontend Page') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Frontend Page') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#app_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('App Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#menu_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Menu Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#features_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Feature Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#price_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Price Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#faqs_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Faq Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#side_feature_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Side Feature Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#privacy_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Privacy Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#contactus_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Contact Us Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#term_condition_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Term & Condition Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#login_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('LogIn Page Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#recaptcha_setting"
                                class="list-group-item list-group-item-action border-0">{{ __('Recaptcha Setting') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="app_setting" class="card">
                        {!! Form::open([
                            'route' => ['frontend.page.store'],
                            'method' => 'Post',
                            'id' => 'frontend-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('App Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('apps_paragraph', __('App Paragraph'), ['class' => 'form-label']) }}
                                        {!! Form::textarea('apps_paragraph', Utility::getsettings('apps_paragraph'), [
                                            'class' => 'form-control',
                                            'rows' => '3',
                                            'placeholder' => __('Enter app paragraph'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image', __('Image (svg)'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image', ['class' => 'form-control', 'id' => 'image']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="menu_setting" class="card">
                        {!! Form::open([
                            'route' => ['menu.page.store'],
                            'method' => 'Post',
                            'id' => 'frontend-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Menu Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('menu_name', __('Menu Name'), ['class' => 'form-label']) }}
                                        {!! Form::text('menu_name', Utility::getsettings('menu_name'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter menu name'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('menu_subtitle', __('Menu Subtitle'), ['class' => 'form-label']) }}
                                        {!! Form::text('menu_subtitle', Utility::getsettings('menu_subtitle'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter menu subtitle'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('menu_title', __('Menu Title'), ['class' => 'form-label']) }}
                                        {!! Form::text('menu_title', Utility::getsettings('menu_title'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter menu title'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('menu_paragraph', __('Menu Paragraph'), ['class' => 'form-label']) }}
                                        {!! Form::textarea('menu_paragraph', Utility::getsettings('menu_paragraph'), [
                                            'class' => 'form-control',
                                            'rows' => '3',
                                            'placeholder' => __('Enter menu paragraph'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('images1', __('Image 1'), ['class' => 'form-label']) }} *
                                        {!! Form::file('images1', ['class' => 'form-control', 'id' => 'images1']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('submenu_name', __('Submenu Name'), ['class' => 'form-label']) }}
                                        {!! Form::text('submenu_name', Utility::getsettings('submenu_name'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter submenu name'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('submenu_subtitle', __('Submenu Subtitle'), ['class' => 'form-label']) }}
                                        {!! Form::text('submenu_subtitle', Utility::getsettings('submenu_subtitle'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter submenu subtitle'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('submenu_title', __('Submenu Title'), ['class' => 'form-label']) }}
                                        {!! Form::text('submenu_title', Utility::getsettings('submenu_title'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter submenu title'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('submenu_paragraph', __('Submenu Paragraph'), ['class' => 'form-label']) }}
                                        {!! Form::textarea('submenu_paragraph', Utility::getsettings('submenu_paragraph'), [
                                            'class' => 'form-control',
                                            'rows' => '3',
                                            'placeholder' => __('Enter submenu paragraph'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('images2', __('Image 2 (svg)'), ['class' => 'form-label']) }}
                                        *
                                        {!! Form::file('images2', ['class' => 'form-control', 'id' => 'images2']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="features_setting" class="card">
                        {!! Form::open([
                            'route' => 'feature.page.store',
                            'method' => 'Post',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Feature Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('feature_name', __('Feature Name'), ['class' => 'form-label']) }}
                                        {!! Form::text('feature_name', Utility::getsettings('feature_name'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter feature name'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('feature_paragraph', __('Feature Paragraph'), ['class' => 'form-label']) }}
                                        {!! Form::textarea('feature_paragraph', Utility::getsettings('feature_paragraph'), [
                                            'class' => 'form-control',
                                            'rows' => '3',
                                            'placeholder' => __('Enter feature paragraph'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="repeater">
                                    <div data-repeater-list="feature_setting">
                                        <div data-repeater-item>
                                            <input type="hidden" name="id" id="cat-id" />
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('feature_subname', __('Feature Subname'), ['class' => 'form-label']) }}
                                                        {!! Form::text('feature_subname', null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => __('Enter feature subname'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('theme_color', __('Theme Color'), ['class' => 'form-label']) }}
                                                        <select name="theme_color" data-trigger class="form-control">
                                                            <option value="">{{ __('Select theme color') }}</option>
                                                            <option value="bg-primary">{{ __('blue') }}</option>
                                                            <option value="bg-success">{{ __('green') }}</option>
                                                            <option value="bg-warning">{{ __('yellow') }}</option>
                                                            <option value="bg-danger">{{ __('red') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{ Form::label('avtar_format', __('Theme Avtar'), ['class' => 'form-label']) }}
                                                        <select name="avtar_format" data-trigger class="form-control">
                                                            <option value=""> {{ __('Select theme avtar') }}
                                                            </option>
                                                            <option value="fas fa-share-alt">{{ __('share') }}</option>
                                                            <option value="fas fa-stopwatch">{{ __('stopwatch') }}
                                                            </option>
                                                            <option value="fas fa-shield-alt">{{ __('shield') }}</option>
                                                            <option value="fas fa-users">{{ __('users') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        {{ Form::label('feature_subparagraph', __('Feature Subparagraph'), ['class' => 'form-label']) }}
                                                        {!! Form::textarea('feature_subparagraph', null, [
                                                            'class' => 'form-control',
                                                            'rows' => '3',
                                                            'placeholder' => __('Enter feature subparagraph'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="mt-37 col-md-3">
                                                    <input data-repeater-delete class="btn btn-danger" type="button"
                                                        value="Delete" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input data-repeater-create class="btn btn-primary" type="button" value="Add" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="faqs_setting" class="card">
                        {!! Form::open([
                            'route' => ['faq.page.store'],
                            'method' => 'Post',
                            'id' => 'frontend-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Faq Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('faq_title', __('Faq Title'), ['class' => 'form-label']) }}
                                        {!! Form::text('faq_title', Utility::getsettings('faq_title'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter faq title'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('faq_paragraph', __('Faq Paragraph'), ['class' => 'form-label']) }}
                                        {!! Form::textarea('faq_paragraph', Utility::getsettings('faq_paragraph'), [
                                            'class' => 'form-control',
                                            'rows' => '3',
                                            'placeholder' => __('Enter faq paragraph'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('faq_page_content', __('FAQ'), ['class' => 'col-form-label']) }}
                                    <div class="custom-input-group">
                                        {!! Form::textarea('faq_page_content', Utility::getsettings('faq_page_content'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter faq content'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="side_feature_setting" class="card">
                        {!! Form::open([
                            'route' => 'sidefeature.page.store',
                            'method' => 'Post',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Side Feature Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('sidefeature_name', __('Feature Name'), ['class' => 'form-label']) }}
                                        {!! Form::text('sidefeature_name', Utility::getsettings('sidefeature_name'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter feature name'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('sidefeature_title', __('Feature Title'), ['class' => 'form-label']) }}
                                        {!! Form::text('sidefeature_title', Utility::getsettings('sidefeature_title'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter feature title'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('sidefeature_subtitle', __('Feature Subtitle'), ['class' => 'form-label']) }}
                                        {!! Form::text('sidefeature_subtitle', Utility::getsettings('sidefeature_subtitle'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter feature subtitle'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('sidefeature_paragraph', __('Feature Paragraph'), ['class' => 'form-label']) }}
                                        {!! Form::textarea('sidefeature_paragraph', Utility::getsettings('sidefeature_paragraph'), [
                                            'class' => 'form-control',
                                            'rows' => '3',
                                            'placeholder' => __('Enter feature paragraph'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image1', __('Image 1'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image1', ['class' => 'form-control', 'id' => 'image1']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image2', __('Image 2'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image2', ['class' => 'form-control', 'id' => 'image2']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image3', __('Image 3'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image3', ['class' => 'form-control', 'id' => 'image3']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image4', __('Image 4'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image4', ['class' => 'form-control', 'id' => 'image4']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image5', __('Image 5'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image5', ['class' => 'form-control', 'id' => 'image5']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image6', __('image 6'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image6', ['class' => 'form-control', 'id' => 'image6']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image7', __('Image 7'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image7', ['class' => 'form-control', 'id' => 'image7']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('image8', __('Image 8'), ['class' => 'form-label']) }} *
                                        {!! Form::file('image8', ['class' => 'form-control', 'id' => 'image8']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="privacy_setting" class="card">
                        {!! Form::open([
                            'route' => 'privacy.page.store',
                            'method' => 'Post',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Privacy Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="custom-input-group ">
                                        {!! Form::textarea('privacy', Utility::getsettings('privacy'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter privacy page content'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="contactus_setting" class="card">
                        {!! Form::open([
                            'route' => 'contactus.page.store',
                            'method' => 'Post',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Contact Us Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('contact_us', __('Contact Us Page Content'), ['class' => 'col-form-label']) }}
                                        <div class="custom-input-group">
                                            {!! Form::textarea('contact_us', Utility::getsettings('contact_us'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter contact us page content'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('contact_email', __('Contact Email'), ['class' => 'col-form-label']) }}
                                        <div class="custom-input-group">
                                            {!! Form::text('contact_email', Utility::getsettings('contact_email'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter contact email'),
                                            ]) !!}
                                        </div>
                                        <p>{{ _('This email is for receive email when user submit contact us form.') }}</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('latitude', __('Latitude'), ['class' => 'col-form-label']) }}
                                                <div class="custom-input-group">
                                                    {!! Form::text('latitude', Utility::getsettings('latitude'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter latitude'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('longitude', __('Longitude'), ['class' => 'col-form-label']) }}
                                                <div class="custom-input-group">
                                                    {!! Form::text('longitude', Utility::getsettings('longitude'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => __('Enter longitude'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="captcha_settings">{{ __('Captcha Status') }}</label>
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            <input type="checkbox" name="captcha_status"
                                                class="form-check-input input-primary float-end" id="captcha_settings"
                                                {{ Utility::getsettings('captcha_status') ? 'checked' : 'unchecked' }}>
                                        </label>
                                    </div>
                                    <div id="captcha_setting"
                                        class="{{ Utility::getsettings('captcha_status') == 1 ? 'd--flex' : 'd-none' }} row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('recaptcha_key', __('Recaptcha Key'), ['class' => 'col-form-label']) }}
                                                {!! Form::text('recaptcha_key', env('CAPTCHA_SITEKEY'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha key'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('recaptcha_secret', __('Recaptcha Secret'), ['class' => 'col-form-label']) }}
                                                {!! Form::text('recaptcha_secret', env('CAPTCHA_SECRET'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha secret'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="term_condition_setting" class="card">
                        {!! Form::open([
                            'route' => 'termcondition.page.store',
                            'method' => 'Post',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('Term & Condition Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="custom-input-group ">
                                        {!! Form::textarea('term_condition', Utility::getsettings('term_condition'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter term&condition page content'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="login_setting" class="card">
                        {!! Form::open([
                            'route' => 'login.page.store',
                            'method' => 'Post',
                            'id' => 'setting-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-header">
                            <h5> {{ __('LogIn Page Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    {{ Form::label('login_image', __('Image'), ['class' => 'form-label']) }} *
                                    {!! Form::file('login_image', ['class' => 'form-control', 'id' => 'images']) !!}
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('login_title', __('Login Title'), ['class' => 'form-label']) }}
                                        {!! Form::text('login_title', Utility::getsettings('login_title'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter login title'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('login_subtitle', __('Login Subtitle'), ['class' => 'form-label']) }}
                                        {!! Form::text('login_subtitle', Utility::getsettings('login_subtitle'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter login subtitle'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary float-end mb-3']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="recaptcha_setting" class="card">
                        <div class="card-header">
                            <h5>{{ __('Recaptcha Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'route' => 'recaptcha.page.store',
                                'method' => 'Post',
                                'id' => 'setting-form',
                                'enctype' => 'multipart/form-data',
                                'data-validate',
                            ]) !!}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label
                                            for="contact_us_recaptcha_status">{{ __('Contact Us Recaptcha Status') }}</label>
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            {!! Form::checkbox(
                                                'contact_us_recaptcha_status',
                                                null,
                                                Utility::getsettings('contact_us_recaptcha_status') ? true : false,
                                                [
                                                    'class' => 'form-check-input input-primary',
                                                    'id' => 'contact_us_recaptcha_status',
                                                ],
                                            ) !!}
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="login_recaptcha_status">{{ __('LogIn Recaptcha Status') }}</label>
                                        <label class="form-switch mt-2 float-end custom-switch-v1">
                                            {!! Form::checkbox(
                                                'login_recaptcha_status',
                                                null,
                                                Utility::getsettings('login_recaptcha_status') ? true : false,
                                                [
                                                    'class' => 'form-check-input input-primary',
                                                    'id' => 'login_recaptcha_status',
                                                ],
                                            ) !!}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('recaptcha_key', __('Recaptcha Key'), ['class' => 'col-form-label']) }}
                                        {!! Form::text('recaptcha_key', Utility::getsettings('recaptcha_key'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter recaptcha key'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('recaptcha_secret', __('Recaptcha Secret'), ['class' => 'col-form-label']) }}
                                        {!! Form::text('recaptcha_secret', Utility::getsettings('recaptcha_secret'), [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter recaptcha secret'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('vendor/repeater/reapeater.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('privacy', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        CKEDITOR.replace('contact_us', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        CKEDITOR.replace('term_condition', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        CKEDITOR.replace('faq_page_content', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        $(document).on('click', "input[name$='captcha_status']", function() {
            if (this.checked) {
                $("#captcha_setting").removeClass('d-none');
                $("#captcha_setting").addClass('d--flex');
            } else {
                $("#captcha_setting").removeClass('d--flex');
                $("#captcha_setting").addClass('d-none');
            }
        });
        $(document).on('click', "input[name$='captchas_status']", function() {
            if (this.checked) {
                $("#captchas_setting").removeClass('d-none');
                $("#captchas_setting").addClass('d--flex');
            } else {
                $("#captchas_setting").removeClass('d--flex');
                $("#captchas_setting").addClass('d-none');
            }
        });
    </script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
        $(".list-group-item").click(function() {
            $('.list-group-item').filter(function() {
                return this.href == id;
            }).parent().removeClass('text-primary');
        });
        $(document).ready(function() {
            'use strict';
            window.id = 0;
            var $repeater = $('.repeater').repeater({
                initEmpty: true,
                defaultValues: {
                    'id': window.id,
                },
                show: function() {
                    $(this).slideDown();
                    $('#cat-id').val(window.id);
                    document.addEventListener('DOMContentLoaded', function() {
                        var genericExamples = document.querySelectorAll('[data-trigger]');
                        for (i = 0; i < genericExamples.length; ++i) {
                            var element = genericExamples[i];
                            new Choices(element, {
                                placeholderValue: 'This is a placeholder set in the config',
                                searchPlaceholderValue: 'Select Option',
                            });
                        }
                    });
                },
                isFirstItemUndeletable: true
            });
            $repeater.setList({!! UtilityFacades::getsettings('feature_setting') !!});
        });
    </script>
@endpush
