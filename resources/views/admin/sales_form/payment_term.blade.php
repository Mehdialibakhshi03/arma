<div class="col-12">
    <hr>
    <strong>
        Payment Term
    </strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Payment Term';
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
    <select onchange="PaymentTerm(this)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control">
        @foreach($paymentTerms as $item)
            <option
                {{ old('payment_term')==$item->title ? ' selected="selected"' : '' }}
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
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Packing';
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
        @foreach($packing as $item)
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
        $name='More Details';
        $is_required=0;
        $required_span='';
        $required='';
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        $text_area_name='packing_'.$name;
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($text_area_name) }}"
           type="text"
           name="{{ filed_name($text_area_name) }}"
           class="form-control"
           value="{{ old(filed_name($text_area_name)) }}">
    @error(filed_name($text_area_name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
