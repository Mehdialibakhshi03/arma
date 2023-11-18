@extends('admin.layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Design Form') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('admin.forms.index'), __('Forms'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Design Form') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="main-content" style="min-height: 517px;">
            <section class="section">
                <div class="section-body">
                    {{ Form::model($form, ['route' => ['admin.forms.design.update', $form->id], 'data-validate', 'method' => 'PUT', 'id' => 'design-form']) }}
                    <div class="row">
                        <div class="col-xl-12 order-xl-1">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Design Form') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @php
                                                        $array = json_decode($form->json);
                                                    @endphp
                                                    <ul id="tabs"
                                                        class="nav nav-tabs mb-3 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                                                        @if (!empty($form->json))
                                                            {{--  {{ dd(!empty($form->json)) }}  --}}
                                                            @foreach ($array as $key => $data)
                                                                {{--  {{ dd($array , $data) }}  --}}
                                                                @php
                                                                    $key = $key + 1;
                                                                @endphp
                                                                <li
                                                                    class="nav-item ui-state-default ui-corner-top ui-state-focus">
                                                                    {!! Html::link("#page-$key", __('Page') . $key, ['class' => 'nav-link']) !!}
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                {!! Html::link('#page-1', __('Page1'), []) !!}
                                                            </li>
                                                        @endif
                                                        <li id="add-page-tab">
                                                            {{--  <a data-action="#new-page" href="javascript:void(0)"
                                                                 class="nav-link newpage">+Page</a>  --}}
                                                            {!! Html::link('#new-page', __('+Page'), [
                                                                'class' => 'nav-link']) !!}
                                                        </li>
                                                    </ul>
                                                    @if (!empty($form->json))
                                                        @foreach ($array as $key => $data)
                                                            <div id="page-{{ $key + 1 }}" class="build-wrap">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div id="page-1" class="build-wrap"></div>
                                                    @endif

                                                    <div id="new-page"></div>
                                                    {!! Form::hidden('json', $form->json, ['class' => '']) !!}
                                                    <br>
                                                    <div class="action-buttons">
                                                        {!! Form::button(__('Show Data'), ['class' => 'd-none', 'id' => 'showData']) !!}
                                                        {!! Form::button(__('Clear All Fields'), ['class' => 'd-none', 'id' => 'clearFields']) !!}
                                                        {!! Form::button(__('Get Data'), ['class' => 'd-none', 'id' => 'getData']) !!}
                                                        {!! Form::button(__('Get XML Data'), ['class' => 'd-none', 'id' => 'getXML']) !!}
                                                        {!! Form::button(__('Update'), ['class' => 'btn btn-primary', 'id' => 'getJSON']) !!}
                                                        {!! Form::button(__('Back'), [
                                                            'class' => 'd-none',
                                                            'onClick' => 'javascript:history.go(-1)',
                                                            'id' => 'getJSONs',
                                                        ]) !!}
                                                        {!! Form::button(__('Get JS Data'), ['class' => 'd-none', 'id' => 'getJS']) !!}
                                                        {!! Form::button(__('Set Data'), ['class' => 'd-none', 'id' => 'setData']) !!}
                                                        {!! Form::button(__('Add Field'), ['class' => 'd-none', 'id' => 'addField']) !!}
                                                        {!! Form::button(__('Remove Field'), ['class' => 'd-none', 'id' => 'removeField']) !!}
                                                        {!! Form::submit(__('Test Submit'), ['class' => 'd-none', 'id' => 'testSubmit']) !!}
                                                        {!! Form::button(__('Reset Demo'), ['class' => 'd-none', 'id' => 'resetDemo']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqueryform/css/demo.css') }}">
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
@endpush
@push('script')
    <script>
        var lang = '{{ app()->getLocale() }}';
        var lang_other = '{{ __('Other') }}';
        var lang_other_placeholder = '{{ __('Enter Please') }}';
        var lang_Page = '{{ __('Page') }}';
        var lang_Custom_Autocomplete = '{{ __('Custom Autocomplete') }}';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('vendor/jqueryform/js/signaturePad.umd.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/vendor.js') }}"></script>
    <script src="{{ asset('vendor/modules/jquery.nicescroll.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-builder.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-render.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/demoFirst.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>

@endpush
