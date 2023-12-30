<div class="col-12">
    <hr>
    <strong>
        Loading
    </strong>
</div>
<div id="loading_part" class="col-12 mt-3">
    @php
        $label='For EXW,FCA,FOB Delivery';
        $name='has_loading';
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
        <input {{ $value==1 ? 'checked' : '' }} onchange="has_loading_change(this)" class="form-check-input" type="checkbox" value="1" id="{{ $name }}" name="{{ $name }}">
        <label class="form-check-label" for="has_loading">
            {{ $label }}
        </label>
        @error('has_loading')
        <p class="input-error-validate">
            {{ $message }}
        </p>
        @enderror
    </div>
</div>
<div id="loading_options" class="mt-3 d-none">
    <div id="loading_options_inputs" class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
        @php
            $name='Loading Type';
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
        <label for="quality_inspection_report" class="mb-2">Loading Type <span class="text-danger">*</span></label>
        <div>
            <div class="form-check form-check-inline mr-3">
                <input onchange="loadingOption(this)"
                       {{ $value==='Bulk' ? 'checked' : '' }} class="form-check-input"
                       type="radio"
                       name="{{ filed_name($name) }}" id="{{ filed_name($name).'1' }}"
                       value="Bulk">
                <label class="form-check-label"
                       for="{{ filed_name($name).'1' }}">Bulk</label>
            </div>
            <div class="form-check form-check-inline">
                <input onchange="loadingOption(this)"
                       {{ $value==='Container' ? 'checked' : '' }} class="form-check-input"
                       type="radio"
                       name="{{ filed_name($name) }}" id="{{ filed_name($name).'2' }}"
                       value="Container">
                <label class="form-check-label"
                       for="{{ filed_name($name).'2' }}">Container</label>
            </div>
            <div class="form-check form-check-inline">
                <input onchange="loadingOption(this)"
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
<div id="loading_common_section" class="d-none row">
    <div class="col-12 col-md-6 mb-3">
        @php
            $label='Country';
                $name='loading Country';
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
            $name='loading Port/City';
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
            Loading Period
        </strong>
    </div>
    <div class="col-12 col-md-6 mb-3">
        @php
            $label='From';
            $name='Loading From';
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
            $name='Loading To';
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

<div id="loading_options_sections" class="d-none">
    <div id="loading_options_Bulk" class="loading_part row">
        <div class="col-12">
            <strong>
                Loading
            </strong>
        </div>
        <div class="col-12 col-md-5 mb-3">
            @php
                $label='Loading Rate';
                $name='Bulk Loading Rate';
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
                    $name='Loading Bulk Shipping Term';
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
                $name='loading More Details';
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
    <div id="loading_options_Container" class="loading_part row">
        <div class="col-12 col-md-6 mb-3">
            @php
                $label='Container Type';
                    $name='Loading Container Type';
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
                    name="{{ $value }}" class="form-control ">
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
                    $name='Loading Container THC Included';
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
                $name='loading More Details';
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
    <div id="loading_options_Flexi_Tank" class="loading_part row">
        <div class="col-12 col-md-6 mb-3">
            @php
                $label='Flexi Tank Type';
                    $name='Loading Flexi Tank Type';
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
                    $name='Loading Flexi Tank THC Included';
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
                $name='loading More Details';
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

