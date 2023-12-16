<div class="col-12">
    <hr>
    <strong>
        Discharging
    </strong>
</div>
<div id="discharging_part" class="col-12 mt-3">
    <div class="form-check">
        <input {{ old('has_discharging')==1 ? 'checked' : '' }} onchange="has_discharging_change(this)" class="form-check-input" type="checkbox" value="1" id="has_discharging" name="has_discharging">
        <label class="form-check-label" for="has_discharging">
            For CFR,CIF,CPT Delivery
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
        @endphp
        <label for="quality_inspection_report" class="mb-2">Loading Type <span class="text-danger">*</span></label>
        <div>
            <div class="form-check form-check-inline mr-3">
                <input onchange="dischargingOption(this)"
                       {{ old(filed_name($name))==='Bulk' ? 'checked' : '' }} class="form-check-input"
                       type="radio"
                       name="{{ filed_name($name) }}" id="{{ filed_name($name).'1' }}"
                       value="Bulk">
                <label class="form-check-label"
                       for="{{ filed_name($name).'1' }}">Bulk</label>
            </div>
            <div class="form-check form-check-inline">
                <input onchange="dischargingOption(this)"
                       {{ old(filed_name($name))==='Container' ? 'checked' : '' }} class="form-check-input"
                       type="radio"
                       name="{{ filed_name($name) }}" id="{{ filed_name($name).'2' }}"
                       value="Container">
                <label class="form-check-label"
                       for="{{ filed_name($name).'2' }}">Container</label>
            </div>
            <div class="form-check form-check-inline">
                <input onchange="dischargingOption(this)"
                       {{ old(filed_name($name))==='Flexi Tank' ? 'checked' : '' }} class="form-check-input"
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
                if ($is_required===1){
                    $required_span='<span class="text-danger">*</span>';
                    $required='required';
                }
        @endphp
        <label for="{{ filed_name($name) }}"
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <select onchange="hasOther(this)"
                {{ $required }} id="{{ filed_name($name) }}" type="text"
                name="{{ filed_name($name) }}" class="form-control ">
            @foreach($countries as $item)
                <option
                    {{ old(filed_name($name))==$item->title ? ' selected="selected"' : '' }}
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
            if ($is_required===1){
                $required_span='<span class="text-danger">*</span>';
                $required='required';
            }
        @endphp
        <label for="{{ filed_name($name) }}"
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <input {{ $required }} id="{{ filed_name($name) }}" type="text"
               name="{{ filed_name($name) }}" class="form-control"
               value="{{ old(filed_name($name)) }}">
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
            if ($is_required===1){
                $required_span='<span class="text-danger">*</span>';
                $required='required';
            }
        @endphp
        <label for="{{ filed_name($name) }}"
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <input {{ $required }} id="{{ filed_name($name) }}" type="date"
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
            $label='To';
            $name='Discharging To';
            $is_required=1;
            $required_span='';
            $required='';
            if ($is_required===1){
                $required_span='<span class="text-danger">*</span>';
                $required='required';
            }
        @endphp
        <label for="{{ filed_name($name) }}"
               class="mb-2">{!! $label.' '.$required_span !!}</label>
        <input {{ $required }} id="{{ filed_name($name) }}" type="date"
               name="{{ filed_name($name) }}" class="form-control"
               value="{{ old(filed_name($name)) }}">
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
                if ($is_required===1){
                    $required_span='<span class="text-danger">*</span>';
                    $required='required';
                }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="number"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ old(filed_name($name)) }}">
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
                    if ($is_required===1){
                        $required_span='<span class="text-danger">*</span>';
                        $required='required';
                    }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                        @foreach($shipping_terms as $item)
                            <option
                                {{ old(filed_name($name))==$item->title ? ' selected="selected"' : '' }}
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
                if ($is_required===1){
                    $required_span='<span class="text-danger">*</span>';
                    $required='required';
                }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ old(filed_name($name)) }}">
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
                    if ($is_required===1){
                        $required_span='<span class="text-danger">*</span>';
                        $required='required';
                    }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                {{--        @foreach($countries as $item)--}}
                {{--            <option--}}
                {{--                {{ old(filed_name($name))==$item->title ? ' selected="selected"' : '' }}--}}
                {{--                value="{{ $item->title }}">{{ $item->title }}</option>--}}
                {{--        @endforeach--}}
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
                    if ($is_required===1){
                        $required_span='<span class="text-danger">*</span>';
                        $required='required';
                    }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                        @foreach($thcincluded as $item)
                            <option
                                {{ old(filed_name($name))==$item->title ? ' selected="selected"' : '' }}
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
                if ($is_required===1){
                    $required_span='<span class="text-danger">*</span>';
                    $required='required';
                }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ old(filed_name($name)) }}">
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
                    if ($is_required===1){
                        $required_span='<span class="text-danger">*</span>';
                        $required='required';
                    }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                {{--        @foreach($countries as $item)--}}
                {{--            <option--}}
                {{--                {{ old(filed_name($name))==$item->title ? ' selected="selected"' : '' }}--}}
                {{--                value="{{ $item->title }}">{{ $item->title }}</option>--}}
                {{--        @endforeach--}}
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
                    if ($is_required===1){
                        $required_span='<span class="text-danger">*</span>';
                        $required='required';
                    }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <select onchange="hasOther(this)"
                    {{ $required }} id="{{ filed_name($name) }}" type="text"
                    name="{{ filed_name($name) }}" class="form-control ">
                {{--        @foreach($countries as $item)--}}
                {{--            <option--}}
                {{--                {{ old(filed_name($name))==$item->title ? ' selected="selected"' : '' }}--}}
                {{--                value="{{ $item->title }}">{{ $item->title }}</option>--}}
                {{--        @endforeach--}}
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
                if ($is_required===1){
                    $required_span='<span class="text-danger">*</span>';
                    $required='required';
                }
            @endphp
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $label.' '.$required_span !!}</label>
            <input {{ $required }} id="{{ filed_name($name) }}" type="text"
                   name="{{ filed_name($name) }}" class="form-control"
                   value="{{ old(filed_name($name)) }}">
            @error(filed_name($name))
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
    </div>
</div>
