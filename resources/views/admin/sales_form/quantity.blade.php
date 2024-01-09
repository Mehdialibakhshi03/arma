<div class="col-12">
    <hr>
    <strong>
        Quantity
    </strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Max Quantity';
        $is_required=1;
        $required_span='';
        $required='';
       //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ $value }}">
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
       //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ $value }}">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Tolerance weight';
        $is_required=0;
        $required_span='';
        $required='';
       //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.'(%) '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ $value }}">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Tolerance weight Option By';
        $is_required=0;
        $required_span='';
        $required='';
       //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <select onchange="hasOther(this)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control ">
        @foreach($tolerance_weight_by as $item)
            <option
                {{ $value==$item->title ? ' selected="selected"' : '' }}
                value="{{ $item->title }}">{{ $item->title }}</option>
        @endforeach
    </select>
    @error('has_loading')
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    @php

        $is_required=0;
        $required_span='';
        $required='';
        $name='partial_shipment';
        //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <label for="quality_inspection_report" class="mb-2">Partial
        Shipment</label>
    <div>
        <div class="form-check form-check-inline mr-3">
            <input onchange="addShipmentNumber(this)"
                   {{ $value==='Yes' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="partial_shipment" id="partial_shipment"
                   value="Yes">
            <label class="form-check-label"
                   for="partial_shipment">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input onchange="addShipmentNumber(this)"
                   {{ $value==='No' ? 'checked' : '' }} class="form-check-input"
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
<div class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    @php

        $is_required=1;
        $required_span='';
        $required='';
        $name='increase_quantity';
        //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <label for="{{ filed_name($name) }}" class="mb-2">Is It Possible To Increase Your Max Quantity In This Cargo? {!! $required_span !!} </label>
    <div>
        <div class="form-check form-check-inline mr-3">
            <input onchange="addIncreaseQuantity(this)"
                   {{ $value==='Yes' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ filed_name($name) }}" id="{{ filed_name($name) }}"
                   value="Yes">
            <label class="form-check-label"
                   for="{{ filed_name($name) }}">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input onchange="addIncreaseQuantity(this)"
                   {{ $value==='No' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ filed_name($name) }}" id="{{ filed_name($name) }}"
                   value="No">
            <label class="form-check-label"
                   for="{{ filed_name($name) }}">No</label>
        </div>
    </div>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12">
    <hr>
</div>
