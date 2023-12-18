<div class="col-12">
    <hr>
    <strong>
        Discharging
    </strong>
</div>
<div id="discharging_part" class="col-12 mt-3">
    @php
        $label='For CFR,CIF,CPT Delivery';
        $name='has_discharging';
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
    <div class="form-check">
        <input {{ $value==1 ? 'checked' : '' }} onchange="has_discharging_change(this)" class="form-check-input"
               type="checkbox"
               value="1"
               id="{{ $name }}"
               name="{{ $name }}">
        <label class="form-check-label" for="{{ $name }}">
            {{ $label }}
        </label>
        @error('has_discharging')
        <p class="input-error-validate">
            {{ $message }}
        </p>
        @enderror
    </div>
</div>
<div id="discharging_options" class="mt-3 d-none">
    <div id="discharging_options_inputs" class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
        @php
            $name='Discharging Type';
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
        <label for="quality_inspection_report" class="mb-2">Loading Type <span class="text-danger">*</span></label>
        <div>
            <div class="form-check form-check-inline mr-3">
                <input onchange="dischargingOption(this)"
                       {{ $value==='Bulk' ? 'checked' : '' }} class="form-check-input"
                       type="radio"
                       name="{{ filed_name($name) }}" id="{{ filed_name($name).'1' }}"
                       value="Bulk">
                <label class="form-check-label"
                       for="{{ filed_name($name).'1' }}">Bulk</label>
            </div>
            <div class="form-check form-check-inline">
                <input onchange="dischargingOption(this)"
                       {{ $value==='Container' ? 'checked' : '' }} class="form-check-input"
                       type="radio"
                       name="{{ filed_name($name) }}" id="{{ filed_name($name).'2' }}"
                       value="Container">
                <label class="form-check-label"
                       for="{{ filed_name($name).'2' }}">Container</label>
            </div>
            <div class="form-check form-check-inline">
                <input onchange="dischargingOption(this)"
                       {{ $value==='Flexi Tank' ? 'checked' : '' }} class="form-check-input"
                       type="radio"
                       name="{{ filed_name($name) }}" id="{{ filed_name($name).'3' }}"
                       value="Flexi Tank">
                <label class="form-check-label"
                       for="{{ filed_name($name).'3' }}">Flexi Tank</label>
            </div>
        </div>
    </div>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div id="discharging_common_section" class="d-none row">
    <div class="col-12">
        <strong>
            Discharging
        </strong>
    </div>
    <div class="col-12 col-md-6 mb-3">
        @php
            $label='Country';
                $name='discharging Country';
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
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <select onchange="hasOther(this)"
                {{ $required }} id="{{ filed_name($name) }}" type="text"
                name="{{ filed_name($name) }}" class="form-control ">
            @foreach($countries as $item)
                <option
                    {{ $value==$item->title ? ' selected="selected"' : '' }}
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
            $label='Port/City';
            $name='discharging Port/City';
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
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <input {{ $required }} id="{{ filed_name($name) }}" type="text"
               name="{{ filed_name($name) }}" class="form-control"
               value="{{ $value }}">
        @error(filed_name($name))
        <p class="input-error-validate">
            {{ $message }}
        </p>
        @enderror
    </div>
    <div class="col-12 mb-1">
        <strong>
            Discharging Period
        </strong>
    </div>
    <div class="col-12 col-md-6 mb-3">
        @php
            $label='From';
            $name='Discharging From';
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
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <input {{ $required }} id="{{ filed_name($name) }}" type="date"
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
            $label='To';
            $name='Discharging To';
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
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <input {{ $required }} id="{{ filed_name($name) }}" type="date"
               name="{{ filed_name($name) }}" class="form-control"
               value="{{ $value }}">
        @error(filed_name($name))
        <p class="input-error-validate">
            {{ $message }}
        </p>
        @enderror
    </div>
</div>

<div id="discharging_options_sections" class="d-none">
    <div id="discharging_options_Bulk" class="discharging_part row">
        <div class="col-12 col-md-5 mb-3">
            @php
                $label='Discharging Rate';
                $name='Bulk Discharging Rate';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="number"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ $value }}">
            @error(filed_name($name))
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="col-12 col-md-2 mb-3">
            <div class="d-flex justify-content-center align-items-end deactive_input">
                PWWD
            </div>
        </div>
        <div class="col-12 col-md-5 mb-3">
            @php
                $label='Shipping Term';
                    $name='Discharging Bulk Shipping Term';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                @foreach($shipping_terms as $item)
                    <option
                        {{ $value==$item->title ? ' selected="selected"' : '' }}
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
                $label='More Details';
                $name='discharging More Details';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ $value }}">
            @error(filed_name($name))
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
    </div>
    <div id="discharging_options_Container" class="discharging_part row">
        <div class="col-12 col-md-6 mb-3">
            @php
                $label='Container Type';
                    $name='Discharging Container Type';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                @foreach($container_types as $item)
                    <option {{ $value==$item->title ? ' selected="selected"' : '' }}
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
                $label='THC Included';
                    $name='Discharging Container THC Included';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                @foreach($thcincluded as $item)
                    <option {{ $value==$item->title ? ' selected="selected"' : '' }}
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
                $label='More Details';
                $name='discharging More Details';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ $value }}">
            @error(filed_name($name))
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
    </div>
    <div id="discharging_options_Flexi_Tank" class="discharging_part row">
        <div class="col-12 col-md-6 mb-3">
            @php
                $label='Flexi Tank Type';
                    $name='Discharging Flexi Tank Type';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                @foreach($flexi_type_tank as $item)
                    <option
                        {{ $value==$item->title ? ' selected="selected"' : '' }}
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
                $label='THC Included';
                    $name='Discharging Flexi Tank THC Included';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                @foreach($thcincluded as $item)
                    <option
                        {{ $value==$item->title ? ' selected="selected"' : '' }}
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
                $label='More Details';
                $name='discharging More Details';
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
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ $value }}">
            @error(filed_name($name))
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
    </div>
</div>

