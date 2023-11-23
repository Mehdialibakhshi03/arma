@extends('admin.layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('View Form') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('admin.forms.index'), __('Forms'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('View Form') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        @if (!empty($form_value->Form->logo))
            <div class="text-center gallery gallery-md">
                {!! Form::image(
                    Storage::exists($form_value->Form->logo)
                        ? asset('storage/app/' . $form_value->Form->logo)
                        : Storage::url('uploads/appLogo/78x78.png'),
                    null,
                    [
                        'class' => 'gallery-item float-none',
                        'id' => 'app-dark-logo',
                    ],
                ) !!}
            </div>
        @endif
        {{--  {{ dd($form_value) }}  --}}
        <div class="card col-12 mx-auto p-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>


                    <h2 class="mb-3"> {{ $form_value->Form->title }} {{ $form_value->parent!=0 ? '(copied)' : '' }}</h2>
                    <h5>Status: {{ $form_value->Status->title }}</h5>
                </div>

                <div class="float-end justify-content-between d-flex">
                    @can('commodity-change-status')
                        @if($form_value->Status->id==1)
                            <button onclick="ChangeFormValueStatus({{ $form_value->id }},2)" type="button"
                                    class="btn btn-danger ml5">{{ __('Deny') }}</button>
                        @endif

                        @if($form_value->Status->id==2)
                            <button onclick="ChangeFormValueStatus({{ $form_value->id }},1)" type="button"
                                    class="btn btn-success ml5">{{ __('Approve') }}</button>
                        @endif

                        @if($form_value->Status->id==0)
                            <button onclick="ChangeFormValueStatus({{ $form_value->id }},1)" type="button"
                                    class="btn btn-success ml5">{{ __('Approve') }}</button>
                            <button onclick="ChangeFormValueStatus({{ $form_value->id }},2)" type="button"
                                    class="btn btn-danger ml5">{{ __('Deny') }}</button>
                        @endif
                    @endcan

                    @can('commodity-submit-preview')
                        @if($form_value->status==3)
                            <button onclick="FormPending({{ $form_value->id }})"
                                    class="btn btn-info mr5">{{ __('Submit') }}</button>
                        @endif
                    @endcan

                </div>

            </div>
            <div class="card-body">
                <div class="view-form-data">
                    <div class="row">
                        @foreach ($array as $keys => $rows)
                            {{--  {{ dd($array) }}  --}}
                            @foreach ($rows as $row_key => $row)
                                {{--  {{ dd($rows) }}  --}}
                                @if ($row->type == 'checkbox-group')
                                    <div class="col-12">
                                        <b>{{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                        </b>
                                        <p>
                                        <ul>
                                            @foreach ($row->values as $key => $options)
                                                @if (isset($options->selected))
                                                    <li>
                                                        <label>{{ $options->label }}</label>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        </p>
                                    </div>
                                @elseif($row->type == 'file')
                                    <div class="col-12">
                                        <b>{{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                        </b>
                                        <p>
                                        @if (isset($row->value))
                                            @if ($row->multiple)
                                                <div class="row">
                                                    @foreach ($row->value as $img)
                                                        <div class="col-xl-6 col-12">
                                                            @if (pathinfo($img, PATHINFO_EXTENSION) == 'pdf' ||
                                                                    pathinfo($img, PATHINFO_EXTENSION) == 'csv' ||
                                                                    pathinfo($img, PATHINFO_EXTENSION) == 'xlsx')
                                                                @php
                                                                    $filename = explode('/', $img);
                                                                    $filename = end($filename);
                                                                @endphp
                                                                <a class="btn btn-info my-2"
                                                                   href="{{ asset('storage/app/' . $img) }}"
                                                                   type="image"
                                                                   download="">{{ $filename }}</a>
                                                            @else
                                                                {!! Form::image(
                                                                    Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('uploads/appLogo/78x78.png'),
                                                                    null,
                                                                    [
                                                                        'class' => 'img-responsive img-thumbnailss mb-2 card-img-top card-img-custom',
                                                                    ],
                                                                ) !!}
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-xl-6 col-12">
                                                        @if ($row->subtype == 'fineuploader')
                                                            @if ($row->value[0])
                                                                @foreach ($row->value as $img)
                                                                    @php
                                                                        $filename = explode('/', $img);
                                                                        $filename = end($filename);
                                                                    @endphp
                                                                    @if (pathinfo($img, PATHINFO_EXTENSION) == 'pdf' ||
                                                                            pathinfo($img, PATHINFO_EXTENSION) == 'csv' ||
                                                                            pathinfo($img, PATHINFO_EXTENSION) == 'xlsx')
                                                                        <a class="btn btn-info my-2"
                                                                           href="{{ asset('storage/app/' . $img) }}"
                                                                           type="image"
                                                                           download="">{{ $filename }}</a>
                                                                    @else
                                                                        {!! Form::image(
                                                                            Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('uploads/appLogo/78x78.png'),
                                                                            null,
                                                                            [
                                                                                'class' => 'img-responsive img-thumbnailss mb-2 card-img-top card-img-custom',
                                                                            ],
                                                                        ) !!}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @else
                                                            @if (pathinfo($row->value, PATHINFO_EXTENSION) == 'pdf' ||
                                                                    pathinfo($row->value, PATHINFO_EXTENSION) == 'csv' ||
                                                                    pathinfo($row->value, PATHINFO_EXTENSION) == 'xlsx')
                                                                @php
                                                                    $filename = explode('/', $row->value);
                                                                    $filename = end($filename);
                                                                @endphp
                                                                <a class="btn btn-info my-2"
                                                                   href="{{ asset('storage/app/' . $row->value) }}"
                                                                   type="image"
                                                                   download="">{{ $filename }}</a>
                                                            @else
                                                                {!! Form::image(
                                                                    Storage::exists($row->value) ? url('storage/app/' . $row->value) : Storage::url('uploads/appLogo/78x78.png'),
                                                                    null,
                                                                    [
                                                                        'class' => 'img-responsive img-thumbnailss mb-2 card-img-top card-img-custom',
                                                                    ],
                                                                ) !!}
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                                @endif
                                                </p>
                                    </div>
                                @elseif($row->type == 'header')
                                    <div class="col-12">
                                        <{{ $row->subtype }}>
                                        {{ isset($row->label) ? $row->label : '' }}
                                    </{{ $row->subtype }}>
                    </div>
                    @elseif($row->type == 'paragraph')
                        <div class="col-12">
                            <{{ $row->subtype }}>
                            {{ $row->label }}
                        </{{ $row->subtype }}>
                </div>
                @elseif($row->type == 'radio-group')
                    <div class="col-12">
                        <b>
                            @if(isset($row->label))
                                {{ Form::label($row->name, $row->label) }}
                            @endif
                            @if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        <p>
                            @foreach ($row->values as $key => $options)
                                @if (isset($options->selected))
                                    {{ $options->label }}
                                @endif
                            @endforeach
                        </p>
                    </div>
                @elseif($row->type == 'select')
                    <div class="col-12">
                        <b>{{ Form::label($row->name, $row->label) }}@if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        <p>
                            @foreach ($row->values as $options)
                                @if (isset($options->selected))
                                    {{ $options->label }}
                                @endif
                            @endforeach
                        </p>
                    </div>
                @elseif($row->type == 'autocomplete')
                    <div class="col-12">
                        <b>{{ Form::label($row->name, $row->label) }}@if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        <p>
                            @foreach ($row->values as $options)
                                @if (isset($options->selected))
                                    {{ $options->label }}
                                @endif
                            @endforeach
                        </p>
                    </div>
                @elseif($row->type == 'number')
                    <div class="col-12">
                        <b>{{ Form::label($row->name, $row->label) }}@if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        <p>
                            {{ isset($row->value) ? $row->value : '' }}
                        </p>
                    </div>
                @elseif($row->type == 'text')
                    <div class="col-12">
                        <b>@if(isset($row->label))
                                {{ Form::label($row->name, $row->label) }}
                            @endif @if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b><br>
                        @if ($row->subtype == 'color')
                            <div
                                style="padding: 10px; margin-top: 10px;background-color: {{ $row->value }};">
                            </div>
                        @else
                            <p>
                                {{ isset($row->value) ? $row->value : '' }}
                            </p>
                        @endif
                    </div>
                @elseif($row->type == 'date')
                    <div class="col-12">
                        <b>{{ Form::label($row->name, $row->label) }}@if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        <p>
                            {{ isset($row->value) ? date('d-m-Y', strtotime($row->value)) : '' }}
                        </p>
                    </div>
                @elseif($row->type == 'textarea')
                    <div class="col-12">
                        <b>
                            @if(isset($row->label))
                                {{ Form::label($row->name, $row->label) }}
                            @endif
                            @if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        @if ($row->subtype == 'ckeditor')
                            {!! isset($row->value) ? $row->value : '' !!}
                        @else
                            <p>
                                {{ isset($row->value) ? $row->value : '' }}
                            </p>
                        @endif
                    </div>
                @elseif($row->type == 'starRating')
                    <div class="col-12">
                        @php
                            $attr = ['class' => 'form-control'];
                            if ($row->required) {
                                $attr['required'] = 'required';
                            }
                            $value = isset($row->value) ? $row->value : 0;
                            $no_of_star = isset($row->number_of_star) ? $row->number_of_star : 5;
                        @endphp
                        <b> {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        <p>
                        <div id="{{ $row->name }}" class="starRating" data-value="{{ $value }}"
                             data-no_of_star="{{ $no_of_star }}">
                        </div>
                        {!! Form::hidden($row->name, $value, ['id' => $row->name]) !!}
                        </p>
                    </div>
                @elseif($row->type == 'SignaturePad')
                    <div class="col-12">
                        <img src="{{ asset(Storage::url($row->value)) }}">
                    </div>
                @elseif($row->type == 'break')
                    <div class="col-12">
                        <hr style="border: 1px solid #ccc">
                    </div>
                @elseif($row->type == 'location')
                    @php
                        $lat = $row->value->lat;
                        $lng = $row->value->lng;
                    @endphp
                    {{--  {{ dd($array ,$lat,$lng) }}  --}}
                    <div class="col-12">
                        <div class="form-group">
                            {!! Form::label('location_id', 'Location:') !!}
                            <iframe width="100%" height="260" frameborder="0" scrolling="no"
                                    marginheight="0" marginwidth="0"
                                    src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&hl=en&z=14&amp;output=embed">
                            </iframe>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <b>{{ Form::label($row->name, isset($row->label)) }}@if (isset($row->required))
                                <span class="text-danger align-items-center">*</span>
                            @endif
                        </b>
                        <p>
                            {{ isset($row->value) ? $row->value : '' }}
                        </p>
                    </div>
                @endif
                @endforeach
                @endforeach
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet"/>
@endpush
@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script>
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function () {
                var val = $(this).attr('data-value');
                var no_of_star = $(this).attr('data-no_of_star');
                if (no_of_star == 10) {
                    val = val / 2;
                }
                $(this).rateYo({
                    rating: val,
                    readOnly: true,
                    numStars: no_of_star
                })
            });
        }
    </script>
    <script>
        function ChangeFormValueStatus(form_id, status) {
            $.ajax({
                url: "{{ route('admin.formValue.changeStatus') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    form_id: form_id,
                    status: status,
                },
                method: "Post",
                dataType: "json",
                success: function (msg) {
                    if (msg[0] === 1) {
                        window.location.href=msg[1];
                    }
                },
            })
        }
    </script>

@endpush
