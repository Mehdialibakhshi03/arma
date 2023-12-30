<div class="col-12 mb-3">
    @php
        $label='More Detail';
            $name='Last More Detail';
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
    <textarea name="{{ filed_name($name) }}" class="form-control form-control-sm" placeholder="{{ $label }}">{{ $value }}</textarea>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 mb-3">
    @php
        $label='I accept all above mentioned terms and conditions are valid for 5 working days';
        $name='accept terms';
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
        <input {{ $value==1?'checked':'' }} name="{{ filed_name($name) }}" class="form-check-input" type="checkbox" value="1" id="{{ filed_name($name) }}">
        <label class="form-check-label" for="{{ filed_name($name) }}">
            {{ $label }}
        </label>
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
