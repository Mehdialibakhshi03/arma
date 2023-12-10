@extends('admin.layouts.main')

@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <a href="#" class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form id="sales_form" method="POST" action="{{ route('admin.sales_form.fil') }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Company Name';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Company Type';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select Your Company Type</option>
                                                        <option value="producer">Producer</option>
                                                        <option value="trading_company">Trading Company</option>
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <strong>
                                                        Note: Only owner of the cargo can submit the form. If the cargo
                                                        is not available and/or you are a broker applying the form is
                                                        not permitted.
                                                    </strong>
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                                <div class="col-12">
                                                    <strong>
                                                        determine Unit and Currency
                                                    </strong>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Unit';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select onchange="hasOther(this)"
                                                            {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select {{ $name }}</option>
                                                        @foreach($unites as $item)
                                                            <option {{ old('unit')==$item->title ? ' selected="selected"' : '' }}
                                                            "
                                                            value="{{ $item->title }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Currency';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select onchange="hasOther(this)"
                                                            {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select {{ $name }}</option>
                                                        @foreach($currencies as $item)
                                                            <option
                                                                {{ old('currency')==$item->title ? ' selected="selected"' : '' }}
                                                                value="{{ $item->title }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                                <div class="col-12">
                                                    <strong>
                                                        Product
                                                    </strong>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Commodity';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Type/Grade';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='HS Code';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Cas No';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    @php
                                                        $name='More Details';
                                                        $is_required=0;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                        $text_area_name='product_'.$name;
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <textarea rows="5"
                                                              {{ $required }} id="{{ filed_name($text_area_name) }}"
                                                              type="text"
                                                              name="{{ filed_name($text_area_name) }}"
                                                              class="form-control">{{ old(filed_name($text_area_name)) }}</textarea>
                                                    @error(filed_name($text_area_name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                                <div class="col-12">
                                                    <strong>
                                                        Quality
                                                    </strong>
                                                </div>
                                                <div class="col-12 text-danger" id="specification_error">
                                                    <strong>
                                                        please write your specification or attach the file <span
                                                            class="text-danger">*</span>
                                                    </strong>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Specification';
                                                        $is_required=0;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="mb-2">Attach</label>
                                                    <input class="form-control" type="file" name="specification_file">
                                                    @error('specification_file')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div
                                                    class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
                                                    <label for="quality_inspection_report" class="mb-2">Do You have the
                                                        quality inspection report? </label>
                                                    <div>
                                                        <div class="form-check form-check-inline mr-3">
                                                            <input onchange="addAttachmentFile(this)"
                                                                   {{ old('quality_inspection_report')==='Yes' ? 'checked' : '' }} class="form-check-input"
                                                                   type="radio"
                                                                   name="quality_inspection_report"
                                                                   id="quality_inspection_report"
                                                                   value="Yes">
                                                            <label class="form-check-label"
                                                                   for="inlineRadio1">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input onchange="addAttachmentFile(this)"
                                                                   {{ old('quality_inspection_report')==='No' ? 'checked' : '' }} class="form-check-input"
                                                                   type="radio"
                                                                   name="quality_inspection_report"
                                                                   id="quality_inspection_report"
                                                                   value="No">
                                                            <label class="form-check-label"
                                                                   for="inlineRadio2">No</label>
                                                        </div>
                                                    </div>
                                                    @error('quality_inspection_report')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Max Quantity';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Min Order';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Tolerance weight';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.'(%) '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Tolerance weight By';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select onchange="hasOther(this)"
                                                            {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select {{ $name }}</option>
                                                        @foreach($tolerance_weight_by as $item)
                                                            <option
                                                                {{ old('tolerance_weight_by')==$item->title ? ' selected="selected"' : '' }}
                                                                value="{{ $item->title }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div
                                                    class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
                                                    <label for="quality_inspection_report" class="mb-2">Partial
                                                        Shipment</label>
                                                    <div>
                                                        <div class="form-check form-check-inline mr-3">
                                                            <input onchange="addShipmentNumber(this)"
                                                                   {{ old('partial_shipment')==='Yes' ? 'checked' : '' }} class="form-check-input"
                                                                   type="radio"
                                                                   name="partial_shipment" id="partial_shipment"
                                                                   value="Yes">
                                                            <label class="form-check-label"
                                                                   for="partial_shipment">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input onchange="addShipmentNumber(this)"
                                                                   {{ old('partial_shipment')==='No' ? 'checked' : '' }} class="form-check-input"
                                                                   type="radio"
                                                                   name="partial_shipment" id="partial_shipment"
                                                                   value="No">
                                                            <label class="form-check-label"
                                                                   for="inlineRadio2">No</label>
                                                        </div>
                                                    </div>
                                                    @error('partial_shipment')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    @php
                                                        $name='More Details';
                                                        $is_required=0;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                        $text_area_name='shipment_'.$name;
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <textarea rows="5"
                                                              {{ $required }} id="{{ filed_name($text_area_name) }}"
                                                              type="text"
                                                              name="{{ filed_name($text_area_name) }}"
                                                              class="form-control">{{ old(filed_name($text_area_name)) }}</textarea>
                                                    @error(filed_name($text_area_name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Incoterms';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select onchange="hasOther(this)"
                                                            {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select {{ $name }}</option>
                                                        @foreach($Incoterms as $item)
                                                            <option
                                                                {{ old('incoterms')==$item->title ? ' selected="selected"' : '' }}
                                                                value="{{ $item->title }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Incoterms Version';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select onchange="hasOther(this)"
                                                            {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select {{ $name }}</option>
                                                        @foreach($incoterms_version as $item)
                                                            <option
                                                                {{ old('incoterms_version')==$item->title ? ' selected="selected"' : '' }}
                                                                value="{{ $item->title }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Country';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select onchange="hasOther(this)"
                                                            {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select {{ $name }}</option>
                                                        @foreach($countries as $item)
                                                            <option
                                                                {{ old('countries')==$item->title ? ' selected="selected"' : '' }}
                                                                value="{{ $item->title }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Port City';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                           name="{{ filed_name($name) }}" class="form-control"
                                                           value="{{ old(filed_name($name)) }}">
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    @php
                                                        $name='More Details';
                                                        $is_required=0;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                        $text_area_name='incoterms_'.$name;
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <textarea rows="5"
                                                              {{ $required }} id="{{ filed_name($text_area_name) }}"
                                                              type="text"
                                                              name="{{ filed_name($text_area_name) }}"
                                                              class="form-control">{{ old(filed_name($text_area_name)) }}</textarea>
                                                    @error(filed_name($text_area_name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class="col-12 col-md-6 mb-3">
                                                    @php
                                                        $name='Price Type';
                                                        $is_required=1;
                                                        $required_span='';
                                                        $required='';
                                                        if ($is_required===1){
                                                            $required_span='<span class="text-danger">*</span>';
                                                            $required='required';
                                                        }
                                                    @endphp
                                                    <label for="{{ filed_name($name) }}"
                                                           class="mb-2">{!! $name.' '.$required_span !!}</label>
                                                    <select onchange="PriceType(this)"
                                                            {{ $required }} id="{{ filed_name($name) }}" type="text"
                                                            name="{{ filed_name($name) }}" class="form-control">
                                                        <option value="">please select {{ $name }}</option>
                                                        @foreach($priceTypes as $item)
                                                            <option
                                                                {{ old('price_type')==$item->title ? ' selected="selected"' : '' }}
                                                                value="{{ $item->title }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error(filed_name($name))
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <button type="button" onclick="submitForm()"
                                                            class="btn btn-success">Create
                                                    </button>
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

@push('style')
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
          integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush

@push('script')
    <!-- MDB -->
    <script>
        $(document).ready(function () {
            check_unit();
            check_currency();
            check_quality_inspection_report_file();
            check_partial_shipment();
            check_incoterms();
            check_price_type();
            show_errors();
        });

        function show_errors(){
            let unit_other = "{{ $errors->has('unit_other') }}";
            if (unit_other) {
                let unit_other_error = "{{ $errors->first('unit_other') }}";
                let error_message = `<p class="input-error-validate">${unit_other_error}</p>`;
                $(error_message).insertAfter($('#unit_other'));
            }
            let currency_other = "{{ $errors->has('currency_other') }}";
            if (currency_other) {
                let currency_other_error = "{{ $errors->first('currency_other') }}";
                let error_message = `<p class="input-error-validate">${currency_other_error}</p>`;
                $(error_message).insertAfter($('#currency_other'));
            }
            let quality_inspection_report_file_error = "{{ $errors->has('quality_inspection_report_file') }}";
            if (quality_inspection_report_file_error) {
                let quality_inspection_report_file = "{{ $errors->first('quality_inspection_report_file') }}";
                let error_message = `<p class="input-error-validate">${quality_inspection_report_file}</p>`;
                $(error_message).insertAfter($('#quality_inspection_report_file'));
            }
            let partial_shipment_number_error = "{{ $errors->has('partial_shipment_number') }}";
            if (partial_shipment_number_error) {
                let partial_shipment_number = "{{ $errors->first('partial_shipment_number') }}";
                let error_message = `<p class="input-error-validate">${partial_shipment_number}</p>`;
                $(error_message).insertAfter($('#partial_shipment_number'));
            }
            let incoterms_other_error = "{{ $errors->has('incoterms_other') }}";
            if (incoterms_other_error) {
                let incoterms_other = "{{ $errors->first('incoterms_other') }}";
                let error_message = `<p class="input-error-validate">${incoterms_other}</p>`;
                $(error_message).insertAfter($('#incoterms_other'));
            }
            let formulla_error = "{{ $errors->has('formulla') }}";
            if (formulla_error) {
                let formulla = "{{ $errors->first('formulla') }}";
                let error_message = `<p class="input-error-validate">${formulla}</p>`;
                $(error_message).insertAfter($('#price_type_select'));
            }
            let price_error = "{{ $errors->has('price') }}";
            if (price_error) {
                let price = "{{ $errors->first('price') }}";
                let error_message = `<p class="input-error-validate">${price}</p>`;
                $(error_message).insertAfter($('#price_type_select'));
            }
        }

        function check_unit() {
            let has_unit_other = {{ old('unit')==='other' ? 1 : 0 }};
            if (has_unit_other) {
                let old_value = "{{ old('unit_other') }}"
                hasOther($('#unit'));
                $('#unit_other').val(old_value);
            }
        }

        function check_currency() {
            let has_currency_other = {{ old('currency')==='other' ? 1 : 0 }};
            if (has_currency_other) {
                let old_value = "{{ old('currency_other') }}"
                hasOther($('#currency'));
                $('#currency_other').val(old_value);
            }
        }

        function check_partial_shipment() {
            let partial_shipment = {{ old('partial_shipment')==='Yes' ? 1 : 0 }};
            if (partial_shipment===1){
                let old_value = "{{ old('partial_shipment_number') }}";
                addShipmentNumber($('#partial_shipment'));
                $('#partial_shipment_number').val(old_value);
            }
        }

        function check_incoterms() {
            let has_incoterms_other = {{ old('incoterms')==='other' ? 1 : 0 }};
            if (has_incoterms_other) {
                let old_value = "{{ old('incoterms_other') }}"
                hasOther($('#incoterms'));
                $('#incoterms_other').val(old_value);
            }
        }

        function check_price_type() {
            let price_type = "{{ old('price_type') }}";

            let previous_val = '';
            if (price_type == 'Fix') {
                PriceType($('#price_type'));
                previous_val = "{{ old('price') }}"
                $('#price_type_select').val(previous_val);
            }
            if (price_type == 'Formulla') {
                PriceType($('#price_type'));

                previous_val = "{{ old('formulla') }}"
                $('#price_type_select').val(previous_val);
            }

        }

        function check_quality_inspection_report_file() {
            let quality_inspection_report = "{{ old('quality_inspection_report')==='Yes' ? true : false }}";
            if (quality_inspection_report) {
                addAttachmentFile($('#quality_inspection_report'));
            }
        }

        function hasOther(tag) {
            let name = $(tag).attr('name');
            let value = $(tag).val();
            if (value === 'other') {
                let element = createOtherElement(name);
                $(element).insertAfter($(tag).parent());
            } else {
                removeOtherElement(name);
            }
        }

        function PriceType(tag) {
            let name = $(tag).attr('name');
            let value = $(tag).val();
            let id = 'price_type_select';
            let field_label = '';
            let field_name = '';
            let field_type = '';
            if (value === 'Formulla') {
                field_label = 'Formulla (Magazine & Index & Discount & Pricing Period)';
                field_name = 'formulla';
                field_type = 'number';
            } else {
                field_label = 'Price';
                field_name = 'price';
                field_type = 'text';
            }
            $('#' + id).parent().remove();
            let element = '<div class="col-12 col-md-6 mb-3"><label for="' + id + `" class="mb-2">${field_label}<span class="text-danger">*</span></label>` +
                '<input required id="' + id + `" type="${field_type}" name="` + field_name + '" class="form-control" ' +
                '</div>';
            $(element).insertAfter($(tag).parent());
        }

        function addShipmentNumber(tag) {
            let value = $(tag).val();
            let field_name = 'partial_shipment_number';
            if (value === 'Yes') {
                let element = '<div class="col-12 col-md-6 mb-3"><label for="' + field_name + `" class="mb-2">Shipment Number<span class="text-danger">*</span></label>` +
                    '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
                    '</div>';
                $(element).insertAfter($(tag).parent().parent().parent());
            } else {
                $(('#' + field_name)).parent().remove();
            }
        }

        function addAttachmentFile(tag) {
            let name = $(tag).attr('name');
            let value = $(tag).val();
            console.log(name, value);
            if (value === 'Yes') {
                let element = createAttachmentElement(name);
                $(element).insertAfter($(tag).parent().parent().parent());
            } else {
                RemoveAttachmentElement(name);
            }
        }

        function createOtherElement(name) {
            let field_name = name + '_other';
            return '<div class="col-12 col-md-6 mb-3"><label for="' + field_name + `" class="mb-2">Write Your ${name} <span class="text-danger">*</span></label>` +
                '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
                '</div>';
        }

        function createAttachmentElement(name) {
            let field_name = name + '_file';
            return `<div class="col-12 col-md-6 mb-3">
                    <label class="mb-2">Attach <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="${field_name}" id="${field_name}">
                    </div>`
        }

        function removeOtherElement(name) {
            let id = name + '_other';
            $('#' + id).parent().remove();
        }

        function RemoveAttachmentElement(name) {
            let id = name + '_file';
            $('#' + id).parent().remove();
        }

        function submitForm() {
            $('#sales_form').submit();
        }

        // $('#FormValues').selectpicker({
        //     'title': 'Select Commodity'
        // });
    </script>
@endpush

