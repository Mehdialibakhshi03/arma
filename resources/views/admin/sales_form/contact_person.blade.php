<div class="col-12">
    <strong>
        Nominate a person to coordinate this sales offer with Armaiti supply team
    </strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $label='Name';
        $name='Contact Person Name';
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
        $label='Job Title';
        $name='Contact Person Job Title';
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
        $label='Email';
        $name='Contact Person Email';
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
    <input {{ $required }} id="{{ filed_name($name) }}" type="email"
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
        $label='Mobile Phone(whats app)';
        $name='Contact Person Mobile Phone';
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
    <input {{ $required }} id="{{ filed_name($name) }}" type="email"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ old(filed_name($name)) }}">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>

<div class="col-12">
    <hr>
</div>
