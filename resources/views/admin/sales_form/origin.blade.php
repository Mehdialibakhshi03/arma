<div class="col-12">
    <hr>
    <strong>
        Origin
    </strong>
</div>
<div class="col-12 col-md-4 mb-3">
    @php
        $label='Country';
            $name='Origin Country';
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
<div class="col-12 col-md-4 mb-3">
    @php
        $label='Port/City';
        $name='Origin Port/City';
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
<div class="col-12 col-md-4 mb-3">
    @php
        $label='More Details';
        $name='Origin More Details';
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
