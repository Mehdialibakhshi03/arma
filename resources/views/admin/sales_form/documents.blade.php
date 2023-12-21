<div class="col-12">
    <hr>
    <div class="mb-3">
        <strong>
            Documents <span class="text-danger">*</span>
        </strong>
    </div>
</div>
<div class="row" id="documents-box">
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='Commercial Invoice';
        @endphp
        <div class="form-check">
            <input readonly onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Packing Lis';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Quantity Certificate';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='Original Bills of Lading ';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Port Clearance Certificate';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Quality Certificate';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='Non-negotiable copies';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Sail Certificate';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='Certificate of Origin';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Cargo Manifes';
        @endphp
        <div class="form-check">
            <input onchange="documentOptions()" class="form-check-input" type="checkbox" value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
    <input type="hidden" name="documents_options" value="" id="documents_options">
    <input type="hidden" name="documents_count" value="" id="documents_count">
    <div class="col-12">
        @if($errors->has('documents_count') or $errors->has('documents_options'))
            <p class="input-error-validate">
                You Have To Choose At Least 2 Documents
            </p>
        @endif
    </div>
</div>




<div class="col-12 mb-3">
    @php
        $label='More Detail';
            $name='Document More Detail';
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
    <textarea name="{{ filed_name($name) }}" class="form-control form-control-sm">{{ $value }}</textarea>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12">
    <hr>
</div>
