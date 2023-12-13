<div class="col-12 mb-3">
    @php
        $label='More Detail';
            $name='Last More Detail';
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
    <textarea name="{{ filed_name($name) }}" class="form-control form-control-sm">{{ old(filed_name($name)) }}</textarea>
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
    @endphp
    <div class="form-check">
        <input {{ old(filed_name($name))==filed_name($name)?'checked':'' }} name="{{ filed_name($name) }}" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
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
