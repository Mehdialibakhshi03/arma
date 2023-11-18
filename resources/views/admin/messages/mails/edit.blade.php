@extends('admin.layouts.main')
@section('title', __('Edit Email Template'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Email Template') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('admin.emails.index'), __('Email Templates'), []) !!}  </li>
            <li class="breadcrumb-item active">{{ __('Edit Email Template') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="layout-px-spacing row">
        <div id="basic" class="col-12 mx-auto layout-spacing">
            <div class="statbox card box box-shadow">
                <div class="card-header">
                    <h5>{{ __('Edit Email Template') }}</h5>
                </div>
                {!! Form::model($mail, [
                    'route' => ['admin.email.update', $mail->id],
                    'method' => 'PUT','data-validate',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="card-body">
                    <div class="row">
                            <div class="form-group col-12 col-md-4">
                                <label class="form-label">Title</label>
                                <input name="title" type="text" value="{{$mail->title}}" class="form-control">
                            </div>

                        <div class="form-group col-12">
                                <label class="form-label">Message</label>
                              <textarea name="text" id="html_template" class="form-control">
                                  {!! $mail->text !!}
                              </textarea>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                {{ Form::label('html_template', __('Html Template'), ['class' => 'form-label']) }}--}}
{{--                                {!! Form::textarea('html_template', null, [--}}
{{--                                    'placeholder' => '',--}}
{{--                                    'class' => 'form-control',--}}
{{--                                ]) !!}--}}
{{--                            </div>--}}

                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        {!! Html::link(route('admin.emails.index'), __('Cancel'), ['class'=>'btn btn-secondary']) !!}
                        {{ Form::submit(__('Save'),['class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        CKEDITOR.replace('html_template', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
