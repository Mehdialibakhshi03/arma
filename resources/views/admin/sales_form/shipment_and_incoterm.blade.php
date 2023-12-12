<div class="col-12">
    <hr>
    <strong>Partial Shipment & incoterms</strong>
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
<div class="col-12 col-md-6 mb-3">
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
    <textarea rows="1"
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
            name="{{ filed_name($name) }}" class="form-control ">
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
    <select onchange="hasOther(this)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control ">
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
            name="{{ filed_name($name) }}" class="form-control ">
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
        $name='Port/City';
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
    <textarea rows="2"
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
