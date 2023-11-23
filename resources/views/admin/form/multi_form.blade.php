@php
    use App\Facades\UtilityFacades;
@endphp
@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
@endphp
<div class="section-body">
    <div class="row mx-0 mt-5">
        <div class="col-md-12 mx-auto">
            @if (!empty($form->logo))
                <div class="text-center gallery gallery-md mb-2">
                    <img id="app-dark-logo" class="gallery-item float-none"
                         src="{{ Storage::exists($form->logo) ? asset('storage/app/' . $form->logo) : Storage::url('uploads/appLogo/78x78.png') }}">
                </div>
            @endif
            @if (session()->has('success'))
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100">{{ $form->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center gallery" id="success_loader">
                            <img src="{{ asset('assets/images/success.gif') }}"/>
                            <br>
                            <br>
                            <h2 class="w-100 ">{{ session()->get('success') }}</h2>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100">{{ $form->title }}</h5>
                        @if(isset($form_value) and $form_value->status==3)
                            <button onclick="FormPending({{ $form_value->id }})"
                                    class="btn btn-info mr5">{{ __('Submit') }}</button>
                        @endif
                    </div>
                    <div class="card-body form-card-body">
                        <form action="{{ route('admin.forms.fill.store', $form->id) }}" method="POST"
                              enctype="multipart/form-data" id="fill-form">
                            @method('PUT')
                            @if (isset($array))
                                @foreach ($array as $keys => $rows)
                                    {{--  {{ dd($array) }}  --}}
                                    <div class="tab">
                                        <div class="row">
                                            @foreach ($rows as $row_key => $row)
                                                @php
                                                    if (isset($row->column)) {
                                                        if ($row->column == 1) {
                                                            $col = 'col-12 step-' . $keys;
                                                        } elseif ($row->column == 2) {
                                                            $col = 'col-6 step-' . $keys;
                                                        } elseif ($row->column == 3) {
                                                            $col = 'col-4 step-' . $keys;
                                                        }
                                                    } else {
                                                        $col = 'col-12 step-' . $keys;
                                                    }
                                                @endphp
                                                {{--  {{ dd($col) }}  --}}
                                                @if ($row->type == 'checkbox-group')
                                                    <div class="form-group {{ $col }} ">
                                                        <label for="{{ $row->name }}"
                                                               class="d-block form-label">{{ $row->label }}
                                                            @if ($row->required)
                                                                <span class="text-danger align-items-center">*</span>
                                                            @endif
                                                            @if (isset($row->description))
                                                                <span type="button" class="tooltip-element"
                                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                                      title="{{ $row->description }}">
                                                                    ?
                                                                </span>
                                                            @endif
                                                        </label>
                                                        @foreach ($row->values as $key => $options)
                                                            @php
                                                                $attr = ['class' => 'form-check-input', 'id' => $row->name . '_' . $key];
                                                                $attr['name'] = $row->name . '[]';
                                                                if ($row->required) {
                                                                    $attr['required'] = 'required';
                                                                    $attr['class'] = $attr['class'] . ' required';
                                                                }
                                                                if ($row->inline) {
                                                                    $class = 'form-check form-check-inline col-4 ';
                                                                    if ($row->required) {
                                                                        $attr['class'] = 'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label mb-0 ml-1';
                                                                } else {
                                                                    $class = 'form-check';
                                                                    if ($row->required) {
                                                                        $attr['class'] = 'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label';
                                                                }
                                                            @endphp
                                                            <div class="{{ $class }}">
                                                                {{ Form::checkbox($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, $attr) }}
                                                                <label class="{{ $l_class }}"
                                                                       for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                            </div>
                                                        @endforeach
                                                        @if ($row->required)
                                                            <label class="required-msg" style="color:red"></label>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'file')
                                                    @php
                                                        $attr = [];
                                                        $attr['class'] = 'form-control upload';
                                                        if ($row->multiple) {
                                                            $maxupload = 10;
                                                            $attr['multiple'] = 'true';
                                                            if ($row->subtype != 'fineuploader') {
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                        }
                                                        if ($row->required && (!isset($row->value) || empty($row->value))) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        if ($row->subtype == 'fineuploader') {
                                                            $attr['class'] = $attr['class'] . ' ' . $row->name;
                                                        }
                                                    @endphp
                                                    <div class="form-group {{ $col }}">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if (isset($row->description))
                                                            <span type="button" class="tooltip-element"
                                                                  data-bs-toggle="tooltip" data-bs-placement="top"
                                                                  title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                                        @endif
                                                        @if ($row->subtype == 'fineuploader')
                                                            <div class="dropzone" id="{{ $row->name }}">
                                                            </div>
                                                            {!! Form::hidden($row->name, null, $attr) !!}
                                                        @else
                                                            {{ Form::file($row->name, $attr) }}
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'header')
                                                    @php
                                                        $class = '';
                                                        if (isset($row->className)) {
                                                            $class = $class . ' ' . $row->className;
                                                        }
                                                    @endphp
                                                    <div class="{{ $col }}">

                                                        <{{ $row->subtype }} class
                                                        ="{{ $class }}">
                                                        {{ isset($row->label) ? $row->label : '' }}
                                                    </{{ $row->subtype }}>
                                        </div>
                                        @elseif($row->type == 'paragraph')
                                            @php
                                                $class = '';
                                                if (isset($row->className)) {
                                                    $class = $class . ' ' . $row->className;
                                                }
                                            @endphp
                                            <div class="{{ $col }}">
                                                <{{ $row->subtype }} class
                                                ="{{ $class }}">
                                                {!! html_entity_decode($row->label) !!}
                                            </{!! $row->subtype !!}>
                                    </div>
                                    @elseif($row->type == 'radio-group')
                                        <div class="form-group {{ $col }}">
                                            <label for="{{ $row->name }}"
                                                   class="d-block form-label">{{ isset($row->label) ? $row->label : '' }}
                                                @if ($row->required)
                                                    <span class="text-danger align-items-center">*</span>
                                                @endif
                                                @if (isset($row->description))
                                                    <span type="button" class="tooltip-element"
                                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                                          title="{{ $row->description }}">
                                                                    ?
                                                                </span>
                                                @endif
                                            </label>
                                            @foreach ($row->values as $key => $options)
                                                @php
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                        $attr = ['class' => 'form-check-input required', 'required' => 'required', 'id' => $row->name . '_' . $key];
                                                    } else {
                                                        $attr = ['class' => 'form-check-input', 'id' => $row->name . '_' . $key];
                                                    }
                                                    if ($row->inline) {
                                                        $class = 'form-check form-check-inline ';
                                                        if ($row->required) {
                                                            $attr['class'] = 'form-check-input required';
                                                        } else {
                                                            $attr['class'] = 'form-check-input';
                                                        }
                                                        $l_class = 'form-check-label mb-0 ml-1';
                                                    } else {
                                                        $class = 'form-check';
                                                        if ($row->required) {
                                                            $attr['class'] = 'form-check-input required';
                                                        } else {
                                                            $attr['class'] = 'form-check-input';
                                                        }
                                                        $l_class = 'form-check-label';
                                                    }
                                                @endphp
                                                <div class=" {{ $class }}">
                                                    {{ Form::radio($row->name, $options->value, isset($options->selected) && $options->selected ? true : false, $attr) }}
                                                    <label class="{{ $l_class }}"
                                                           for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                </div>
                                            @endforeach
                                            @if ($row->required)
                                                <label class="required-msg " style="color:red"></label>
                                            @endif
                                        </div>
                                    @elseif($row->type == 'select' || $row->type == 'autocomplete')
                                        <div class="form-group {{ $col }}">
                                            @php
                                                $attr = ['class' => 'form-select w-100', 'id' => 'sschoices-multiple-remove-button', 'data-trigger'];
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
                                                    $attr['class'] = $attr['class'] . ' required';
                                                }
                                                if (isset($row->multiple) && !empty($row->multiple)) {
                                                    $attr['multiple'] = 'true';
                                                    $attr['name'] = $row->name . '[]';
                                                }
                                                if (isset($row->className) && $row->className == 'calculate') {
                                                    $attr['class'] = $attr['class'] . ' ' . $row->className;
                                                }
                                                if ($row->label == 'Registration') {
                                                    $attr['class'] = $attr['class'] . ' registration';
                                                }
                                                if (isset($row->is_parent) && $row->is_parent == 'true') {
                                                    $attr['class'] = $attr['class'] . ' parent';
                                                    $attr['data-number-of-control'] = isset($row->number_of_control) ? $row->number_of_control : 1;
                                                }
                                                $values = [];
                                                $selected = [];
                                                foreach ($row->values as $options) {
                                                    $values[$options->value] = $options->label;
                                                    if (isset($options->selected) && $options->selected) {
                                                        $selected[] = $options->value;
                                                    }
                                                }
                                            @endphp
                                            @if (isset($row->is_parent) && $row->is_parent == 'true')
                                                {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                    <span class="text-danger align-items-center">*</span>
                                                @endif
                                                <div class="input-group">
                                                    {{ Form::select($row->name, $values, $selected, $attr) }}
                                                </div>
                                            @else
                                                {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                @if ($row->required)
                                                    <span class="text-danger align-items-center">*</span>
                                                @endif
                                                @if (isset($row->description))
                                                    <span type="button" class="tooltip-element"
                                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                                          title="{{ $row->description }}">?</span>
                                                @endif
                                                {{ Form::select($row->name, $values, $selected, $attr) }}
                                            @endif
                                            @if ($row->label == 'Registration')
                                                <span class="text-warning registration-message"></span>
                                            @endif
                                        </div>
                                    @elseif($row->type == 'date')
                                        <div class="form-group {{ $col }}">
                                            @php
                                                $attr = ['class' => 'form-control'];
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
                                                    $attr['class'] = $attr['class'] . ' required';
                                                }
                                            @endphp
                                            {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                            @if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                            @if (isset($row->description))
                                                <span type="button" class="tooltip-element"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                            @endif
                                            {{ Form::date($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                        </div>
                                    @elseif($row->type == 'hidden')
                                        <div class="form-group {{ $col }}">
                                            {{ Form::hidden($row->name, isset($row->value) ? $row->value : null) }}
                                        </div>
                                    @elseif($row->type == 'number')
                                        <div class="form-group {{ $col }}">
                                            @php
                                                $row_class = isset($row->className) ? $row->className : '';
                                                $attr = ['class' => 'form-control number ' . $row_class];
                                                if (isset($row->min)) {
                                                    $attr['min'] = $row->min;
                                                }
                                                if (isset($row->max)) {
                                                    $attr['max'] = $row->max;
                                                }
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
                                                    $attr['class'] = $attr['class'] . ' required ' . $row_class;
                                                }
                                            @endphp
                                            {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                            @if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                            @if (isset($row->description))
                                                <span type="button" class="tooltip-element"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                            @endif
                                            {{ Form::number($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                        </div>
                                    @elseif($row->type == 'textarea')
                                        <div class="form-group {{ $col }}">
                                            @php
                                                $attr = ['class' => 'form-control text-area-height'];
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
                                                    $attr['class'] = $attr['class'] . ' required';
                                                }
                                                if (isset($row->rows)) {
                                                    $attr['rows'] = $row->rows;
                                                } else {
                                                    $attr['rows'] = '3';
                                                }
                                                if (isset($row->placeholder)) {
                                                    $attr['placeholder'] = $row->placeholder;
                                                }
                                                if ($row->subtype == 'ckeditor') {
                                                    $attr['class'] = $attr['class'] . ' ck_editor';
                                                }
                                            @endphp
                                            @if(isset($row->label) and $row->label!='')
                                                {{ Form::label($row->name, $row->label) }}
                                            @endif
                                            @if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                            @if (isset($row->description))
                                                <span type="button" class="tooltip-element"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                            @endif
                                            {{ Form::textarea($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                        </div>
                                    @elseif($row->type == 'button')
                                        <div class="form-group {{ $col }}">
                                            @if (isset($row->value) && !empty($row->value))
                                                <a href="{{ $row->value }}" target="_new"
                                                   class="{{ $row->className }}">{{ __($row->label) }}</a>
                                            @else
                                                {{ Form::button(__($row->label), ['name' => $row->name, 'type' => $row->subtype, 'class' => $row->className, 'id' => $row->name]) }}
                                            @endif
                                        </div>
                                    @elseif($row->type == 'text')
                                        <div class="form-group {{ $col }}">
                                            @php
                                                $attr = ['class' => 'form-control ' . $row->subtype];
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
                                                    $attr['class'] = $attr['class'] . ' required';
                                                }
                                                if (isset($row->maxlength)) {
                                                    $attr['max'] = $row->maxlength;
                                                }
                                                if (isset($row->placeholder)) {
                                                    $attr['placeholder'] = $row->placeholder;
                                                }
                                                $value = isset($row->value) ? $row->value : '';
                                                if ($row->subtype == 'datetime-local') {
                                                    $row->subtype = 'datetime-local';
                                                    $attr['class'] = $attr['class'] . ' date_time';
                                                }
                                            @endphp
                                            @if(isset($row->label))
                                                @if($row->label!='')
                                                    {{ Form::label($row->name,$row->label , ['class' => 'form-label']) }}
                                                @endif
                                            @endif
                                            @if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                            @if (isset($row->description))
                                                <span type="button" class="tooltip-element"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                            @endif
                                            {{ Form::input($row->subtype, $row->name, $value, $attr) }}
                                        </div>
                                    @elseif($row->type == 'starRating')
                                        <div class="form-group {{ $col }}">
                                            @php
                                                $value = isset($row->value) ? $row->value : 0;
                                                $num_of_star = isset($row->number_of_star) ? $row->number_of_star : 5;
                                            @endphp
                                            {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                            @if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                            @if (isset($row->description))
                                                <span type="button" class="tooltip-element"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                            @endif
                                            <div id="{{ $row->name }}" class="starRating"
                                                 data-value="{{ $value }}"
                                                 data-num_of_star="{{ $num_of_star }}">
                                            </div>
                                            <input type="hidden" name="{{ $row->name }}"
                                                   value="{{ $value }}" class="calculate"
                                                   data-star="{{ $num_of_star }}">
                                        </div>
                                    @elseif($row->type == 'SignaturePad')
                                        @php
                                            $attr = ['class' => $row->name];
                                            if ($row->required) {
                                                $attr['required'] = 'required';
                                                $attr['class'] = $attr['class'] . ' required';
                                            }
                                            $value = isset($row->value) ? $row->value : null;
                                        @endphp
                                        <div class="row form-group {{ $col }}">
                                            <div class="col-12">
                                                <label for="{{ $row->name }}"
                                                       class="form-label">{{ $row->label }}</label>
                                                @if ($row->required)
                                                    <span class="text-danger align-items-center">*</span>
                                                @endif
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <div class="signature-pad-body">
                                                    <canvas class="signaturePad form-control"
                                                            id="{{ $row->name }}"></canvas>
                                                    {!! Form::hidden($row->name, $value, $attr) !!}
                                                    <div class="buttons signature_buttons">
                                                        <button id="save{{ $row->name }}"
                                                                type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                data-bs-original-title="{{ __('Save') }}"
                                                                class="btn btn-primary btn-sm">{{ __('Save') }}</button>
                                                        <button id="clear{{ $row->name }}"
                                                                type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                data-bs-original-title="{{ __('Clear') }}"
                                                                class="btn btn-danger btn-sm">{{ __('Clear') }}</button>
                                                        <button id="showPointsToggle{{ $row->name }}"
                                                                type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                data-bs-original-title="{{ __('Show Points?') }}"
                                                                class="btn btn-info btn-sm show-point toggle">{{ __('Show Points?') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (@$row->value != '')
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <img src="{{ Storage::url($row->value) }}"
                                                         width="80%" class="border" alt="">
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($row->type == 'break')
                                        <hr style="border: 1px solid #ccc">
                                    @elseif($row->type == 'location')
                                        @php
                                            @$lat = $row->value->lat;
                                            @$lng = $row->value->lng;
                                        @endphp
                                        <div class="col-12 form-group locations">
                                            <label for="{{ $row->name }}"
                                                   class="form-label">{{ $row->label }}</label>
                                            @if ($row->required)
                                                <span class="text-danger align-items-center">*</span>
                                            @endif
                                            @if ($row->value != '1' && $row->value != '0')
                                                <iframe width="100%" height="250px" frameborder="0"
                                                        scrolling="no" marginheight="0" marginwidth="0"
                                                        src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&hl=en&z=14&amp;output=embed"></iframe>
                                            @else
                                                <div id="{{ $row->name }}"
                                                     class="somecomponent location_style"></div>
                                            @endif
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('latitude', __('Latitude'), ['class' => 'form-label']) !!}
                                                        {!! Form::text($row->name . '[' . $row_key . '][latitude]', isset($row->value) ? $lat : old('latitude'), [
                                                            'class' => 'form-control',
                                                            'id' => 'latitude',
                                                            'placeholder' => __('Enter latitude'),
                                                            'readonly',
                                                        ]) !!}
                                                        @if ($errors->has('latitude'))
                                                            <span class="text-danger" role="alert">
                                                                            <strong>{{ $errors->first('latitude') }}</strong>
                                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('longitude', __('Longitude'), ['class' => 'form-label']) !!}
                                                        {!! Form::text($row->name . '[' . $row_key . '][longitude]', isset($row->value) ? $lat : old('longitude'), [
                                                            'class' => 'form-control',
                                                            'id' => 'longitude',
                                                            'placeholder' => __('Enter longitude'),
                                                            'readonly',
                                                        ]) !!}
                                                        @if ($errors->has('longitude'))
                                                            <span class="text-danger" role="alert">
                                                                            <strong>{{ $errors->first('longitude') }}</strong>
                                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
            @if (!isset($form_value) && $form->payment_status == 1)
                @if (!isset($form_value) && $form->payment_type == 'stripe')
                    <div class="strip">
                        <strong class="d-block">{{ __('Payment') }}
                            ({{ $form->currency_symbol }}{{ $form->amount }})</strong>
                        <div id="card-element" class="form-control">
                        </div>
                        <span id="card-errors" class="payment-errors" style=" "></span>
                        <br>
                    </div>
                @elseif(!isset($form_value) && $form->payment_type == 'razorpay')
                    <div class="razorpay">
                        <p>{{ __('Make Payment') }}</p>
                        <input type="hidden" name="payment_id" id="payment_id">
                        <h5>{{ __('Payable Amount') }} : {{ $form->currency_symbol }}
                            {{ $form->amount }}</h5>
                    </div>
                @elseif(!isset($form_value) && $form->payment_type == 'paypal')
                    <div class="paypal">
                        <p>{{ __('Make Payment') }}</p>
                        <input type="hidden" name="payment_id" id="payment_id">
                        <h5>{{ __('Payable Amount') }} : {{ $form->currency_symbol }}
                            {{ $form->amount }}</h5>
                        <div id="paypal-button-container"></div>
                        <span id="paypal-errors" class="payment-errors"
                              style="color: red; font-size: 22px; "></span>
                        <br>
                    </div>
                @elseif(!isset($form_value) && $form->payment_type == 'paytm')
                    <div class="paytm">
                        <p>{{ __('Make Payment') }}</p>
                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                            {{ $form->amount }}</h5>
                    </div>
                @elseif(!isset($form_value) && $form->payment_type == 'flutterwave')
                    <div class="flutterwave">
                        <p>{{ __('Make Payment') }}</p>
                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                            {{ $form->amount }}</h5>
                    </div>
                @elseif(!isset($form_value) && $form->payment_type == 'paystack')
                    <div class="paystack">
                        <p>{{ __('Make Payment') }}</p>
                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                            {{ $form->amount }}</h5>
                    </div>
                @elseif(!isset($form_value) && $form->payment_type == 'coingate')
                    <div class="coingate">
                        <p>{{ __('Make Payment') }}</p>
                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                            {{ $form->amount }}</h5>
                    </div>
                @elseif(!isset($form_value) && $form->payment_type == 'mercado')
                    <div class="mercado">
                        <p>{{ __('Make Payment') }}</p>
                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                            {{ $form->amount }}</h5>
                    </div>
                @endif
            @endif

            <div class="row">
                <div class="col cap">
                    @if (UtilityFacades::getsettings('CAPTCHASETTING'))
                        @if (setting('captcha') == 'hcaptcha')
                            {!! HCaptcha::renderJs() !!}
                            {!! HCaptcha::display() !!}
                        @endif
                        @if (setting('captcha') == 'recaptcha')
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        @endif
                    @endif
                    <div class="form-actions pb-0 mt-3">
                        <input type="hidden" name="form_value_id"
                               value="{{ isset($form_value) ? $form_value->id : '' }}"
                               id="form_value_id">
                    </div>
                </div>
            </div>
            <div class="over-auto">
                <div class="float-right">
                    {!! Form::button(__('Previous'), ['class' => 'btn btn-default', 'id' => 'prevBtn', 'onclick' => 'nextPrev(-1)']) !!}
                    {!! Form::button(__('Next'), ['class' => 'btn btn-primary', 'id' => 'nextBtn', 'onclick' => 'nextPrev(1)']) !!}
                </div>
            </div>
            <div class="extra_style">
                @if (isset($array))
                    @foreach ($array as $keys => $rows)
                        <span class="step"></span>
                    @endforeach
                @endif
            </div>
            </form>
{{--            {!! Form::open(['route' => ['coingateprepare'], 'method' => 'post', 'id' => 'coingate_payment_frms']) !!}--}}
            {{ Form::hidden('cg_currency', null, ['id' => 'cg_currency']) }}
            {{ Form::hidden('cg_amount', null, ['id' => 'cg_amount']) }}
            {{ Form::hidden('cg_form_id', null, ['id' => 'cg_form_id']) }}
            {!! Form::hidden('cg_submit_type', null, ['id' => 'cg_submit_type']) !!}
            {!! Form::close() !!}
{{--            {!! Form::open(['route' => ['mercadofillprepare'], 'method' => 'post', 'id' => 'mercado_payment_frms']) !!}--}}
            {{ Form::hidden('mercado_amount', null, ['id' => 'mercado_amount']) }}
            {{ Form::hidden('mercado_form_id', null, ['id' => 'mercado_form_id']) }}
            {{ Form::hidden('mercado_created_by', null, ['id' => 'mercado_created_by']) }}
            {!! Form::hidden('mercado_submit_type', null, ['id' => 'mercado_submit_type']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    @endif
</div>
</div>
</div>
@if ($form->allow_share_section == 1)
    <div class="row">
        <div class="col-xl-7 mx-auto order-xl-1">
            <div class="card">
                <div class="card-header">
                    <h5><i class="me-2" data-feather="share-2"></i>{{ __('Share') }}</h5>
                </div>
                <div class="card-body ">
                    <div class="form-group col-6 m-auto">
                        <p>{{ __('Use this link to share the poll with your participants.') }}</p>
                        <div class="input-group">
                            <input type="text" value="{{ route('admin.forms.survey', $id) }}"
                                   class="form-control js-content" id="pc-clipboard-1"
                                   placeholder="Type some value to copy">
                            <a href="#" class="btn btn-primary js-copy" data-clipboard="true"
                               data-clipboard-target="#pc-clipboard-1"> {{ __('Copy') }}
                            </a>
                        </div>
                        <div class="mt-3 social-links-share">
                            <a href="https://api.whatsapp.com/send?text={{ route('admin.forms.survey', $id) }}"
                               title="Whatsapp" class="social-links-share-main">
                                <i class="ti ti-brand-whatsapp"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ route('admin.forms.survey', $id) }}"
                               title="Twitter" class="social-links-share-main">
                                <i class="ti ti-brand-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/share.php?u={{ route('admin.forms.survey', $id) }}"
                               title="Facebook" class="social-links-share-main">
                                <i class="ti ti-brand-facebook"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('admin.forms.survey', $id) }}"
                               title="Linkedin" class="social-links-share-main">
                                <i class="ti ti-brand-linkedin"></i>
                            </a>
                            <a href="javascript:void(1);" class="social-links-share-main" title="Show QR Code"
                               data-action="{{ route('admin.forms.survey.qr', $id) }}" id="share-qr-image">
                                <i class="ti ti-qrcode"></i>
                            </a>
                            <a href="javascript:void(0)" title="Embed" class="social-links-share-main"
                               onclick="copyToClipboard('#embed-form-{{ $form->id }}')"
                               id="embed-form-{{ $form->id }}"
                               data-url='<iframe src="{{ route('admin.forms.survey', $id) }}" scrolling="auto" align="bottom" style="height:100vh;" width="100%"></iframe>'>
                                <i class="ti ti-code"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if ($form->allow_comments == 1)
    <div class="row">
        <div class="col-xl-7 mx-auto order-xl-1">
            <div class="card">
                <div class="card-header">
                    <h5><i class="me-2" data-feather="message-circle"></i>{{ __('Comments') }}</h5>
                </div>
                {!! Form::open([
                    'route' => 'form_comment.store',
                    'method' => 'Post',
                ]) !!}
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter your name')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::textarea('comment', null, [
                            'class' => 'form-control',
                            'rows' => '3',
                            'required',
                            'placeholder' => __('Add a comment'),
                        ]) !!}
                    </div>
                </div>
                <input type="hidden" id="form_id" name="form_id" value="{{ $form->id }}">
                <div class="card-footer">
                    <div class="text-end">
                        {!! Form::submit(__('Add a comment'), ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                    @foreach ($form->commmant as $value)
                        <div class="comments-item">
                            <div class="comment-user-icon">
                                <img src="{{ asset('assets/images/comment.png') }}">
                            </div>
                            <span class="comment-info text-left">
                                <h6>{{ $value->name }}</h6>
                                <span class="d-block"><small>{{ $value->comment }}</small></span>
                                <h6 class="d-block"><small>({{ $value->created_at->diffForHumans() }})</small>
                                    <a href="#reply-comment" class="text-dark reply-comment-{{ $value->id }}"
                                       id="comment-reply" data-bs-toggle="collapse" data-id="{{ $value->id }}"
                                       title="{{ __('Reply') }}">
                                        {{ __('Reply') }}</i></a>
                                    @if (Auth::user())
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['form_comment.destroy', $value->id],
                                            'id' => 'delete-form-' . $value->id,
                                            'class' => 'd-inline',
                                        ]) !!}
                                        <a href="#" class="text-dark show_confirm" title="Delete"
                                           id="delete-form-{{ $value->id }}">{{ __('Delete') }}</a>
                                        {!! Form::close() !!}
                                    @endif
                                </h6>
                                <li class="list-inline-item"> </li>
                                @foreach ($value->replyby as $reply_value)
                                    <div class="comment-replies">
                                        <div class="comment-user-icon">
                                            <img src="{{ asset('assets/images/comment.png') }}">
                                        </div>
                                        <div class="comment-replies-content">
                                            <h6>{{ $reply_value->name }}</h6>
                                            <span class="d-block"><small>{{ $reply_value->reply }}</small></span>
                                            <h6 class="d-block">
                                                <small>({{ $reply_value->created_at->diffForHumans() }})</small>
                                        </div>
                                    </div>
                                @endforeach
                            </span>
                        </div>
                        {!! Form::open([
                            'route' => 'form_comment_reply.store',
                            'method' => 'Post',
                            'data-validate',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="row commant" id="reply-comment-{{ $value->id }}">
                            <div class="form-group">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter your name')]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::textarea('reply', null, [
                                    'class' => 'form-control',
                                    'rows' => '2',
                                    'required',
                                    'placeholder' => __('Add a comment'),
                                ]) !!}
                            </div>
                            <input type="hidden" id="form_id" name="form_id" value="{{ $form->id }}">
                            <input type="hidden" id="comment_id" name="comment_id" value="{{ $value->id }}">
                            <div class="card-footer">
                                <div class="text-end">
                                    {!! Form::submit(__('Add a comment'), ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endpush
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('assets/js/plugins/dropzone-amd-module.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/clipboard.min.js') }}"></script>
    <script>
        new ClipboardJS('[data-clipboard=true]').on('success', function (e) {
            e.clearSelection();
        });
    </script>
{{--    <script type="text/javascript"--}}
{{--            src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCQJhryzT4sv3xKSeyFf--hCMOYw-UU1cs&libraries=places'></script>--}}
    <script type="text/javascript" src="{{ asset('vendor/locationpicker/locationpicker.jquery.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            var location = $('.somecomponent').map((_, el) => el.id).get();
            location.forEach(function (val) {
                $('#' + val).locationpicker({
                    location: {
                        latitude: 53.4797326,
                        longitude: -2.2438722
                    },
                    radius: 300,
                    inputBinding: {
                        latitudeInput: $('#' + val).parents('.locations').find('#latitude'),
                        longitudeInput: $('#' + val).parents('.locations').find('#longitude'),
                        radiusInput: $('#' + val).parents('.locations').find('#radius'),
                        locationNameInput: $('#' + val).parents('.locations').find('#places')
                    },
                    enableAutocomplete: true,
                });
            });

            $('body').on('click', '#share-qr-image', function () {
                var action = $(this).data('action');
                var modal = $('#common_modal1');
                $.get(action, function (response) {
                    modal.find('.modal-title').html('{{ __('QR Code') }}');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    modal.modal('show');
                })
            });
            var totaldropzone = $('.dropzone').map((_, el) => el.id).get();
            totaldropzone.forEach(function (val) {
                var myDropzone = new Dropzone("#" + val, {
                    url: "{{ route('admin.dropzone.upload', $form->id) }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    acceptedFiles: ".jpg,.png,.jpeg,application/pdf",
                    maxFiles: '{{ isset($maxupload) ? $maxupload : 1 }}',
                    parallelUploads: '{{ isset($maxupload) ? $maxupload : 1 }}',
                    addRemoveLinks: true,
                    uploadMultiple: true,
                    autoProcessQueue: true,
                    init: function () {
                        this.on('success', function (files, response) {
                            $('.' + val).val(response.file_name);
                            if (response.success) {
                                notifier.show('Done!', response.success, 'success',
                                    '{{ asset('assets/images/notification/ok-48.png') }}',
                                    4000);
                            } else {
                                notifier.show('Error!', response.error, 'danger',
                                    '{{ asset('assets/images/notification/high_priority-48.png') }}',
                                    4000);
                            }
                        });
                    }
                });
            });

            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).data('url')).select();
                document.execCommand("copy");
                $temp.remove();
                notifier.show('Great!', '{{ __('Embed great success.') }}', 'success',
                    '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
            }

            let area = document.createElement('textarea');
            document.body.appendChild(area);
            area.style.display = "none";
            let content = document.querySelectorAll('.js-content');
            let copy = document.querySelectorAll('.js-copy');
            for (let i = 0; i < copy.length; i++) {
                copy[i].addEventListener('click', function () {
                    area.style.display = "block";
                    area.value = content[i].innerText;
                    area.select();
                    document.execCommand('copy');
                    area.style.display = "none";
                    this.innerHTML = 'Copied ';
                    setTimeout(() => this.innerHTML = "Copy", 2000);
                });
            }


            var signaturePad = $('.signaturePad').map((_, el) => el.id).get();

            signaturePad.forEach(function (val) {
                var signaturePad = new SignaturePad(document.getElementById(val), {
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    penColor: 'rgb(0, 0, 0)',
                    velocityFilterWeight: .7,
                    minWidth: 0.5,
                    maxWidth: 2.5,
                    throttle: 16,
                    minPointDistance: 3,

                });
                var saveButton = document.getElementById('save' + val),
                    clearButton = document.getElementById('clear' + val),
                    undoButton = document.getElementById('undo' + val),
                    showPointsToggle = document.getElementById('showPointsToggle' + val);

                saveButton.addEventListener('click', function (event) {
                    var data = signaturePad.toDataURL('image/png');
                    $(this).parents('.signature-pad-body').find('.' + val).val(data);
                });
                clearButton.addEventListener('click', function (event) {
                    signaturePad.clear();
                });
                showPointsToggle.addEventListener('click', function (event) {
                    signaturePad.showPointsToggle();
                    showPointsToggle.classList.toggle('toggle');
                });
            });
        });
    </script>
@endpush
